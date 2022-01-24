<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Product;
use App\Customer;
use App\Post;
use App\Order;

class AdminController extends Controller
{
    public function getAdminLogin()   {
        return view('admin.login');
    }

    public function showDashboard()
    {
        $product = count(Product::all());
        $customer = count(Customer::all());
        $post = count(Post::all());
        $order = count(Order::all());

        $product_views = Product::orderBy('view', 'DESC')->take(10)->get();
        $post_views = Post::orderBy('view', 'DESC')->take(10)->get();


        return view('admin.dashboard.index')->with(compact('product', 'customer', 'post', 'order','product_views','post_views'));
    }

    public function postAdminLogin(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect('admin/dashboard');
        } else {
            return redirect('admin')->with('Notice', 'Login failed');
        }
    }

    public function getLogout()
    {
        Auth::logout();
        return redirect('/admin');
    }

}
