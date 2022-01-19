<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Banner;

class BannerController extends Controller
{
    public function getAdd()
    {
        return view('admin.banner.add');
    }

    public function getAll()
    {
        $banners = Banner::orderByDesc('id')->paginate(10);
        return view('admin.banner.all', ['banners' => $banners]);
    }

    public function postAdd(Request $request)
    {
        $this->validate($request, [
            'name' => 'unique:banners,name',
        ], [
            'name.unique' => 'Please choose another name',
        ]);

        $banner = new Banner();
        $banner->name = $request->name;
        $banner->description = $request->description;
        $banner->status = $request->status;
        $get_image = $request->file('image');
        if ($get_image) {
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.', $get_name_image));
            $new_image =  $name_image . rand(0, 99) . '.' . $get_image->getClientOriginalExtension();
            $get_image->move('public/uploads/banner', $new_image);
            $banner->image = $new_image;
        } else {
            $banner->image = '';
        }
        $banner->save();
        return redirect('admin/banner/all')->with('Notice', 'Product banner add successfully');
    }

    public function getInactive($id)
    {
        $banner = Banner::find($id);
        $banner->status = 1;
        $banner->save();
        return redirect('admin/banner/all')->with('Notice', 'Banner disable successfully');;
    }

    public function getActive($id)
    {
        $banner = Banner::find($id);
        $banner->status = 0;
        $banner->save();
        return redirect('admin/banner/all')->with('Notice', 'Banner enable successfully');;
    }

    public function getEdit($id)
    {
        $banner = Banner::find($id);
        return view('admin.banner.edit', ['banner' => $banner]);
    }

    public function postEdit($id, Request $request)
    {
        $banner = Banner::find($id);
        $this->validate(
            $request,
            [
                'name' => 'unique:banners,name,' . $id,
            ],
            [
                'name.unique' => 'Please choose another name',
            ]
        );
        $banner->name = $request->name;
        $banner->description = $request->description;
        $get_image = $request->file('image');
        if ($get_image) {
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.', $get_name_image));
            $new_image =  $name_image . rand(0, 99) . '.' . $get_image->getClientOriginalExtension();
            $get_image->move('public/uploads/banner', $new_image);
            $banner->image = $new_image;
        } else {
        }
        $banner->save();
        return redirect('admin/banner/all')->with('Notice', 'Product banner update successfully');
    }

    public function getDelete($id)
    {
        Banner::find($id)->delete();
        return redirect('admin/banner/all')->with('Notice', 'Product banner delete successfully');;
    }
}
