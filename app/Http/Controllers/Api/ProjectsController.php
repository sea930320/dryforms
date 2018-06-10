<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Projects\ProjectsIndex;
use App\Http\Requests\Projects\ProjectStore;
use App\Http\Requests\Projects\ProjectUpdate;
use Illuminate\Http\Request;

use App\Services\QueryBuilder;
use App\Services\QueryBuilders\ProjectModelQueryBuilder;

use App\Models\Project;
use App\Models\ProjectCompany;
use App\Models\ProjectCallReport;
use Symfony\Component\HttpFoundation\JsonResponse;
use Illuminate\Database\QueryException;

class ProjectsController extends ApiController
{
    /**
     * @var Project
     */
    private $project;

    /**
     * @var ProjectCallReport
     */
    private $projectCallReport;

    /**
     * @var ProjectCompany
     */
    private $projectCompany;

    /**
     * ProjectsController constructor.
     *
     * @param Project $project
     * @param ProjectCallReport $projectCallReport
     * @param ProjectCompany $projectCompany
     */
    public function __construct(Project $project, ProjectCallReport $projectCallReport, ProjectCompany $projectCompany )
    {
        $this->project = $project;
        $this->projectCallReport = $projectCallReport;
        $this->projectCompany = $projectCompany;
    }

    /**
     * @param ProjectsIndex $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(ProjectsIndex $request): JsonResponse
    {
        $queryParams = $request->validatedOnly();
        $projects = $this->project;
        $queryBuilder = new ProjectModelQueryBuilder();
        $projects = $queryBuilder->setQuery($projects->query())->setQueryParams($queryParams);

        $projects = $projects->paginate($request->get('per_page'));

        return $this->respond($projects);
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id)
    {
        $project = $this->project->findOrFail($id);

        return $this->respond($project);
    }

    /**
     * @param ProjectStore $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ProjectStore $request)
    {
        $project = $this->project->create($request->validatedOnly());
        $company = auth()->user()->company->toArray();
        $company['project_id'] = $project['id'];
        $projectCompany = $this->projectCompany->create($company);
        return $this->respond(['message' => 'Project successfully created', 'project' => $project]);
    }

    /**
     * @param ProjectUpdate $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ProjectUpdate $request)
    {
        $project = $this->project->findOrFail($request->input('project_id'));
        $project->update($request->validatedOnly());

        return $this->respond(['message' => 'Project successfully updated', 'project' => $project]);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function restoreStatus(Request $request)
    {
        $projectID = $request->input('project_id');
        
        $projectCallReport = $this->projectCallReport
            ->where('project_id', $projectID)
            ->first();
        $status = 1;
        if ($projectCallReport && $projectCallReport->date_completed) {
            $status = 2;
        }

        $project = $this->project->findOrFail($projectID);
        $project->update([
            'status' => $status
        ]);

        return $this->respond(['message' => 'Project successfully updated', 'project' => $project]);
    }
    
    /**
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id)
    {
        $project = $this->project->findOrFail($id);
        $project->update([
            'status' => 3
        ]);
        return $this->respond(['message' => 'Project successfully deleted']);
    }

    public function getCompany(Request $request)
    {
        $projectID = $request->input('project_id');
        $projectCompany = $this->projectCompany->where('project_id', $projectID)->first();
        return $this->respond($projectCompany);
    }
}