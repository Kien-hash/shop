<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PostCategory;
use App\Category;
use App\Brand;
use App\Post;

class HomePostController extends Controller
{
    public function getPostCategory($slug)
    {
        $categories = Category::where('status', '=', 0)->get();
        $brands = Brand::where('status', '=', 0)->get();
        $postCategory = PostCategory::where('slug', $slug)->first();
        $posts = Post::where('category_id', $postCategory->id)->paginate(10);

        return view('pages.post.category', ['posts' => $posts, 'postCategory' => $postCategory, 'brands' => $brands, 'categories' => $categories]);
    }

    public function getPost($slug){
        $categories = Category::where('status', '=', 0)->get();
        $brands = Brand::where('status', '=', 0)->get();
        $post = Post::where('slug', $slug)->first();

        return view('pages.post.index', ['post' => $post, 'brands' => $brands, 'categories' => $categories]);
    }

}
