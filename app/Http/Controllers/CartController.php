<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Brand;
use App\Category;
use App\Coupon;
use App\City;
use App\Payment;
use Session;

session_start();

class CartController extends Controller
{
    public function getShowCart()
    {
        $categories = Category::where('status', '=', 0)->get();
        $brands = Brand::where('status', '=', 0)->get();
        $cities = City::orderBy('matp', 'ASC')->get();
        $payments = Payment::where('status', '=', 0)->get();
        return view('pages.cart.index', ['categories' => $categories, 'brands' => $brands, 'cities' => $cities, 'payments' => $payments]);
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
}
