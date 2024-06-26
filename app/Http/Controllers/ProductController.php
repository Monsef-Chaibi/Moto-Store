<?php

namespace App\Http\Controllers;
use Intervention\Image\Facades\Image;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'category' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        try {
            // Handle the file upload
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $filename = time() . '.' . $image->getClientOriginalExtension();

                // Resize the image to 512px * 512px
                $resizedImage = Image::make($image->getRealPath())->fit(512, 512);
                $resizedImagePath = storage_path('app/public/images/resized-' . $filename);
                $resizedImage->save($resizedImagePath);

                // Remove background using remove.bg API
                $imagePath = $this->removeBackground($resizedImagePath);

                if ($imagePath) {
                    // Resize the image to 315px width and 390.06px height and set background to red
                    $background = Image::canvas(315, 390.06, '#DEDEDE'); // Red background with the specified size
                    $resizedImage = Image::make($imagePath)->resize(315, 390.06, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });

                    // Insert the resized image into the background
                    $background->insert($resizedImage, 'center');

                    // Save the image
                    $finalImagePath = storage_path('app/public/images/' . $filename);
                    $background->save($finalImagePath);

                    $imagePath = 'images/' . $filename;
                } else {
                    $imagePath = null;
                }
            } else {
                $imagePath = null;
            }

            // Create a new product
            Product::create([
                'category_id' => $request->input('category'),
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'price' => $request->input('price'),
                'quantity' => $request->input('quantity'),
                'image' => $imagePath,
            ]);

            return redirect()->back()->with('success', 'Product added successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to add product: ' . $e->getMessage());
        }
    }

    /**
     * Remove the background from the image using remove.bg API.
     *
     * @param string $imagePath
     * @return string|null
     */
    private function removeBackground($imagePath)
    {
        $apiKey = 'EVfqGzei9KDkimsJnuEcbvHU';
        $url = 'https://api.remove.bg/v1.0/removebg';
        $outputPath = storage_path('app/public/images/removed-bg-' . time() . '.png');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, [
            'image_file' => new \CURLFile($imagePath),
            'size' => 'auto'
        ]);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'X-Api-Key: ' . $apiKey
        ]);

        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);

        if ($err) {
            return null;
        } else {
            file_put_contents($outputPath, $response);
            return $outputPath;
        }
    }


    public function getProducts(Request $request)
    {
        $query = Product::query()->with('category');

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
