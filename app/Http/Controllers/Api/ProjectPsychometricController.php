<?php
namespace App\Http\Controllers\Api;

use App\Models\ProjectPsychometricDays;
use App\Models\ProjectArea;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProjectPsychometricController extends ApiController
{
    /**
     * @var ProjectPsychometricDays
     */
    private $projectPsychometricDays;

    private $projectArea;

    /**
     * ProjectPsychometricController constructor.
     *
     */
    public function __construct(ProjectPsychometricDays $projectPsychometricDays, ProjectArea $projectArea)
    {
        $this->projectPsychometricDays = $projectPsychometricDays;
        $this->projectArea = $projectArea;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        //$forms = $this->form->get();
        $projectAreas = $this->projectArea
            ->with(['standard_area'])
            ->where('project_id', $request->input('project_id'))
            ->get();
        $timedatas = array();
        $areadatas = array();
        foreach($projectAreas as $key => $area){
            $areadatas[$area->id] = $area->standard_area->title;
            $data = $this->projectPsychometricDays->where('area_id', $area->id)->get();
            foreach($data as $i => $row){
                $timedatas[$row->current_time][] = $row;
            }
        }
        return $this->respond([
            'areadatas' => $areadatas,
            'timedatas' => $timedatas
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $time_id = $request->timeId;
        if(isset($time_id)){
            $outside = $request->outside;
            $unaffected = $request->unaffected;
            $affected = $request->affected;
            $dehumidifier = $request->dehumidifier;
            $hvac = $request->hvac;
            
            $time_row = $this->projectPsychometricDays->where('id', $time_id)->first();
            $time_row->outside = $outside;
            $time_row->unaffected = $unaffected;
            $time_row->affected = $affected;
            $time_row->dehumidifier = $dehumidifier;
            $time_row->hvac = $hvac;
            $time_row->save();
            return $this->respond(['message' => 'Form successfully saved']);  
        }
        else{
            $selectedAreas = $request->selectedAreas;
            $rangedate = $request->rangedate;
            $fdate = explode("T",$rangedate[0])[0];
            $edate = explode("T",$rangedate[1])[0];
            $primary_val = '{"temp":0, "rh":0, "gpp":0, "dew":0}';
            $date = $fdate;
            while ($date <= $edate)
            {
                for($i = 0; $i < count($selectedAreas); $i ++){
                    if($selectedAreas[$i] == 1){
                        $time_row = $this->projectPsychometricDays->where('area_id', $i)->where('current_time', $date)->first();
                        if(isset($time_row)){
                            continue;
                        }
                        $this->projectPsychometricDays->create(['area_id' => $i, 'containment_id' => 0, 'current_time' => $date, 'outside' => $primary_val, 'unaffected' => $primary_val, 'affected' => $primary_val, 'dehumidifier' => $primary_val, 'hvac' => $primary_val]);
                    }
                }
                $date = date('Y-m-d', strtotime($date . ' +1 day'));
            }
            return $this->respond(['message' => 'Form successfully saved']);    
        }
        
    }
    public function updatetime(Request $request): JsonResponse
    {
        $oldtime = $request->old_time;
        $newtime = $request->new_time;
        $id = $request->project_id;
        // foreach($newtimes as $key){
        //     $curtime = explode("T", $newtime)[0];
        //     $this->projectPsychometricDays->where('current_time', $key)->update(['current_time' => $curtime]);
        //    return $this->respond(['message' => $key]);
        // }
        $projectAreas = $this->projectArea
            ->where('project_id', $id)
            ->get();
        $curtime = explode("T", $newtime)[0];
        foreach($projectAreas as $key => $area){
            $this->projectPsychometricDays->where('area_id', $area->id)->where('current_time', $oldtime)->update(['current_time' => $curtime]);
        }
        return $this->respond(['message' => 'Form successfully updated']);
    }
    public function update(Request $request, $id): JsonResponse
    {
        $time_id = $id;
        $area_id = $request->area_id;
        $numContainments = $request->numContainments;
        $outside = $request->outside;
        $unaffected = $request->unaffected;
        $affected = $request->affected;
        $dehumidifier = $request->dehumidifier;
        $hvac = $request->hvac;
        $curdate = $request->curdate;
        $this->projectPsychometricDays->findOrFail($time_id)->delete();
        for($i = 1; $i <= $numContainments; $i ++){
            $this->projectPsychometricDays->create(['area_id' => $area_id, 'containment_id' => $i, 'current_time' => $curdate, 'outside' => $outside, 'unaffected' => $unaffected, 'affected' => $affected, 'dehumidifier' => $dehumidifier, 'hvac' => $hvac]);
        }
        return $this->respond(['message' => 'Form successfully updated']);
    }
    /**
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $this->projectPsychometricDays->findOrFail($id)->delete();
        return $this->respond(['message' => 'Form successfully deleted']);
    }
}