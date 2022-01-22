<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\District;
use App\Ward;
use App\Delivery;
use App\Coupon;
use App\Product;

use Session;

session_start();

class AjaxController extends Controller
{
    public function postSelectDelivery(Request $request)
    {
        $data = $request->all();
        if ($data['action']) {
            $output = '';
            if ($data['action'] == "city") {
                $districts = District::where('matp', $data['ma_id'])->get();
                $output .= '<option value="">----Choose District-----</option>';
                foreach ($districts as $district) {
                    $output .= '<option value="' . $district->maqh . '">' . $district->name . '</option>';
                }
            } else {
                $output .= '<option value="">----Choose Ward-----</option>';
                $wards = Ward::where('maqh', $data['ma_id'])->orderBy('xaid', 'ASC')->get();
                foreach ($wards as $ward) {
                    $output .= '<option value="' . $ward->xaid . '">' . $ward->name . '</option>';
                }
            }
            echo $output;
        }
    }

    public function postAddCartAjax(Request $request)
    {
        $data = $request->all();
        $session_id = substr(md5(microtime()), rand(0, 26), 5);
        $cart = Session::get('cart');
        if ($cart == true) {
            $is_avaiable = 0;
            foreach ($cart as $key => $val) {
                if ($val['product_id'] == $data['cart_product_id']) {
                    $is_avaiable++;
                }
            }
            if ($is_avaiable == 0) {
                $cart[] = array(
                    'session_id' => $session_id,
                    'product_name' => $data['cart_product_name'],
                    'product_id' => $data['cart_product_id'],
                    'product_image' => $data['cart_product_image'],
                    'product_quantity' => $data['cart_product_quantity'],
                    'product_qty' => $data['cart_product_qty'],
                    'product_price' => $data['cart_product_price'],
                );
                Session::put('cart', $cart);
            }
        } else {
            $cart[] = array(
                'session_id' => $session_id,
                'product_name' => $data['cart_product_name'],
                'product_id' => $data['cart_product_id'],
                'product_image' => $data['cart_product_image'],
                'product_quantity' => $data['cart_product_quantity'],
                'product_qty' => $data['cart_product_qty'],
                'product_price' => $data['cart_product_price'],
            );
            Session::put('cart', $cart);
        }

        Session::save();
    }

    public function postCalculateFee(Request $request)
    {
        $data = $request->all();
        if ($data['matp']) {
            $default = Delivery::find(1);
            $feeship = Delivery::where('matp', $data['matp'])->where('maqh', $data['maqh'])->where('xaid', $data['xaid'])->get();
            if ($feeship) {
                $count_feeship = $feeship->count();
                if ($count_feeship > 0) {
                    foreach ($feeship as $key => $fee) {
                        Session::put('fee', $fee->fee);
                        Session::save();
                    }
                } else {
                    Session::put('fee', $default->fee);
                    Session::save();
                }
            }
        }
    }

    public function postCheckCoupon(Request $request)
    {
        $data = $request->all();
        $code = null;
        $coupon = Coupon::where('code', $data['coupon'])->first();
        if ($coupon) {
            $count_coupon = $coupon->count();
            if ($count_coupon > 0) {
                $coupon_session = Session::get('coupon');
                if ($coupon_session == true) {
                    $is_avaiable = 0;
                    if ($is_avaiable == 0) {
                        $cou[] = array(
                            'coupon_code' => $coupon->code,
                            'coupon_type' => $coupon->type,
                            'coupon_amount' => $coupon->amount,
                        );
                        Session::put('coupon', $cou);
                    }
                } else {
                    $cou[] = array(
                        'coupon_code' => $coupon->code,
                        'coupon_type' => $coupon->type,
                        'coupon_amount' => $coupon->amount,
                    );
                    Session::put('coupon', $cou);
                }
                Session::save();
                echo $coupon->code;
            }
        } else {
            echo $code;
        }
    }

    public function postSearch(Request $request)
    {
        $data = $request->all();
        if ($data['query']) {
            $products = Product::where('status', 0)->where('name', 'LIKE', '%' . $data['query'] . '%')->get();
            $output = '
            <ul class="dropdown-menu" style="display:block; position:absolute;">
            ';
            foreach ($products as $product) {
                $output .=
                '
                <li class="li-search-ajax"><a href="details/' . $product->slug . '">' . $product->name . '</a></li>
                ';
            }
            $output .= '</ul>';
            echo $output;
        }
    }
}
