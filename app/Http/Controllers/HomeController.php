<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Brand;
use App\Category;
use App\Product;
use App\Customer;
use App\Comment;
use App\Rating;
use App\Contact;

use Illuminate\Support\Facades\Session;

session_start();

class HomeController extends Controller
{
    public function index()
    {
        if (isset($_GET['sort_by'])) {
            $sort_by = $_GET['sort_by'];
            if ($sort_by == 'increase') {
                // echo 1;
                $products = Product::where('status', '=', 0)->orderBy('price', 'ASC')->paginate(6)->appends(request()->query());
            } elseif ($sort_by == 'decrease') {
                // echo 2;
                $products = Product::where('status', '=', 0)->orderBy('price', 'DESC')->paginate(6)->appends(request()->query());
            } elseif ($sort_by == 'a_to_z') {
                // echo 3;
                $products = Product::where('status', '=', 0)->orderBy('name', 'ASC')->paginate(6)->appends(request()->query());
            } elseif ($sort_by == 'z_to_a') {
                // echo 4;
                $products = Product::where('status', '=', 0)->orderBy('name', 'DESC')->paginate(6)->appends(request()->query());
            } else {
            }
        } elseif (isset($_GET['min_price']) && isset($_GET['max_price'])) {
            $min_price = $_GET['min_price'];
            $max_price = $_GET['max_price'];
            $products = Product::where('status', '=', 0)->whereBetween('price', [$min_price, $max_price])->orderBy('price')->paginate(6)->appends(request()->query());
        } else {
            $products = Product::where('status', '=', 0)->orderByDesc('id')->paginate(6);
        }

        $categories = Category::where('status', '=', 0)->get();
        $brands = Brand::where('status', '=', 0)->get();
        $bestsellers = Product::where('status', '=', 0)->orderByDesc('sold')->limit(3)->get();
        $min_price = Product::where('status', '=', 0)->min('price');
        $max_price = Product::where('status', '=', 0)->max('price');

        return view('pages.home.index')->with(compact('categories', 'brands', 'products', 'bestsellers', 'min_price', 'max_price'));
    }

    public function showCategory($slug)
    {
        $category = Category::where('slug', $slug)->first();
        $ids = array($category->id);
        if ($category->parent_id == 0) {
            $children = Category::where('parent_id', $category->id)->get();
            foreach ($children as $child) {
                array_push($ids, $child->id);
            }
        }
        $name = $category->name;
        $categories = Category::where('status', '=', 0)->get();
        $brands = Brand::where('status', '=', 0)->get();
        $products = Product::where('status', '=', 0)->whereIn('category_id', $ids)->paginate(9);

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
        $comments = Comment::where('status', 0)->where('product_id', $product->id)->get();
        $rating = Rating::where('product_id', $product->id)->avg('rating');
        $rating = round($rating);
        $product->view++;
        $product->save();

        if (Session::get('customer_id')) {
            $customer = Customer::find(Session::get('customer_id'));
            return view('pages.home.detail', ['rating' => $rating, 'comments' => $comments, 'customer' => $customer, 'product' => $product, 'categories' => $categories, 'brands' => $brands, 'relates' => $relates]);
        } else {
            return view('pages.home.detail', ['rating' => $rating, 'comments' => $comments, 'product' => $product, 'categories' => $categories, 'brands' => $brands, 'relates' => $relates]);
        }
    }

    public function getContact()
    {
        $categories = Category::where('status', '=', 0)->get();
        $brands = Brand::where('status', '=', 0)->get();
        $contact = Contact::all()->first();

        return view('pages.home.contact', ['categories' => $categories, 'brands' => $brands, 'contact' => $contact]);
    }
}
