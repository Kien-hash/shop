<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\District;
use App\Ward;

class AjaxController extends Controller
{
    public function postSelectDelivery(Request $request)
    {
        $data = $request->all();
        if ($data['action']) {
            $output = '';
            if ($data['action'] == "city") {
                $districts = District::where('matp', $data['ma_id'])->get();
                $output .= '<option value="">----Choose District-----</option>';
                foreach ($districts as $district) {
                    $output .= '<option value="' . $district->maqh . '">' . $district->name . '</option>';
                }
            } else {
                $output .= '<option value="">----Choose Ward-----</option>';
                $wards = Ward::where('maqh', $data['ma_id'])->orderBy('xaid', 'ASC')->get();
                foreach ($wards as $ward) {
                    $output .= '<option value="' . $ward->xaid . '">' . $ward->name . '</option>';
                }
            }
            echo $output;
        }
    }
}
