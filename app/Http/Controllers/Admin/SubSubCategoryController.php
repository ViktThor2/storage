<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\{Category, SubCategory, SubSubCategory};

class SubSubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $subsubcategory = New SubSubCategory();
        $subsubcategory->sub_category_id = $request->category;
        $subsubcategory->name = $request->name;
        $subsubcategory->save();

        session()->flash('message', 'A ' . $subsubcategory->name .' alkategória létrehozva');
        return redirect()->route('admin.category.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = Category::all();
        $subcategories = SubCategory::all();
        $subsubcategory = SubSubCategory::find($id);

        return view('admin.category.subsubedit')
            ->with('subsubcategory', $subsubcategory)
            ->with('categories', $categories)
            ->with('subcategories', $subcategories);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $subsubcategory = SubSubCategory::find($id);
        $subsubcategory->sub_category_id = $request->category;
        $subsubcategory->name = $request->name;
        $subsubcategory->update();

        session()->flash('message', 'A ' . $subsubcategory->name .' alkategória frissítve');
        return redirect()->route('admin.category.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
