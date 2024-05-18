<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        try {
            // Handle the file upload
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('images', 'public');
            } else {
                $imagePath = null;
            }

            // Create a new product
            Product::create([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'price' => $request->input('price'),
                'quantity' => $request->input('quantity'),
                'image' => $imagePath,
            ]);

            return redirect()->back()->with('success', 'Product added successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to add product');
        }
    }

    public function getProducts(Request $request)
    {
        $query = Product::query();

        if ($search = $request->input('search')) {
            $query->where('name', 'LIKE', "%{$search}%")
                ->orWhere('description', 'LIKE', "%{$search}%");
        }

        $products = $query->paginate($request->input('limit', 10));

        return response()->json($products);
    }
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return response()->json($product);
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->quantity = $request->input('quantity');

        if ($request->hasFile('image')) {
            $filePath = $request->file('image')->store('public/images');
            $product->image = str_replace('public/', '', $filePath);
        }

        $product->save();

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if ($product->delete()) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }
}
