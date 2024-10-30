<?php

namespace App\Services;

use App\Http\Resources\ProductPriceResource;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\User;
use App\Repository\Eloquent\ProductRepository;
use App\Repository\Eloquent\RegisterRepository;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class OrderService
{
    public $ProductRepository;
    public function __construct(ProductRepository $ProductRepository)
    {
        $this->ProductRepository = $ProductRepository;
    }

}
