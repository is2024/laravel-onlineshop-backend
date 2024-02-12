<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    //index
    public function index(Request $request)
    {
        //get categories with pagination
        $categories = DB::table('categories')
        ->when($request->input('name'), function ($query, $name) {
            return $query->where('name', 'like', '%' . $name . '%');
        })
        ->orderBy('created_at', 'desc')
        ->paginate(5);
        return view('pages.category.index', compact('categories'));

    

    }

    //create
    public function create()
    {
        return view('pages.category.create');
    }

    //store
    public function store(Request $request)
    {
       $validated= $request->validate([
            'name' => 'required|max:100',
        ]);

        $category = \App\Models\Category::create($validated);
        return redirect()->route('category.index')->with('success', 'Category successfully created');
    }
    //edit
    public function edit($id)
    {
        $category = \App\Models\Category::findOrFail($id);
        return view('pages.category.edit', compact('category'));
    }
    //update
    public function update(Request $request, $id)
    {
        $validated= $request->validate([
            'name' => 'required|max:100',
        ]);
        $category = \App\Models\Category::findOrFail($id);
        $category->update($validated);
        return redirect()->route('category.index')->with('success', 'Category successfully updated');
    }

    //destroy
    public function destroy($id)
    {
        $category = \App\Models\Category::findOrFail($id);
        $category->delete();
        return redirect()->route('category.index')->with('success', 'Category successfully deleted');
    }
}
