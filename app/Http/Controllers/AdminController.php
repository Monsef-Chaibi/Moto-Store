<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function Dashboard(){
        return view('FrontEnd.AdminDash.FrontEnd.Dash');
    }
    public function Category(){
        return view('FrontEnd.AdminDash.FrontEnd.Category.Category');
    }
}
