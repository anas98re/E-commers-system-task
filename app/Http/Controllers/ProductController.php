<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Services\ProductService;

class ProductController extends Controller
{
    private $ProductService;

    public function __construct(ProductService $ProductService)
    {
        $this->ProductService = $ProductService;
    }

    public function index()
    {
        return $this->ProductService->getAllProductsService();
    }

    public function store(StoreProductRequest $request)
    {
        return $this->ProductService->addProductService($request);
    }

    public function show($id)
    {
        return $this->ProductService->ShowProductService($id);
    }

    public function update(UpdateProductRequest $request, $id)
    {
        return $this->ProductService->updateProductService($request, $id);
    }

    public function destroy($id)
    {
        return $this->ProductService->deleteProductService($id);
    }
}
