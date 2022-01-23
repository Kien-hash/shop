<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Coupon;
use App\Order;
use App\OrderDetail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Statistical;


class OrderController extends Controller
{
    public function getAll()
    {
        $orders = Order::orderByDesc('id')->get();
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
        $coupon = Coupon::where('code', $order->coupon)->first();

        if ($order->status == 0) {
            // Đang xử lý -> xác nhận
            // Send mail to customer
            $to_name = 'Shop Bán Hàng';
            $to_email = $order->shipping->email; //send to this email

            $data = array('order' => $order, 'coupon' => $coupon); //body of mail.blade.php
            Mail::send('pages.mail.index', $data, function ($message) use ($to_name, $to_email) {
                $message->to($to_email)->subject('Thông báo đặt hàng thành công'); //send this mail with subject
                $message->from($to_email, $to_name); //send from this mail
            });

            // Coupon used
            $coupon->quantity = $coupon->quantity - 1;
            $coupon->save();
        }
        if ($order->status == 1) {
            // Xác nhận -> chuyển hàng
            foreach ($order->order_details as $detail) {
                $product = $detail->product;
                $product->quantity = $product->quantity - $detail->product_sales_quantity;
                $product->sold = $detail->product_sales_quantity;
                $product->save();
            }
        }
        if ($order->status == 2) {
            // Chuyển hàng -> kêt thúc
            // Get statistical infomation
            $today = Carbon::now()->toDateString();
            $statistical = Statistical::where('date', $today)->first();
            if (count($statistical)) {
                foreach ($order->order_details as $detail) {
                    $product = $detail->product;
                }
            }


            // Get


            // Payment use in here
        }
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
        // $order->total_price = $request->total_price;
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

    public function postTotalPrice(Request $request)
    {
        $data = $request->all();
        $order = Order::find($data['id']);
        $order->total_price = $data['total'];
        $order->save();
        echo 'successfully';

    }
}
