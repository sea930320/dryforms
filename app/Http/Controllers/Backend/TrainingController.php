<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\DefaultFromData;
use App\Models\TrainingCategories;
use Illuminate\Http\Request;
use Prologue\Alerts\Facades\Alert;

use DB;
class TrainingController extends Controller
{

    public function __construct()
    {
        
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $data = TrainingCategories::all();
        
        return view('dashboard.training.index', ['data' => $data]);
    }

    public function create(Request $request)
    {
        DB::table('training_categories')->insert(['name' => $request->name, 'title' => $request->title, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
        //$category = array('name' => $request->name, 'title' => $request->title);
        $cur = DB::table('training_categories')->where('name', $request->name)->where('title', $request->title)->first();
        $json_data = json_encode($cur);
        echo $json_data;
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $category = DB::table('training_categories')->where('id', $id)->first();

        return view('dashboard.training.edit', ['category'=>$category]);
    }

    /**
     * @param FormUpdate $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        DB::table('training_categories')->where('id', $id)->update(['name' => $request->name, 'title' => $request->title, 'updated_at' => date('Y-m-d H:i:s')]);

        return redirect('admin/training/categories');
    }
}