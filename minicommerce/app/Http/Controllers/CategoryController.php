<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('admin.category', compact('categories'));
    }

    public function create()
    {
        return view('admin.createCategory');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required']);
        Category::create(['name' => $request->name]);
        return redirect()->route('admin.categories.index')->with('success', 'Category added.');
    }

    public function edit(Category $category)
    {
        return view('admin.editCategory', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate(['name' => 'required']);

        // Update data kategori
        $category->update([
            'name' => $request->name,
        ]);
        return redirect()->route('admin.categories.index')->with('success', 'Category updated.');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Category deleted.');
    }
}
