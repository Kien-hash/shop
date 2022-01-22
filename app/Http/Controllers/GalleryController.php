<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Gallery;
use App\Product;

class GalleryController extends Controller
{
    public function getAll($product_id)
    {
        $galleries = Gallery::where('product_id', $product_id)->get();
        $product = Product::find($product_id);
        return view('admin.gallery.all', ['galleries' => $galleries, 'product' => $product]);
    }

    public function postAdd(Request $request)
    {
        $images = $request->file('file');
        if ($images) {
            foreach ($images as $image) {
                if ($image) {
                    // save image to public/uploads/gallery
                    $get_name_image = $image->getClientOriginalName();
                    $name_image = current(explode('.', $get_name_image));
                    $new_image =  $name_image . rand(0, 99) . '.' . $image->getClientOriginalExtension();
                    $image->move('public/uploads/gallery', $new_image);

                    // Create new gallery
                    $gallery = new Gallery();
                    $gallery->name = $new_image;
                    $gallery->image = $new_image;
                    $gallery->product_id = $request->product_id;
                    $gallery->save();
                } else {
                }
            }
            return redirect()->back()->with('Notice', 'Gallery add successfully!');
        } else {
            return redirect()->back()->withError('Image must valid!');
        }
    }

    public function postEdit($id, Request $request)
    {
        $gallery = Gallery::find($id);
        $image = $request->file('image');
        if ($image) {
            // delete old gallery
            unlink('public/uploads/gallery/' . $gallery->image);

            // save to upload directory
            $get_name_image = $image->getClientOriginalName();
            $name_image = current(explode('.', $get_name_image));
            $new_image =  $name_image . rand(0, 99) . '.' . $image->getClientOriginalExtension();
            $image->move('public/uploads/gallery', $new_image);

            // change database
            $gallery->name = $request->name;
            $gallery->image = $new_image;
        } else {
            $gallery->name = $request->name;
        }

        $gallery->save();
        return redirect()->back()->with('Notice', 'Gallery update successfully!');
    }

    public function getDelete($id)
    {
        $gallery = Gallery::find($id);
        unlink('public/uploads/gallery/' . $gallery->image);
        $gallery->delete();
        return redirect()->back()->with('Notice', 'Gallery deleted successfully!');
    }
}
