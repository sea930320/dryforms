<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Projects\ProjectsIndex;
use App\Http\Requests\Projects\ProjectStore;
use App\Http\Requests\Projects\ProjectUpdate;
use Illuminate\Http\Request;

use App\Services\QueryBuilder;
use App\Services\QueryBuilders\ProjectModelQueryBuilder;

use App\Models\Project;
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
     * ProjectsController constructor.
     *
     * @param Project $project
     * @param ProjectCallReport $projectCallReport
     */
    public function __construct(Project $project, ProjectCallReport $projectCallReport)
    {
        $this->project = $project;
        $this->projectCallReport = $projectCallReport;
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
}