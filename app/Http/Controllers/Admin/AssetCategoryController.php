<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\{Category, SubCategory, SubSubCategory};


class AssetCategoryController extends Controller
{
    public function index()
    {
        $categories = Category::paginate('25');

        return view('admin.category.index')
           ->with('categories', $categories);
    }

    public function create()
    {
        $categories = Category::all();
        $subcategories = SubCategory::all();

        return view('admin.category.create')
            ->with('categories', $categories)
            ->with('subcategories', $subcategories);
    }

    public function store(Request $request)
    {
        $category = New Category();
        $category->name = $request->name;
        $category->save();

        session()->flash('message', 'A '. $category->name .' kategória létrehozva');
        return redirect()->route('admin.category.index');
    }

    public function edit($id)
    {
        $category = Category::find($id);

        return view('admin.category.edit')
            ->with('category', $category);
    }

    public function update(Request $request, $id)
    {
        $category = Category::find($id);
        $category->name = $request->name;
        $category->save();

        session()->flash('message', 'A ' . $category->name .' kategória frissítve');
        return redirect()->route('admin.category.index');
    }

    public function destroy($id)
    {
        $category = Category::find($id);
        $category->delete();

        session()->flash('message', 'A(z) '. $category->name .' kategória törölve');
        return redirect()->route('admin.category.index');
    }

}
