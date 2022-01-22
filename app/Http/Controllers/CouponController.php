<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Coupon;

class CouponController extends Controller
{
    public function getAll()
    {
        $coupons = Coupon::orderByDesc('id')->get();
        return view('admin.coupon.all', ['coupons' => $coupons]);
    }

    public function getAdd()
    {
        return view('admin.coupon.add');
    }

    public function postAdd(Request $request)
    {
        $coupon = new Coupon();

        $coupon->name = $request->name;
        $coupon->code = $request->code;
        $coupon->quantity = $request->quantity;
        $coupon->amount = $request->amount;
        $coupon->type = $request->type;

        $coupon->save();

        return redirect('admin/coupon/all')->with('Notice', 'Coupon added successfully');
    }

    public function getDelete($id)
    {
        Coupon::find($id)->delete();
        return redirect('admin/coupon/all')->with('Notice', 'Product coupon delete successfully');
    }

    public function getEdit($id)
    {
        $coupon = Coupon::find($id);
        return view('admin.coupon.edit', ['coupon' => $coupon]);
    }

    public function postEdit($id, Request $request)
    {
        $coupon = Coupon::find($id);

        $coupon->name = $request->name;
        $coupon->code = $request->code;
        $coupon->quantity = $request->quantity;
        $coupon->amount = $request->amount;
        $coupon->type = $request->type;

        $coupon->save();

        return redirect('admin/coupon/all')->with('Notice', 'Coupon ' . $request->name . ' update successfully!');
    }
}
