<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Exceptions\UnauthorizedException;
use App\Helpers\ResponseHelper;
use App\Http\Resources\OrderResource;
use App\Http\Resources\ProductPriceResource;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\User;
use App\Repository\Eloquent\OrderRepository;
use App\Repository\Eloquent\ProductRepository;
use App\Repository\Eloquent\RegisterRepository;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class OrderService
{
    public $OrderRepository;

    public function __construct(OrderRepository $OrderRepository)
    {
        $this->OrderRepository = $OrderRepository;
    }

    public function getAllOrdersService()
    {
        $orders = $this->OrderRepository->all();;
        return OrderResource::collection($orders);
    }

    public function addOrderService($request)
    {
        try {
            $user = Auth::user();

            $order = $this->OrderRepository->create(['user_id' => $user->id]);

            $products = $request->input('products', []);

            foreach ($products as $product) {
                $order->products()->attach($product['product_id'], ['quantity' => $product['quantity']]);
            }

            return ResponseHelper::createResponse($order);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->validator->errors()->first()], 422);
        } catch (QueryException $e) {
            return response()->json(['error' => 'Failed to place the order. Please try again.'], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An unexpected error occurred.'], 500);
        }
    }

    public function showOrderService($id)
    {
        $order = $this->OrderRepository->find($id);

        if (!$order) {
            throw new NotFoundException();
        }

        return ResponseHelper::showResponse(new OrderResource($order));
    }

    public function updateOrderService($request, $id)
    {
        try {
            $order = $this->OrderRepository->find($id);

            if (!$order) {
                throw new NotFoundException();
            }

            $user = Auth::user();

            // Checking if the user has permission to update this order
            if ($order->user_id != $user->id) {
                throw new UnauthorizedException();
            }

            // Detach existing products and attach new products to the order
            $order->products()->detach();

            $products = $request->input('products', []);

            foreach ($products as $product) {
                $order->products()->attach($product['product_id'], ['quantity' => $product['quantity']]);
            }

            return ResponseHelper::updateResponse(new OrderResource($order));
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->validator->errors()->first()], 422);
        } catch (QueryException $e) {
            return response()->json(['error' => 'Failed to update the order. Please try again.'], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An unexpected error occurred.'], 500);
        }
    }

    public function deleteOrderService($id)
    {
        $order = $this->OrderRepository->find($id);

        if (!$order) {
            throw new NotFoundException();
        }

        // Detach all products associated with the order and delete the order
        $order->products()->detach();
        $order->delete();

        return ResponseHelper::deleteResponse();
    }
}
