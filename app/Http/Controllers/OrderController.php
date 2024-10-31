<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Services\OrderService;

class OrderController extends Controller
{
    private $OrderService;

    public function __construct(OrderService $OrderService)
    {
        $this->OrderService = $OrderService;
    }

    public function index()
    {
        return $this->OrderService->getAllOrdersService();
    }

    public function store(StoreOrderRequest $request)
    {
        return $this->OrderService->addOrderService($request);
    }

    public function show($id)
    {
        return $this->OrderService->showOrderService($id);
    }

    public function update(UpdateOrderRequest $request, $id)
    {
        return $this->OrderService->updateOrderService($request, $id);
    }

    public function destroy($id)
    {
        return $this->OrderService->deleteOrderService($id);
    }
}
