<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class FrontEnd extends Controller
{
    //


    public function Index()
    {
        $categories = Category::all();
        $products = Product::all(); // Fetch all products
        return view('welcome', compact('categories', 'products'));
    }
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
    public function Login(){
        return view('FrontEnd.Auth.Login');
    }
    public function Register(){
        return view('FrontEnd.Auth.Register');
    }
    public function show(Product $product)
    {
        return response()->json($product);
    }
}
