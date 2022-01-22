<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Payment;

class PaymentController extends Controller
{
    public function getAdd()
    {
        return view('admin.payment.add');
    }

    public function getAll()
    {
        $payments = Payment::orderByDesc('id')->get();
        return view('admin.payment.all', ['payments' => $payments]);
    }

    public function postAdd(Request $request)
    {
        $this->validate($request, [
            'name' => 'unique:payments,name',
        ], [
            'name.unique' => 'Please choose another name',
        ]);

        $payment = new Payment();
        $payment->name = $request->name;
        $payment->description = $request->description;
        $payment->status = $request->status;
        $payment->save();
        return redirect('admin/payment/all')->with('Notice', 'Product payment add successfully');
    }

    public function getInactive($id)
    {
        $payment = Payment::find($id);
        $payment->status = 1;
        $payment->save();
        return redirect('admin/payment/all')->with('Notice', 'Payment disable successfully');;
    }

    public function getActive($id)
    {
        $payment = Payment::find($id);
        $payment->status = 0;
        $payment->save();
        return redirect('admin/payment/all')->with('Notice', 'Payment enable successfully');;
    }

    public function getEdit($id)
    {
        $payment = Payment::find($id);
        return view('admin.payment.edit', ['payment' => $payment]);
    }

    public function postEdit($id, Request $request)
    {
        $payment = Payment::find($id);
        $this->validate(
            $request,
            [
                'name' => 'unique:payments,name,' . $id,
            ],
            [
                'name.unique' => 'Please choose another name',
            ]
        );
        $payment->name = $request->name;
        $payment->description = $request->description;
        $payment->save();
        return redirect('admin/payment/all')->with('Notice', 'Product payment update successfully');
    }

    public function getDelete($id)
    {
        Payment::find($id)->delete();
        return redirect('admin/payment/all')->with('Notice', 'Product payment delete successfully');;
    }
}
