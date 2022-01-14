<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Brand;
use App\Category;
use App\Product;

class HomeController extends Controller
{
    public function index(){
        $categories = Category::where('status', '=', 0)->get();
        $brands = Brand::where('status', '=', 0)->get();
        $products = Product::where('status', '=', 0)->orderByDesc('id')->limit(6)->get();
        return view('pages.home.index',  ['products' => $products, 'categories' => $categories, 'brands' => $brands]);
    }
}
