<?php

namespace App\Http\Controllers\Backend;

use App\Repositories\Contracts\CategoryInterface;
use Prologue\Alerts\Facades\Alert;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Http\Requests\Categories\CategoryStore;
use App\Http\Requests\Categories\CategoryUpdate;

class CategoryController extends Controller
{
    /**
     * @var Category
     */
    private $category;

    /**
     * CategoryController constructor.
     *
     * @param CategoryInterface $category
     */
    public function __construct(CategoryInterface $category) {

        $this->category = $category;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = $this->category->all();

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
     * @param  CategoryStore  $request
     *
     * @return mixed
     */
    public function store(CategoryStore $request)
    {
        $data = $request->only(['name', 'prefix']);

        if( ! $this->category->create($data)) {

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
    public function show(int $id)
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
    public function edit(int $id)
    {
        if(! $category = $this->category->findBy('id', $id)) {

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
    public function update(CategoryUpdate $request, int $id)
    {
        $data = $request->only(['name', 'prefix']);

        if( ! $category = $this->category->findBy('id', $id)) {

            Alert::error('Could not get category with id ' . $id . ' from database')->flash();

            return back()->withInput();
        }

        if( ! $update = $this->category->update($data, $category->id)) {

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
    public function destroy(int $id)
    {
        if( ! $category = $this->category->findBy('id', $id)) {

            Alert::error('Could not get category with id ' . $id . ' from database')->flash();

            return back();
        }

        if( ! $delete = $this->category->delete($category->id)) {

            Alert::error('Could not delete category')->flash();

            return back();
        }

        Alert::success('Category successfully deleted')->flash();

        return redirect()->route('categories.index');
    }
}
