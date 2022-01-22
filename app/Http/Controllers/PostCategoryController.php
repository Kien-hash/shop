<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PostCategory;

class PostCategoryController extends Controller
{
    public function getAdd()
    {
        return view('admin.postCategory.add');
    }

    public function getAll()
    {
        $postCategories = PostCategory::orderByDesc('id')->get();
        return view('admin.postCategory.all', ['postCategories' => $postCategories]);
    }

    public function postAdd(Request $request)
    {
        $this->validate($request, [
            'name' => 'unique:post_categories,name',
            'slug' => 'unique:post_categories,slug',
        ], [
            'name.unique' => 'Please choose another name',
            'slug.unique' => 'Please choose another slug',
        ]);

        $postCategory = new PostCategory();
        $postCategory->name = $request->name;
        $postCategory->slug = $request->slug;
        $postCategory->description = $request->description;
        $postCategory->status = $request->status;
        $postCategory->keywords = $request->keywords;
        $postCategory->save();
        return redirect('admin/postCategory/all')->with('Notice', 'Product postCategory add successfully');
    }

    public function getInactive($id)
    {
        $postCategory = PostCategory::find($id);
        $postCategory->status = 1;
        $postCategory->save();
        return redirect('admin/postCategory/all')->with('Notice', 'PostCategory disable successfully');;
    }

    public function getActive($id)
    {
        $postCategory = PostCategory::find($id);
        $postCategory->status = 0;
        $postCategory->save();
        return redirect('admin/postCategory/all')->with('Notice', 'PostCategory enable successfully');;
    }

    public function getEdit($id)
    {
        $postCategory = PostCategory::find($id);
        return view('admin.postCategory.edit', ['postCategory' => $postCategory]);
    }

    public function postEdit($id, Request $request)
    {
        $postCategory = PostCategory::find($id);
        $this->validate(
            $request,
            [
                'name' => 'unique:post_categories,name,' . $id,
                'slug' => 'unique:post_categories,slug,' . $id,
            ],
            [
                'name.unique' => 'Please choose another name',
                'slug.unique' => 'Please choose another slug',
            ]
        );
        $postCategory->name = $request->name;
        $postCategory->slug = $request->slug;
        $postCategory->description = $request->description;
        $postCategory->keywords = $request->keywords;
        $postCategory->save();
        return redirect('admin/postCategory/all')->with('Notice', 'Product postCategory update successfully');
    }

    public function getDelete($id)
    {
        PostCategory::find($id)->delete();
        return redirect('admin/postCategory/all')->with('Notice', 'Product postCategory delete successfully');;
    }
}
