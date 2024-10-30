<?php

namespace App\Repository\Eloquent;

use App\Models\Order;
use App\Repository\ProductRepositoryInterface;

class OrderRepository extends BaseRepository implements ProductRepositoryInterface
{
    public function __construct(Order $model)
    {
        parent::__construct($model);
    }


}
