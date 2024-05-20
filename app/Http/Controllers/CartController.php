<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $user = Auth::user();
        $product = Product::find($request->product_id);

        // Check if the requested quantity exceeds the available stock
        if ($request->quantity > $product->quantity) {
            return response()->json(['success' => false, 'message' => 'Requested quantity exceeds available stock.']);
        }

        // Check if the product is already in the cart
        $cartItem = Cart::where('user_id', $user->id)
                        ->where('product_id', $request->product_id)
                        ->first();

        if ($cartItem) {
            // Check if the updated quantity exceeds the available stock
            if ($cartItem->quantity + $request->quantity > $product->quantity) {
                return response()->json(['success' => false, 'message' => 'Total quantity exceeds available stock.']);
            }
            // Update the quantity if the product is already in the cart
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        } else {
            // Create a new cart item if it doesn't exist
            Cart::create([
                'user_id' => $user->id,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);
        }

        return response()->json(['success' => true, 'message' => 'Product added to cart!']);
    }
    public function getCartItemCount()
    {
        $user = Auth::user();
        if ($user) {
            $count = Cart::where('user_id', $user->id)->count();
            return response()->json(['count' => $count]);
        }
        return response()->json(['count' => 0]);
    }
    public function getCartItems()
    {
        $user = Auth::user();
        if ($user) {
            $cartItems = Cart::where('user_id', $user->id)->with('product')->get();
            return response()->json(['cartItems' => $cartItems]);
        }
        return response()->json(['cartItems' => []]);
    }

    public function removeFromCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:carts,product_id,user_id,' . auth()->id()
        ]);

        // Find the cart item for the logged-in user
        $cartItem = Cart::where('user_id', auth()->id())
                        ->where('product_id', $request->product_id)
                        ->first();

        if ($cartItem) {
            // Remove the cart item
            $cartItem->delete();

            return response()->json([
                'success' => true,
                'message' => 'Product removed from cart successfully.'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Product not found in cart.'
        ], 404);
    }

}
