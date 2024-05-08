<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontEnd extends Controller
{
    //
    public function Product(){
        return view('FrontEnd.ShopPage');
    }
}
