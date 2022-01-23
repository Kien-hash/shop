<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Category;
use App\Brand;
use Exception;

class ProductController extends Controller
{
    //
    public function getAdd()
    {
        $categories = Category::all();
        $brands = Brand::all();
        return view('admin.product.add', ['categories' => $categories, 'brands' => $brands]);
    }

    public function getAll()
    {
        $products = Product::orderByDesc('id')->get();
        return view('admin.product.all', ['products' => $products]);
    }

    public function postAdd(Request $request)
    {
        $this->validate(
            $request,
            [
                'name' => 'unique:products,name',
                'slug' => 'unique:products,slug',
            ],
            [
                'name.unique' => 'Please choose another name',
                'slug.unique' => 'Please choose another slug',
            ]
        );
        $product = new Product();
        $product->name = $request->name;
        $product->quantity = $request->quantity;

        $product->slug = $request->slug;
        $product->cost = $request->cost;
        $product->keywords = $request->keywords;

        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;
        $product->price = $request->price;
        $product->content = $request->content;
        $product->description = $request->description;
        $product->status = $request->status;

        $get_image = $request->file('image');
        if ($get_image) {
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.', $get_name_image));
            $new_image =  $name_image . rand(0, 99) . '.' . $get_image->getClientOriginalExtension();
            $get_image->move('public/uploads/product', $new_image);
            $product->image = $new_image;
        } else {
            $product->image = '';
        }

        $product->save();
        return redirect('admin/product/all')->with('Notice', 'Product added successfully');
    }

    public function getInactive($id)
    {
        // DB::table('product')->where('id', $id)->update(['status' => 1]);
        $product = Product::find($id);
        $product->status = 1;
        $product->save();
        return redirect('admin/product/all')->with('Notice', 'Product disable successfully');
    }

    public function getActive($id)
    {
        // DB::table('product')->where('id', $id)->update(['status' => 0]);
        $product = Product::find($id);
        $product->status = 0;
        $product->save();
        return redirect('admin/product/all')->with('Notice', 'Product enable successfully');
    }

    public function getEdit($id)
    {
        $product = Product::find($id);
        $categories = Category::all();
        $brands = Brand::all();
        return view('admin.product.edit', ['product' => $product, 'categories' => $categories, 'brands' => $brands]);
    }

    public function postEdit($id, Request $request)
    {
        $this->validate(
            $request,
            [
                'name' => 'unique:products,name,' . $id,
                'slug' => 'unique:products,slug,' . $id,
            ],
            [
                'name.unique' => 'Please choose another name',
                'slug.unique' => 'Please choose another slug',
            ]
        );
        $product = Product::find($id);
        $product->name = $request->name;
        $product->quantity = $request->quantity;

        $product->slug = $request->slug;
        $product->keywords = $request->keywords;
        $product->cost = $request->cost;

        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;
        $product->price = $request->price;
        $product->content = $request->content;
        $product->description = $request->description;
        $product->status = $request->status;

        $get_image = $request->file('image');
        if ($get_image) {
            if ($product->image) {
                try {
                    unlink('public/uploads/product/' . $product->image);
                } catch (Exception $e) {
                }
            }
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.', $get_name_image));
            $new_image =  $name_image . rand(0, 99) . '.' . $get_image->getClientOriginalExtension();
            $get_image->move('public/uploads/product', $new_image);
            $product->image = $new_image;
        } else {
        }
        $product->save();

        return redirect('admin/product/all')->with('Notice', 'Product update successfully');
    }

    public function getDelete($id)
    {
        $product = Product::find($id);
        $product->delete();
        return redirect('admin/product/all')->with('Notice', 'Product deleted successfully');
    }
}
