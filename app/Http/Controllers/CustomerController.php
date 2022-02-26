<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;

class CustomerController extends Controller
{
    public function getAll(){
        $customers = Customer::all();
        return view('admin.customer.all',['customers' => $customers]);
    }
}
