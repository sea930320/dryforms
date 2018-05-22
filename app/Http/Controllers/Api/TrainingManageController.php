<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DefaultFromData;
use App\Models\TrainingCategories;
use Illuminate\Http\Request;
use Prologue\Alerts\Facades\Alert;

use DB;
class TrainingManageController extends Controller
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
        
        $json_data = json_encode($data);
        echo $json_data;
    }

    public function getVideos(Request $request)
    {
        if($request->category_id == -1){
            $videos = DB::table('training_videos')->get();    
        }
        else{
            $videos = DB::table('training_videos')->where('category_id', $request->category_id)->get();
        }

        return json_encode($videos);
    }

}