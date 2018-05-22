<?php

namespace App\Http\Controllers\Api;


use Illuminate\Http\Request;

use DB;

class ProjectMoistureDaysController extends ApiController
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
    	$settings_ids = DB::table('project_moisture_settings')->select('id')->where('project_area_id', $request->area_id)->get();
        $result = array();
        for($i = 0; $i < count($settings_ids); $i ++){
            $current = DB::table('project_moisture_days')->where('area_setting_id', $settings_ids[$i]->id)->get();
            for($j = 0; $j < count($current); $j ++){
                $result[$j][] = $current[$j];
            }
        }
        return $this->respond($result);
    }   

     /**
     * @param ProjectCallReportStore $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $selectedAreas = $request->selectedAreas;
        $rangedate = $request->rangedate;
        $fdate = explode("T",$rangedate[0])[0];
        $edate = explode("T",$rangedate[1])[0];
        //echo $fdate . " " . $edate;

        foreach($selectedAreas as $key => $area){
            if($area == '1'){
                $settings_ids = DB::table('project_moisture_settings')->select('id')->where('project_area_id', $key)->get();
                for($i = 0; $i < count($settings_ids); $i ++){
                    $date = $fdate;
                    while ($date <= $edate)
                    {
                        $current = DB::table('project_moisture_days')->where('area_setting_id', $settings_ids[$i]->id)->where('current_time', $date)->first();
                        if(!isset($current->amount)){
                            DB::table('project_moisture_days')->insert(['area_setting_id' => $settings_ids[$i]->id, 'amount' => 0, 'current_time' => $date, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
                        }
                        $date = date('Y-m-d', strtotime($date . ' +1 day'));
                    }
                }
            }
        }
        /*
        $areaModel = $request->areaModel;
        for($i = 0; $i < 8; $i ++){
            DB::table('project_moisture_days')->insert(['project_area_id' => $request->area_id, 'structure_id' => $areaModel[$i]['structure'], 'matarial_id' => $areaModel[$i]['matarial'], 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
        }
        */
    }

    /**
     * @param ProjectCallReportUpdate $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $amountModel = $request->amountModel;
        for($i = 0; $i < count($amountModel); $i ++){
            $currenttime = $amountModel[$i][0]['current_time'];
            for($j = 0; $j < count($amountModel[$i]); $j ++){
                $amountModel[$i][$j]['current_time'] = explode("T", $currenttime)[0];
                DB::table('project_moisture_days')->where('id', $amountModel[$i][$j]['id'])->update(['amount' => $amountModel[$i][$j]['amount'], 'current_time' => $amountModel[$i][$j]['current_time'], 'updated_at' => date('Y-m-d H:i:s')]);
            }
        }
    }

    public function deleteItem(Request $request, $id)
    {
        $settings_ids = DB::table('project_moisture_settings')->select('id')->where('project_area_id', $id)->get();
        for($i = 0; $i < count($settings_ids); $i ++){
            DB::table('project_moisture_days')->where('area_setting_id', $settings_ids[$i]->id)->where('current_time', $request->current_time)->delete();
        }
    }
}
