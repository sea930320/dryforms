<?php

namespace App\Http\Controllers\Api;

use App\Models\ProjectForm;
use Illuminate\Http\JsonResponse;

use App\Http\Requests\ProjectForm\ProjectFormIndex;
use App\Http\Requests\ProjectForm\ProjectFormStore;
// use App\Http\Requests\ProjectForm\ProjectFormUpdate;

class ProjectFormsController extends ApiController
{
    /**
     * @var ProjectForm
     */
    private $projectForm;

    /**
     * FormsController constructor.
     *
     * @param ProjectForm $projectForm
     */
    public function __construct(ProjectForm $projectForm)
    {
        $this->projectForm = $projectForm;
    }

    /**
     * @param ProjectFormIndex $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(ProjectFormIndex $request): JsonResponse
    {
    	$queryParams = $request->validatedOnly();

        $projectForms = $this->projectForm
        	->where('project_id', $queryParams['project_id'])
        	->get();
        return $this->respond($projectForms);
    }

    /**
     * @param ProjectFormStore $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ProjectFormStore $request): JsonResponse
    {
    	$queryParams = $request->validatedOnly();
        foreach ($queryParams['project_forms'] as $key => $project_form) {
        	$projectForm = $this->projectForm->create($project_form);
        }
        return $this->respond(['message' => 'Project Forms successfully created']);
    }
}
