<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Coupon;
use App\Order;
use App\OrderDetail;
use App\Shipping;
use App\Delivery;

class OrderController extends Controller
{
    public function getAll()
    {
        $orders = Order::orderByDesc('id')->paginate(10);
        return view('admin.order.all', ['orders' => $orders]);
    }

    public function getEdit($id)
    {
        $order = Order::find($id);
        $coupon = Coupon::where('code', $order->coupon)->first();
        return view('admin.order.edit', ['order' => $order, 'coupon' => $coupon]);
    }

    public function getStatus($id)
    {
        $order = Order::find($id);
        if ($order->status < 3) $order->status = $order->status + 1;
        $order->save();
        return redirect()->back()->with('Notice', 'Status update successfully!');
    }

    public function getDeleteDetail($id)
    {
        OrderDetail::find($id)->delete();
        // echo 'success!';
        return redirect()->back()->with('Notice', 'Product delete successfully!');
    }

    public function postEdit($id, Request $request)
    {
        $order = Order::find($id);
        $order->code = $request->code;
        $order->shipping_fee = $request->shipping_fee;
        $order->notes = $request->notes;
        $order->save();

        $shipping = $order->shipping;
        $shipping->name = $request->shipping_name;
        $shipping->address = $request->shipping_address;
        $shipping->phone = $request->shipping_phone;
        $shipping->email = $request->shipping_email;
        $shipping->notes = $request->shipping_notes;
        $shipping->save();

        $i = 0;
        foreach ($order->order_details as $detail) {
            $detail->product_sales_quantity = $request->sale_amount[$i++];
            $detail->save();
        }

        return redirect()->back()->with('Notice', 'Order update successfully!');
    }
}
