<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontEnd extends Controller
{
    //
    public function Product(){
        return view('FrontEnd.ShopPage');
    }
    public function Blog(){
        return view('FrontEnd.Blog.Blog');
    }
    public function Blog_Detail(){
        return view('FrontEnd.Blog.Blog-detail');
    }

    public function About(){
        return view('FrontEnd.About');
    }
    public function Contact(){
        return view('FrontEnd.Contact');
    }
}
