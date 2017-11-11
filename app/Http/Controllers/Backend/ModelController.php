<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Models\ModelCreate;
use App\Http\Requests\Models\ModelUpdate;
use App\Models\Category;
use App\Models\Models;
use App\Http\Controllers\Controller;
use Prologue\Alerts\Facades\Alert;

class ModelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get models list
        $models = Models::getList();

        return view('dashboard.models.index', compact('models'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // get categories
        if( ! $categories = Category::getList()) {

            Alert::error('Could not find categories in database')->flash();

            return back();
        }
        return view('dashboard.models.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ModelCreate  $request
     * @return mixed
     */
    public function store(ModelCreate $request)
    {
        $data = $request->all();

        // check category
        if(! $category = Category::getById($data['category_id'])){

            Alert::error('Could not find category from database')->flash();

            return back()->withInput();
        }

        // create model
        if( ! Models::createModel($data)) {

            Alert::error('Could not create model')->flash();

            return back()->withInput();
        }

        Alert::success('Model created successfully')->flash();

        return redirect()->route('models.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return mixed
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return mixed
     */
    public function edit($id)
    {
        // get model
        if( ! $model = Models::getById($id)) {

            Alert::error('Could not find model in database')->flash();

            return back();
        }

        return view('dashboard.models.edit', compact('model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ModelUpdate  $request
     * @param  int  $id
     * @return mixed
     */
    public function update(ModelUpdate $request, $id)
    {
        // get model
        if( ! $model = Models::getById($id)) {

            Alert::error('Could not find model from database')->flash();

            return back()->withInput();
        }

        $data = $request->all();

        // check category
        if(! $category = Category::getById($data['category_id'])){

            Alert::error('Could not find category from database')->flash();

            return back()->withInput();
        }

        // update model
        if( ! Models::updateModel($model, $data)) {

            Alert::error('Could not update model')->flash();

            return back()->withInput();
        }

        Alert::success('Model updated successfully')->flash();

        return redirect()->route('models.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return mixed
     */
    public function destroy($id)
    {
        // get model
        if( ! $model = Models::getById($id)) {

            Alert::error('Could not find model from database')->flash();

            return back()->withInput();
        }

        // delete model
        if( ! Models::deleteModel($model)) {

            Alert::error('Could not delete model')->flash();

            return back();
        }

        Alert::success('Model successfully deleted')->flash();

        return redirect()->route('models.index');
    }
}
