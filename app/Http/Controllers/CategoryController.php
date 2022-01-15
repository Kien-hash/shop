<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;

class CategoryController extends Controller
{
    public function getAdd()
    {
        return view('admin.category.add');
    }

    public function getAll()
    {
        $categories = Category::orderByDesc('id')->paginate(10);
        return view('admin.category.all', ['categories' => $categories]);
    }

    public function postAdd(Request $request)
    {
        $this->validate($request, [
            'name' => 'unique:categories,name',
            'slug' => 'unique:categories,slug',
        ], [
            'name.unique' => 'Please choose another name',
            'slug.unique' => 'Please choose another slug',
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->slug = $request->slug;
        $category->description = $request->description;
        $category->status = $request->status;
        $category->keywords = $request->keywords;
        $category->save();
        return redirect('admin/category/all')->with('Notice', 'Product category add successfully');
    }

    public function getInactive($id)
    {
        $category = Category::find($id);
        $category->status = 1;
        $category->save();
        return redirect('admin/category/all')->with('Notice', 'Category disable successfully');;
    }

    public function getActive($id)
    {
        $category = Category::find($id);
        $category->status = 0;
        $category->save();
        return redirect('admin/category/all')->with('Notice', 'Category enable successfully');;
    }

    public function getEdit($id)
    {
        $category = Category::find($id);
        return view('admin.category.edit', ['category' => $category]);
    }

    public function postEdit($id, Request $request)
    {
        $category = Category::find($id);
        $this->validate(
            $request,
            [
                'name' => 'unique:categories,name,' . $id,
                'slug' => 'unique:categories,slug,' . $id,
            ],
            [
                'name.unique' => 'Please choose another name',
                'slug.unique' => 'Please choose another slug',
            ]
        );
        $category->name = $request->name;
        $category->slug = $request->slug;
        $category->description = $request->description;
        $category->keywords = $request->keywords;
        $category->save();
        return redirect('admin/category/all')->with('Notice', 'Product category update successfully');
    }

    public function getDelete($id)
    {
        Category::find($id)->delete();
        return redirect('admin/category/all')->with('Notice', 'Product category delete successfully');;
    }
}
