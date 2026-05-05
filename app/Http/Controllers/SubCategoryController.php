<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class SubCategoryController extends Controller
{
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $subCategories = SubCategory::with('category')->orderBy('created_at', 'desc')->get();

        return view('admin.categories.create-sub-category', compact('categories', 'subCategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:sub_categories,name',
            ],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        $data = $request->only(['category_id', 'name']);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('subcategories', 'public');
        }

        SubCategory::create($data);

        return redirect()->back()->with('success', 'Subcategory created successfully.');
    }

    public function edit(SubCategory $subCategory)
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.categories.edit-sub-category', compact('categories', 'subCategory'));
    }

    public function update(Request $request, SubCategory $subCategory)
    {
        $request->validate([
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'name' => [
                'required',
                'string',
                'max:255',
               'unique:sub_categories,name,' . $subCategory->id,
            ],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        $data = $request->only(['category_id', 'name']);

        if ($request->hasFile('image')) {
            if ($subCategory->image && Storage::disk('public')->exists($subCategory->image)) {
                Storage::disk('public')->delete($subCategory->image);
            }
            $data['image'] = $request->file('image')->store('subcategories', 'public');
        }

        $subCategory->update($data);

        return redirect()->route('admin.categories.create-sub-category')->with('success', 'Subcategory updated successfully.');
    }

    public function destroy(SubCategory $subCategory)
    {
        $subCategory->delete();

        return redirect()->route('admin.categories.create-sub-category')->with('success', 'Subcategory deleted successfully.');
    }
}
