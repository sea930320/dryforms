<?php

namespace App\Http\Controllers\Api;

use App\Models\ProjectCallReport;
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
     * ProjectCallReportsController constructor.
     *
     * @param ProjectCallReport $projectCallReport
     */
    public function __construct(ProjectCallReport $projectCallReport)
    {
        $this->projectCallReport = $projectCallReport;
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
}
