<?php

namespace App\Http\Controllers\Api;

use App\Models\ProjectDailylog;
use App\Models\Project;
use Illuminate\Http\JsonResponse;

use App\Http\Requests\ProjectDailylog\ProjectDailylogIndex;
use App\Http\Requests\ProjectDailylog\ProjectDailylogStore;
use App\Http\Requests\ProjectDailylog\ProjectDailylogUpdate;

class ProjectDailylogsController extends ApiController
{
    /**
     * @var ProjectDailylog
     */
    private $projectDailylog;

    /**
     * @var Project
     */
    private $project;

    /**
     * ProjectDailylogsController constructor.
     *
     * @param ProjectDailylog $projectDailylog
     * @param Project $project
     */
    public function __construct(ProjectDailylog $projectDailylog, Project $project)
    {
        $this->projectDailylog = $projectDailylog;
        $this->project = $project;
    }

    /**
     * @param ProjectDailylogIndex $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(ProjectDailylogIndex $request): JsonResponse
    {
    	$queryParams = $request->validatedOnly();

        $projectDailylog = $this->projectDailylog
        	->where('project_id', $queryParams['project_id'])
        	->get();
        	
        return $this->respond($projectDailylog);
    }

    /**
     * @param ProjectDailylogStore $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ProjectDailylogStore $request): JsonResponse
    {
    	$queryParams = $request->validatedOnly();
        $projectDailylog = $this->projectDailylog->create($queryParams);

        return $this->respond(['message' => 'Project Dailylog successfully created']);
    }

    /**
     * @param ProjectDailylogUpdate $request
     *
     * @return JsonResponse
     */
    public function update(ProjectDailylogUpdate $request): JsonResponse
    {

        $projectDailylog = $this->projectDailylog
            ->findOrFail($request->input('id'));
        $projectDailylog->update($request->validatedOnly());

        return $this->respond(['message' => 'Project Dailylog successfully updated', 'projectDailylog' => $projectDailylog]);
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $this->projectDailylog->findOrFail($id)->delete();

        return $this->respond(['message' => 'Project Dailylog successfully deleted']);
    }
}
