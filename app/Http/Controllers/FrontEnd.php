<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Checkout\Session;
use Stripe\Stripe;

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

    public function ProductDetails($id)
    {
        $product = Product::findOrFail($id);

        // Fetch 10 random products with the same category
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->inRandomOrder()
            ->limit(10)
            ->get();

        return view('FrontEnd.ProductDetails', compact('product', 'relatedProducts'));
    }

    public function checkLogin() {
        return response()->json(['loggedIn' => Auth::check()]);
    }

    public function CheckOut()
    {
        return view('FrontEnd.CheckOut');
    }

    public function fetchCartItems()
    {
        $userId = auth()->id();

        // Fetch cart items with user and product information
        $cartItems = Cart::with('product')
                        ->where('user_id', $userId)
                        ->get();

        return response()->json($cartItems);
    }

    public function handleCheckout(Request $request)
    {
        $request->validate([
            'amount' => 'required|integer',
        ]);

        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'mad',
                        'product_data' => [
                            'name' => 'Payment',
                        ],
                        'unit_amount' => $request->input('amount'),
                    ],
                    'quantity' => 1,
                ]],
                'customer_email' => Auth::user()->email, // Pass user's email to Stripe
                'client_reference_id' => Auth::user()->name, // Pass user's name to Stripe
                'mode' => 'payment',
                'success_url' => route('checkout.success'),
                'cancel_url' => route('checkout.cancel'),
            ]);

            return redirect()->away($session->url);
        } catch (\Exception $ex) {
            return back()->withErrors('Error: ' . $ex->getMessage());
        }
    }

    public function checkoutSuccess(Request $request)
    {
            Cart::where('user_id', Auth::id())->delete();
            session()->flash('success', 'Payment successful! Your order has been placed.');
            return redirect('/')->with('success', 'Payment successful! Your order has been placed.');
    }

    public function checkoutCancel(Request $request)
    {
        session()->flash('error', 'Payment was cancelled.');
        return redirect()->back()->withErrors('Payment was cancelled.');
    }


}
