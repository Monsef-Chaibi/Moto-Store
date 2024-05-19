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
        $products = Product::inRandomOrder()->take(16)->get(); // Fetch 16 random products
        return view('welcome', compact('categories', 'products'));
    }
    public function Product(){
        $categories = Category::all();
        return view('FrontEnd.ShopPage')->with('categories',$categories);
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
    public function getProducts(Request $request)
    {
        $limit = $request->input('limit', 12); // Number of products to fetch
        $offset = $request->input('offset', 0); // Offset for pagination

        $products = Product::with('category')
            ->skip($offset)
            ->take($limit)
            ->get();

        return response()->json($products);
    }

}
