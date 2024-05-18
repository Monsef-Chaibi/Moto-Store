<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'NameInEnglish' => 'required|string|max:255',
        ]);


        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation errors',
                'errors' => '$validator->errors()'
            ], 422);
        }

        try {
            $category = new Category;
            $category->name_en = $request->NameInEnglish;
            $category->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Category saved successfully!',
                'data' => $category
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function index(Request $request)
    {
        $search = $request->input('search', '');
        $limit = $request->input('limit', 10); // Default number of items per page

        $categories = Category::query()
            ->where('name_en', 'like', '%' . $search . '%')
            ->paginate($limit); // This automatically handles the pagination

        return response()->json($categories); // This will return paginated categories
    }

    public function destroy(Category $category)
    {
        try {
            $category->delete();
            return response()->json(['status' => 'success', 'message' => 'Category deleted successfully!']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Error deleting category']);
        }
    }
    // Controller method to fetch a category
    public function getdetails($id)
    {
        $category = Category::find($id);
        return response()->json($category);
    }

        // Controller method to update a category
    public function update(Request $request, $id)
    {
        $request->validate([
            'name_en' => 'required|string|max:255',
        ]);
        try {
        $category = Category::find($id);
        $category->name_en = $request->input('name_en');
        $category->save();
        return response()->json(['status' => 'success', 'message' => 'Category updated successfully!']);
        }
        catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Error updating category']);
        }
    }



}
