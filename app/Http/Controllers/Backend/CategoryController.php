<?php

namespace App\Http\Controllers\Backend;

use Prologue\Alerts\Facades\Alert;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Http\Requests\Categories\CategoryCreate;
use App\Http\Requests\Categories\CategoryUpdate;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get categories list
        $categories = Category::getList();

        return view('dashboard.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CategoryCreate  $request
     *
     * @return mixed
     */
    public function store(CategoryCreate $request)
    {
        // get request data
        $data = $request->all();

        // create category
        if( ! Category::createCategory($data)) {

            Alert::error('Could not create category')->flash();

            return back()->withInput();
        }

        Alert::success('Category successfully created')->flash();

        return redirect()->route('categories.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
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
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // get category by id
        if(! $category = Category::getById($id)) {

            Alert::error('Could not get category with id ' . $id . ' from database')->flash();

            return back();
        }

        return view('dashboard.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CategoryUpdate  $request
     * @param  int  $id
     *
     * @return mixed
     */
    public function update(CategoryUpdate $request, $id)
    {
        // get request data
        $data = $request->all();

        // get category
        if( ! $category = Category::getById($id)) {

            Alert::error('Could not get category with id ' . $id . ' from database')->flash();

            return back()->withInput();
        }

        // update category
        if( ! $update = Category::updateCategory($data, $category)) {

            Alert::error('Could not update category')->flash();

            return back()->withInput();
        }

        Alert::success('Category successfully updated')->flash();

        return redirect()->route('categories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return mixed
     */
    public function destroy($id)
    {
        // get category
        if( ! $category = Category::getById($id)) {

            Alert::error('Could not get category with id ' . $id . ' from database')->flash();

            return back();
        }

        // delete category
        if( ! $delete = Category::deleteCategory($category)) {

            Alert::error('Could not delete category')->flash();

            return back();
        }

        Alert::success('Category successfully deleted')->flash();

        return redirect()->route('categories.index');
    }
}
