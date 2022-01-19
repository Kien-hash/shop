<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\OrderDetail;
use App\Shipping;
use App\Delivery;

class OrderController extends Controller
{
    public function getAll()
    {
        $orders = Order::orderByDesc('id')->paginate(10);
        return view('admin.order.all',['orders' => $orders]);
    }

    public function getEdit($id){
        $order = Order::find($id);
        return view('admin.order.edit',['order' => $order]);
    }
}
