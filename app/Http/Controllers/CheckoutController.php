<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Brand;
use App\Category;
use App\City;
use App\Shipping;
use App\Payment;
use App\Customer;
use Session;

session_start();

class CheckoutController extends Controller
{
    public function getLogin()
    {
        $categories = Category::where('status', '=', 0)->get();
        $brands = Brand::where('status', '=', 0)->get();
        return view('pages.checkout.login', ['categories' => $categories, 'brands' => $brands]);
    }

    public function getLogout()
    {
        Session::flush();
        return redirect('/login-checkout');
    }

    public function postLogin(Request $request)
    {
        $customer = Customer::where('email', '=', $request->email)->first();
        if (Hash::check($request->password, $customer->password)) {
            Session::put('customer_id', $customer->id);
            Session::put('customer_name', $customer->name);
            return redirect('/checkout');
        } else {
            return redirect('/login-checkout');
        };
    }

    public function postSignup(Request $request)
    {
        $customer = new Customer();
        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->password = bcrypt($request->password);
        $customer->phone = $request->phone;
        $customer->save();

        Session::put('customer_id', $customer->id);
        Session::put('customer_name', $customer->name);
        return redirect('/checkout');
    }

    public function getCheckout()
    {
        $categories = Category::where('status', '=', 0)->get();
        $brands = Brand::where('status', '=', 0)->get();
        $cities = City::orderBy('matp', 'ASC')->get();
        $payments = Payment::where('status', '=', 0)->get();
        $customer_id = Session::get('customer_id');
        $shipping = null;
        if ($customer_id) {
            $shipping_id = Customer::find($customer_id)->shipping_id;
            if ($shipping_id) {
                $shipping = Shipping::find($shipping_id);
            }
            return view('pages.cart.index', ['shipping' => $shipping, 'categories' => $categories, 'brands' => $brands, 'cities' => $cities, 'payments' => $payments]);
        } else {
            return redirect()->back()->with('message', 'Authen failed!');
        }
    }

}
