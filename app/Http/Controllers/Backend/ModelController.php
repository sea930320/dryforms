<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Models\ModelCreate;
use App\Http\Requests\Models\ModelUpdate;
use App\Models\Category;
use App\Models\Models;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\CategoryInterface;
use App\Repositories\Contracts\ModelInterface;
use Prologue\Alerts\Facades\Alert;

class ModelController extends Controller
{
    /**
     * @var Models
     */
    private $model;
    /**
     * @var Category
     */
    private $category;

    /**
     * ModelController constructor.
     *
     * @param ModelInterface $model
     * @param CategoryInterface $category
     */
    public function __construct(ModelInterface $model, CategoryInterface $category)
    {
        $this->model = $model;
        $this->category = $category;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $models = $this->model->all();

        return view('dashboard.models.index', compact('models'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if( ! $categories = $this->category->all()) {

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
        $data = $request->only(['name', 'category_id']);

        if(! $category = $this->category->find($data['category_id'])){

            Alert::error('Could not find category from database')->flash();

            return back()->withInput();
        }

        if( ! $this->model->create($data)) {

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
    public function show(int $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return mixed
     */
    public function edit(int $id)
    {
        if( ! $model = $this->model->find($id)) {

            Alert::error('Could not find model in database')->flash();

            return back();
        }

        if( ! $categories = $this->category->all()) {

            Alert::error('Could not find categories in database')->flash();

            return back();
        }

        return view('dashboard.models.edit', compact('model', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ModelUpdate  $request
     * @param  int  $id
     * @return mixed
     */
    public function update(ModelUpdate $request, int $id)
    {
        if( ! $model = $this->model->find($id)) {

            Alert::error('Could not find model from database')->flash();

            return back()->withInput();
        }

        $data = $request->only(['name', 'category_id']);

        if( ! $category = $this->category->find($data['category_id'])){

            Alert::error('Could not find category from database')->flash();

            return back()->withInput();
        }

        if( ! $this->model->update($data, $model->id)) {

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
    public function destroy(int $id)
    {
        if( ! $model = $this->model->find($id)) {

            Alert::error('Could not find model from database')->flash();

            return back()->withInput();
        }

        if( ! $this->model->delete($model->id)) {

            Alert::error('Could not delete model')->flash();

            return back();
        }

        Alert::success('Model successfully deleted')->flash();

        return redirect()->route('models.index');
    }
}
