<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ProjectArea\ProjectAreaIndex;
use App\Http\Requests\ProjectArea\ProjectAreaStore;
use App\Http\Requests\ProjectArea\ProjectAreaUpdate;

use App\Models\ProjectArea;
use App\Models\Area;
use Symfony\Component\HttpFoundation\JsonResponse;

class ProjectAreasController extends ApiController
{
	/**
     * @var Area
     */
    private $area;

    /**
     * @var ProjectArea
     */
    private $projectArea;

    /**
     * ProjectAreasController constructor.
     *
     * @param ProjectArea $projectArea
     * @param Area $area
     */
    public function __construct(ProjectArea $projectArea, Area $area)
    {
        $this->projectArea = $projectArea;
        $this->area = $area;
    }

    /**
     * @param ProjectAreaIndex $request
     *
     * @return JsonResponse
     */
    public function index(ProjectAreaIndex $request): JsonResponse
    {
    	$projectAreas = $this->projectArea
    		->with(['standard_area'])
    		->where('project_id', $request->input('project_id'))
    		->get();
    	$area_ids = array_column($projectAreas->toArray(), 'area_id');
    	$areas = $this->area
    		->whereNotIn('id', $area_ids)
    		->get();

    	return $this->respond([
    		'project_areas' => $projectAreas,
    		'standard_areas' => $areas
    	]);
    }

    /**
     * @param ProjectAreaStore $request
     *
     * @return JsonResponse
     */
    public function store(ProjectAreaStore $request): JsonResponse
    {
        $standardAreas = $request->input('standard_areas');
        foreach ($standardAreas as $key => $standardArea) {
            if ($standardArea['area_id'] == -1) {
                $this->area->create([
                    'company_id' => auth()->user()->company->id,
                    'title' => $standardArea['title']
                ]);
            }
        }

        $projectAreas = $request->input('project_areas');
    	$oldProjectAreas = $this->projectArea->where('project_id', $request->input('project_id'))->get()->toArray();

        foreach ($oldProjectAreas as $key => $oldProjectArea) {
            $temp = array_filter($projectAreas, function($newProjectArea) use($oldProjectArea) {
                return $oldProjectArea['area_id'] == $newProjectArea['area_id'];
            });
            if (count($temp) === 0) {
                $this->projectArea->find($oldProjectArea['id'])->delete();
            }
        }

        foreach ($projectAreas as $key => $projectArea) {
            if ($projectArea['area_id'] == -1) {
                $standardArea = $this->area->create([
                    'company_id' => auth()->user()->company->id,
                    'title' => $projectArea['title']
                ]);
                $this->projectArea->create([
                    'company_id' => auth()->user()->company->id,
                    'project_id' => $request->input('project_id'),
                    'area_id' => $standardArea['id']
                ]);
            } else {
                $temp = array_filter($oldProjectAreas, function($oldProjectArea) use($projectArea) {
                    return $oldProjectArea['area_id'] == $projectArea['area_id'];
                });
                if (count($temp) === 0) {
                    $this->projectArea->create([
                        'company_id' => auth()->user()->company->id,
                        'project_id' => $request->input('project_id'),
                        'area_id' => $projectArea['area_id']
                    ]);
                }                
            }        	
        }

        return $this->respond(['message' => 'Project Areas successfully updated']);
    }
}
