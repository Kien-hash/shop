<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Delivery;
use App\City;

class DeliveryController extends Controller
{
    public function getAll()
    {
        $deliveries = Delivery::orderBy('id')->paginate(10);
        $cities = City::orderBy('matp', 'ASC')->get();
        return view('admin.delivery.all', ['deliveries' => $deliveries, 'cities' => $cities]);
    }


    public function postAdd(Request $request)
    {
        $delivery = Delivery::where('xaid',$request->xaid)->first();
        if ($delivery){
            $delivery->fee = $request->fee;
        }else{
            $delivery = new Delivery();
            $delivery->matp = $request->matp;
            $delivery->maqh = $request->maqh;
            $delivery->xaid = $request->xaid;
            $delivery->fee = $request->fee;
        }
        
        $delivery->save();

        return redirect()->back()->with('Notice', 'Fee added successfully!');
    }

    public function getDelete($id)
    {
        Delivery::find($id)->delete();
        return redirect()->back()->with('Notice', 'Fee deleted successfully!');
    }

    public function postEdit($id, Request $request)
    {
        $delivery = Delivery::find($id);
        $delivery->fee = $request->fee;
        $delivery->save();

        return redirect('admin/delivery/all')->with('Notice', 'Fee edited successfully!');
    }
}
