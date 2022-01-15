<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Brand;
use App\Category;
use App\Product;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::where('status', '=', 0)->get();
        $brands = Brand::where('status', '=', 0)->get();
        $products = Product::where('status', '=', 0)->orderByDesc('id')->paginate(6);
        $bestsellers = Product::where('status', '=', 0)->orderByDesc('sold')->limit(3)->get();
        return view('pages.home.index',  ['products' => $products, 'categories' => $categories, 'brands' => $brands, 'bestsellers'=> $bestsellers]);
    }

    public function showCategory($slug)
    {
        $category = Category::where('slug', $slug)->first();
        $name = $category->name;

        $categories = Category::where('status', '=', 0)->get();
        $brands = Brand::where('status', '=', 0)->get();
        $products = Product::where('status', '=', 0)->where('category_id', $category->id)->paginate(9);
        return view('pages.home.category', ['name' => $name, 'products' => $products, 'categories' => $categories, 'brands' => $brands]);
    }

    public function showBrand($slug)
    {
        $brand = Brand::where('slug', $slug)->first();
        $name = $brand->name;

        $categories = Category::where('status', '=', 0)->get();
        $brands = Brand::where('status', '=', 0)->get();
        $products = Product::where('status', '=', 0)->where('brand_id', '=', $brand->id)->paginate(9);
        return view('pages.home.brand', ['name' => $name, 'products' => $products, 'categories' => $categories, 'brands' => $brands]);
    }

    public function postSearch(Request $request)
    {
        $keywords = $request->keywords;

        $categories = Category::where('status', '=', 0)->get();
        $brands = Brand::where('status', '=', 0)->get();
        $search_products = Product::where('name', 'like', '%' . $keywords . '%')->where('status', '=', 0)->paginate(9);

        return view('pages.home.search', ['keywords' => $keywords, 'products' => $search_products, 'categories' => $categories, 'brands' => $brands]);
    }

    public function showDetail($slug)
    {
        $categories = Category::where('status', '=', 0)->get();
        $brands = Brand::where('status', '=', 0)->get();
        $product = Product::where('slug', '=', $slug)->first();
        $relates = Product::where('category_id', $product->category_id)->where('status', 0)->where('id', '!=', $product->id)->paginate(3);
        return view('pages.home.detail', ['product' => $product, 'categories' => $categories, 'brands' => $brands, 'relates'=>$relates]);

    }
}
