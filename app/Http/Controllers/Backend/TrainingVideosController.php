<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TrainingVideos;
use DB;
class TrainingVideosController extends Controller
{
	
    public function __construct()
    {

    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    /**
     *
     * @return JsonResponse
     */
    public function index(Request $request) {
        $videos = DB::table('training_videos')->where('category_id', $request->category_id)->get();

        return json_encode($videos);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $video = DB::table('training_videos')->where('url', $request->url)->first();
        if(isset($video->url)){
            return response()->json(['message' => 'Video is already existed', 'error' => 'error']);
        }
        DB::table('training_videos')->insert(['category_id'=>$request->category_id, 'url' => $request->url, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
        $video = DB::table('training_videos')->where('url', $request->url)->first();
        return response()->json(['message' => 'Video successfully created', 'video' => $video]);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function update(Request $request)
    {
        
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function destroy(int $id)
    {
        DB::table('training_videos')->where('id', $id)->delete();
        return response()->json(['message' => 'Video successfully deleted']);
    }
}
