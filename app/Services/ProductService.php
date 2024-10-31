<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Exceptions\UnauthorizedException;
use App\Helpers\ResponseHelper;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\User;
use App\Repository\Eloquent\ProductRepository;
use App\Repository\Eloquent\RegisterRepository;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;

class ProductService
{
    public $ProductRepository;
    public function __construct(ProductRepository $ProductRepository)
    {
        $this->ProductRepository = $ProductRepository;
    }

    public function getAllProductsService()
    {
        $products = $this->ProductRepository->all();
        return ProductResource::collection($products);
    }

    public function addProductService($request)
    {
        try {
            $user = Auth::user();

            $data = $request->validated();
            $data['user_id'] = $user->id;

            $product = $this->ProductRepository->create($data);

            return ResponseHelper::createResponse(new ProductResource($product));
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->validator->errors()->first()], 422);
        } catch (QueryException $e) {
            return response()->json(['error' => 'Failed to create the product. Please try again.'], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An unexpected error occurred.'], 500);
        }
    }

    public function ShowProductService($id)
    {

        $product = $this->ProductRepository->find($id);

        if (!$product) {
            throw  new NotFoundException();
        }
        return ResponseHelper::showResponse(new ProductResource($product));
    }

    public function updateProductService($request, $id)
    {
        $product = $this->ProductRepository->find($id);
        if (!$product) {
            throw new NotFoundException();
        }
        if ($product->user_id != Auth::user()->id) {
            throw new UnauthorizedException();
        }
        $data = $request->validated();
        $dataUpdate = $this->ProductRepository->update($data);
        return ResponseHelper::updateResponse(new ProductResource($dataUpdate));
    }

    public function deleteProductService($id)
    {
        $product = $this->ProductRepository->find($id);
        if (!$product) {
            throw new NotFoundException();
        }
        if ($product->user_id != Auth::user()->id) {
            throw new UnauthorizedException();
        }
        $this->ProductRepository->delete($id);

        return ResponseHelper::deleteResponse();
    }
}
