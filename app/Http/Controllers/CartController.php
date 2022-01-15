<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Brand;
use App\Category;

class CartController extends Controller
{
    public function getShowCart()
    {
        $categories = Category::where('status', '=', 0)->get();
        $brands = Brand::where('status', '=', 0)->get();
        return view('pages.cart.index', ['categories' => $categories, 'brands' => $brands]);
    }
}
