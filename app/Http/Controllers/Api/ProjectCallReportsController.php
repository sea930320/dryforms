<?php

namespace App\Http\Controllers\Api;

use App\Models\ProjectCallReport;
use App\Models\Project;
use Illuminate\Http\JsonResponse;

use App\Http\Requests\ProjectCallReport\ProjectCallReportIndex;
use App\Http\Requests\ProjectCallReport\ProjectCallReportStore;
use App\Http\Requests\ProjectCallReport\ProjectCallReportUpdate;

class ProjectCallReportsController extends ApiController
{
    /**
     * @var ProjectCallReport
     */
    private $projectCallReport;

    /**
     * @var Project
     */
    private $project;

    /**
     * ProjectCallReportsController constructor.
     *
     * @param ProjectCallReport $projectCallReport
     * @param Project $project
     */
    public function __construct(ProjectCallReport $projectCallReport, Project $project)
    {
        $this->projectCallReport = $projectCallReport;
        $this->project = $project;
    }

    /**
     * @param ProjectCallReportIndex $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(ProjectCallReportIndex $request): JsonResponse
    {
    	$queryParams = $request->validatedOnly();

        $projectCallReport = $this->projectCallReport
        	->where('project_id', $queryParams['project_id'])
        	->get();
        return $this->respond($projectCallReport);
    }

     /**
     * @param ProjectCallReportStore $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ProjectCallReportStore $request)
    {
        $projectCallReport = $this->projectCallReport->create($request->validatedOnly());

        return $this->respond(['message' => 'Project Call Report successfully created', 'projectCallReport' => $projectCallReport]);
    }

    /**
     * @param ProjectCallReportUpdate $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ProjectCallReportUpdate $request)
    {
        $projectCallReport = $this->projectCallReport->findOrFail($request->input('call_report_id'));
        $projectCallReport->update($request->validatedOnly());

        $project = $this->project->findOrFail($request->get('project_id'));
        $project->update([
            'owner_name' => $request->get('insured_name'),
            'address' => $request->get('billing_address'),
            'phone' => $request->get('insured_cell_phone') ? $request->get('insured_cell_phone') : ($request->get('insured_home_phone') ? $request->get('insured_home_phone') : ($request->get('insured_work_phone') ? $request->get('insured_work_phone'): '')),
            'status' => $request->get('date_completed') ? 3 : ($request->get('date_contacted') ? 2 : 1),
            'assigned_to' => $request->get('assigned_to')
        ]);

        return $this->respond(['message' => 'Project Call Report successfully updated', 'projectCallReport' => $projectCallReport, 'project' => $project]);
    }

}
