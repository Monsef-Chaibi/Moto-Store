<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'NameInEnglish' => 'required|string|max:255',
            'NameInFrench' => 'required|string|max:255',
        ]);

        try {
            $category = new Category;
            $category->name_en = $request->input('NameInEnglish');
            $category->name_fr = $request->input('NameInFrench');
            $category->save();

            session()->flash('success', 'Category saved successfully!');

        } catch (\Exception $e) {

            session()->flash('error', 'Failed to save the category. Error: ' . $e->getMessage());
        }
        return back();
    }

}
