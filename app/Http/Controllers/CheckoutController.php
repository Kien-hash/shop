<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Brand;
use App\Category;
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
        return view('pages.checkout.show', ['categories' => $categories, 'brands' => $brands]);
    }

}
