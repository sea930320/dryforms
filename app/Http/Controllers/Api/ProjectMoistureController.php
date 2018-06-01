<?php

namespace App\Http\Controllers\Api;


use Illuminate\Http\Request;

use DB;

class ProjectMoistureController extends ApiController
{
    /**
     * ProjectCallReportsController constructor.
     *
     * @param ProjectCallReport $projectCallReport
     * @param Project $project
     */
    public function __construct()
    {

    }

    /**
     * @param ProjectCallReportIndex $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
    	$data = DB::table('project_moisture_settings')->where('project_area_id', $request->area_id)->get();
        if (count($data) == 0) {
            for($i = 0; $i < 8; $i ++){
                DB::table('project_moisture_settings')->insert(['project_area_id' => $request->area_id, 'structure_id' => NULL, 'matarial_id' => NULL, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
            }
            $data = DB::table('project_moisture_settings')->where('project_area_id', $request->area_id)->get();
        }
        return $this->respond($data);
    }

     /**
     * @param ProjectCallReportStore $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $areaModel = $request->areaModel;
        for($i = 0; $i < 8; $i ++){
            DB::table('project_moisture_settings')->insert(['project_area_id' => $request->area_id, 'structure_id' => $areaModel[$i]['structure'], 'matarial_id' => $areaModel[$i]['matarial'], 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
        }
    }

    /**
     * @param ProjectCallReportUpdate $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $areaModel = $request->areaModel;
        $data = DB::table('project_moisture_settings')->where('project_area_id', $id)->get();
        for($i = 0; $i < 8; $i ++){
            DB::table('project_moisture_settings')->where('id', $data[$i]->id)->update(['structure_id' => $areaModel[$i]['structure'], 'matarial_id' => $areaModel[$i]['matarial'], 'updated_at' => date('Y-m-d H:i:s')]);
        }
        
    }

}
