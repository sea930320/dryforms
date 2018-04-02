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
    	$this->projectArea->where('project_id', $request->input('project_id'))->delete();
        $projectAreas = $request->input('project_areas');
        foreach ($projectAreas as $key => $projectArea) {
        	$this->projectArea->create([
        		'company_id' => auth()->user()->company->id,
        		'project_id' => $request->input('project_id'),
        		'area_id' => $projectArea['area_id']
        	]);
        }

        return $this->respond(['message' => 'Project Areas successfully created']);
    }
}
