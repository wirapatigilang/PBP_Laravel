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

public function create(Request $request)
{
    $request->validate(['name' => 'required']);
    Category::create(['name' => $request->name]);
    return redirect()->route('admin.category')->with('success', 'Category added.');
}

public function edit(Category $category)
{
    $categories = Category::all();
    return view('admin.category', compact('categories', 'category'));
}

public function update(Request $request, Category $category)
{
    $request->validate(['name' => 'required']);
    $category->update(['name' => $request->name]);
    return redirect()->route('categories.index')->with('success', 'Category updated.');
}

public function delete(Category $category)
{
    $category->delete();
    return redirect()->route('admin.category')->with('success', 'Category deleted.');
}
}
