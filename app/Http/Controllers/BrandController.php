<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Brand;

class BrandController extends Controller
{
    public function getAdd()
    {
        return view('admin.brand.add');
    }

    public function getAll()
    {
        $brands = Brand::orderByDesc('id')->get();
        return view('admin.brand.all', ['brands' => $brands]);
    }

    public function postAdd(Request $request)
    {
        $this->validate($request, [
            'name' => 'unique:brands,name',
            'slug' => 'unique:brands,slug',
        ], [
            'name.unique' => 'Please choose another name',
            'slug.unique' => 'Please choose another slug',
        ]);

        $brand = new Brand();
        $brand->name = $request->name;
        $brand->slug = $request->slug;
        $brand->description = $request->description;
        $brand->status = $request->status;
        $brand->keywords = $request->keywords;
        $brand->save();
        return redirect('admin/brand/add')->with('Notice', 'Product brand add successfully');
    }

    public function getInactive($id)
    {
        $brand = Brand::find($id);
        $brand->status = 1;
        $brand->save();
        return redirect('admin/brand/all')->with('Notice', 'Brand disable successfully');;
    }

    public function getActive($id)
    {
        $brand = Brand::find($id);
        $brand->status = 0;
        $brand->save();
        return redirect('admin/brand/all')->with('Notice', 'Brand enable successfully');;
    }

    public function getEdit($id)
    {
        $brand = Brand::find($id);
        return view('admin.brand.edit', ['brand' => $brand]);
    }

    public function postEdit($id, Request $request)
    {
        $brand = Brand::find($id);
        $this->validate(
            $request,
            [
                'name' => 'unique:brands,name,' . $id,
                'slug' => 'unique:brands,slug,' . $id,
            ],
            [
                'name.unique' => 'Please choose another name',
                'slug.unique' => 'Please choose another slug',
            ]
        );
        $brand->name = $request->name;
        $brand->slug = $request->slug;
        $brand->description = $request->description;
        $brand->keywords = $request->keywords;
        $brand->save();
        return redirect('admin/brand/all')->with('Notice', 'Product brand update successfully');
    }

    public function getDelete($id)
    {
        Brand::find($id)->products->delete();
        Brand::find($id)->delete();
        return redirect('admin/brand/all')->with('Notice', 'Product brand delete successfully');;
    }
}
