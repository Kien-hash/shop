<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Brand;
use App\Category;
use App\Coupon;
use App\City;
use App\Shipping;
use App\Payment;
use App\Order;
use App\OrderDetail;
use App\Customer;
use Illuminate\Support\Facades\Session;

session_start();

class CartController extends Controller
{
    public function getShowCart()
    {
        $categories = Category::where('status', '=', 0)->get();
        $brands = Brand::where('status', '=', 0)->get();
        return view('pages.cart.index', ['categories' => $categories, 'brands' => $brands,]);
    }

    public function deleteAllCartProduct()
    {
        $cart = Session::get('cart');
        if ($cart == true) {
            Session::forget('cart');
            Session::forget('coupon');
            return redirect()->back()->with('message', 'Tất cả sản phẩm trong giỏ đã được xóa!');
        } else {
            return redirect()->back()->with('message', 'Trong giỏ hàng không có sản phẩm nào!');
        }
    }

    public function postUpdateCart(Request $request)
    {
        $data = $request->all();
        $cart = Session::get('cart');
        if ($cart == true) {
            $message = '';
            foreach ($data['cart_qty'] as $key => $qty) {
                $i = 0;
                foreach ($cart as $session => $val) {
                    $i++;
                    if ($cart[$session]['product_qty'] == $qty) continue;
                    if ($val['session_id'] == $key && $qty < $cart[$session]['product_quantity']) {
                        $cart[$session]['product_qty'] = $qty;
                        $message .= '<p style="color:blue">' . $i . ') Cập nhật số lượng :' . $cart[$session]['product_name'] . ' thành công</p>';
                    } elseif ($val['session_id'] == $key && $qty > $cart[$session]['product_quantity']) {
                        $message .= '<p style="color:red">' . $i . ') Cập nhật số lượng :' . $cart[$session]['product_name'] . ' thất bại</p>';
                    }
                }
            }
            Session::put('cart', $cart);
            return redirect()->back()->with('message', $message);
        } else {
            return redirect()->back()->with('message', 'Cập nhật số lượng thất bại');
        }
    }

    public function deleteProduct($session_id)
    {
        $cart = Session::get('cart');
        if ($cart == true) {
            foreach ($cart as $key => $val) {
                if ($val['session_id'] == $session_id) {
                    unset($cart[$key]);
                }
            }
            Session::put('cart', $cart);
            return redirect()->back()->with('message', 'Xóa sản phẩm thành công!');
        } else {
            return redirect()->back()->with('message', 'Xóa sản phẩm thất bại!');
        }
    }

    public function getUnsetCoupon()
    {
        $coupon = Session::get('coupon');
        if ($coupon == true) {
            Session::forget('coupon');
            return redirect()->back()->with('message', 'Xóa hết giỏ thành công');
        }
    }

    public function getDeleteFee()
    {
        Session::forget('fee');
        return redirect()->back();
    }

    public function postConfirmOrder(Request $request)
    {
        $data = $request->all();

        $customer_id = Session::get('customer_id');
        $customer = Customer::find($customer_id);

        if (!$customer->shipping_id) {
            $shipping = new Shipping();
        } else {
            $shipping = Shipping::find($customer->shipping_id);
        }

        $shipping->name = $data['shipping_name'];
        $shipping->email = $data['shipping_email'];
        $shipping->phone = $data['shipping_phone'];
        $shipping->address = $data['shipping_address'];
        $shipping->notes = $data['shipping_notes'];
        $shipping->save();

        $customer->shipping_id = $shipping->id;
        $customer->save();

        $order = new Order();
        $order->code =  substr(md5(microtime()), rand(0, 26), 5);
        $order->customer_id = $customer_id;
        $order->shipping_id = $shipping->id;
        $order->payment_id = $data['shipping_method'];
        $order->notes = $shipping->notes;
        $order->status = 0;
        $order->coupon = $data['order_coupon'];
        $order->shipping_fee = $data['order_fee'];
        $order->total_price = $data['total_price'];
        $order->save();

        if (Session::get('cart') == true) {
            foreach (Session::get('cart') as $key => $cart) {
                $orderDetail = new OrderDetail();
                $orderDetail->order_id = $order->id;
                $orderDetail->order_code = $order->code;
                $orderDetail->product_id = $cart['product_id'];
                $orderDetail->product_name = $cart['product_name'];
                $orderDetail->product_price = $cart['product_price'];
                $orderDetail->product_sales_quantity = $cart['product_qty'];
                $orderDetail->save();
            }
        }
        Session::forget('coupon');
        Session::forget('fee');
        Session::forget('cart');
    }
}
