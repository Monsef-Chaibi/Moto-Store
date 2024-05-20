<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function Dashboard(){
        return view('FrontEnd.AdminDash.FrontEnd.Dash');
    }
    public function Category(){
        return view('FrontEnd.AdminDash.FrontEnd.Category.Category');
    }
    public function Product()
    {
        $categories = Category::all();
        return view('FrontEnd.AdminDash.FrontEnd.Product.Product')->with('categories',$categories);
    }
    public function ProductList()
    {
        return view('FrontEnd.AdminDash.FrontEnd.Product.Product_List');
    }
    public function OrderDash()
    {
        $orders = Order::with(['user', 'orderItems.product'])->get();
        return view('FrontEnd.AdminDash.FrontEnd.OrderDash')->with('orders',$orders);
    }
    public function confirmOrder(Order $order)
    {
        // Update order status to 'confirmed'
        $order->status = 'confirmed';
        $order->save();

        return redirect()->back()->with('success', 'Order confirmed successfully');
    }
}
