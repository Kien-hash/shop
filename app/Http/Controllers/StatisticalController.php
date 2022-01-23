<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Statistical;

class StatisticalController extends Controller
{
    public function postFilterDate(Request $request)
    {
        $data = $request->all();
        $fromDate = $data['fromDate'];
        $toDate = $data['toDate'];

        $gets = Statistical::whereBetween('date', [$fromDate, $toDate])->orderBy('date', 'ASC')->get();
        foreach ($gets as $get) {
            $chartData[] = array(
                'date' => $get->date,
                'sale_money' => $get->sale_money,
                'profit' => $get->profit,
                'product_quantity' => $get->product_quantity,
                'order_quantity' => $get->order_quantity
            );
        }

        echo $data = json_encode($chartData);
    }
}
