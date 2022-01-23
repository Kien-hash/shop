<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Statistical;
use Carbon\Carbon;

class StatisticalController extends Controller
{
    public function postFilterDate(Request $request)
    {
        $data = $request->all();
        $fromDate = $data['fromDate'];
        $toDate = $data['toDate'];

        $gets = Statistical::whereBetween('date', [$fromDate, $toDate])->orderBy('date', 'ASC')->get();
        if (count($gets)) {
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
        } else {
            echo $data = json_encode('error');
        }
    }

    public function postFilterSelect(Request $request)
    {
        $data = $request->all();
        $today = Carbon::now()->toDateString();
        $sub7days = Carbon::now()->subdays(7);
        $sub30days = Carbon::now()->subdays(30);
        $sub365days = Carbon::now()->subdays(365);
        $chartData = (array) null;

        if ($data['value'] == 'lastWeek') {
            for ($i = 0; $i < 7; $i++) {
                $date = $sub7days->addDay(1)->toDateString();
                $get = Statistical::where('date', $date)->first();
                if ($get) {
                    $chartData[] = array(
                        'date' => $date,
                        'sale_money' => $get->sale_money,
                        'profit' => $get->profit,
                        'product_quantity' => $get->product_quantity,
                        'order_quantity' => $get->order_quantity
                    );
                } else {
                    $chartData[] = array(
                        'date' => $date,
                        'sale_money' => 0,
                        'profit' => 0,
                        'product_quantity' => 0,
                        'order_quantity' => 0
                    );
                }
            }
        } elseif ($data['value'] == 'lastMonth') {
            for ($j = 0; $j < 30; $j++) {
                $date = $sub30days->addDay(1)->toDateString();
                $get = Statistical::where('date', $date)->first();
                if ($get) {
                    $chartData[] = array(
                        'date' => $date,
                        'sale_money' => $get->sale_money,
                        'profit' => $get->profit,
                        'product_quantity' => $get->product_quantity,
                        'order_quantity' => $get->order_quantity
                    );
                } else {
                    $chartData[] = array(
                        'date' => $date,
                        'sale_money' => 0,
                        'profit' => 0,
                        'product_quantity' => 0,
                        'order_quantity' => 0
                    );
                }
            }
        } elseif ($data['value'] == 'lastYear') {
            for ($k = 0; $k < 365; $k++) {
                $date = $sub365days->addDay(1)->toDateString();
                $get = Statistical::where('date', $date)->first();
                if ($get) {
                    $chartData[] = array(
                        'date' =>  $date ,
                        'sale_money' => $get->sale_money,
                        'profit' => $get->profit,
                        'product_quantity' => $get->product_quantity,
                        'order_quantity' => $get->order_quantity
                    );
                } else {
                    $chartData[] = array(
                        'date' => $date ,
                        'sale_money' => 0,
                        'profit' => 0,
                        'product_quantity' => 0,
                        'order_quantity' => 0
                    );
                }
            }
        } else {
            echo 'error';
            return;
        }

        echo $data = json_encode($chartData);
    }
}
