<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rating;

class RatingController extends Controller
{
    public function postAdd(Request $request)
    {
        $data = $request->all();
        $rating = new Rating();
        $rating->product_id = $data['product_id'];
        $rating->rating = $data['index'];
        $rating->save();
        echo 'done';
    }
}
