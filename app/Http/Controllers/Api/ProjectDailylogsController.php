<?php

namespace App\Http\Controllers\Api;

use App\Models\Form;
use App\Models\ProjectDailylog;
use App\Models\Project;
use App\Models\StandardForm;
use App\Models\DefaultFromData;
use App\Models\StandardDailylogSetting;

use Illuminate\Http\JsonResponse;

use App\Http\Requests\ProjectDailylog\ProjectDailylogIndex;
use App\Http\Requests\ProjectDailylog\ProjectDailylogStore;
use App\Http\Requests\ProjectDailylog\ProjectDailylogUpdate;

class ProjectDailylogsController extends ApiController
{
    /**
     * @var Form
     */
    private $form;

    /**
     * @var ProjectDailylog
     */
    private $projectDailylog;

    /**
     * @var Project
     */
    private $project;

    /**
     * @var StandardForm
     */
    private $standardForm;

    /**
     * @var DefaultFromData
     */
    private $defaultFormData;

    /**
     * @var StandardDailylogSetting
     */
    private $standardDailylogSetting;
    
    /**
     * ProjectDailylogsController constructor.
     *
     * @param Form $form
     * @param ProjectDailylog $projectDailylog
     * @param Project $project
     * @param StandardDailylogSetting $standardDailylogSetting
     */
    public function __construct(Form $form, StandardForm $standardForm, DefaultFromData $defaultFromData, ProjectDailylog $projectDailylog, Project $project, StandardDailylogSetting $standardDailylogSetting)
    {
        $this->form = $form;
        $this->projectDailylog = $projectDailylog;
        $this->project = $project;
        $this->standardForm = $standardForm;
        $this->defaultFormData = $defaultFromData;
        $this->standardDailylogSetting = $standardDailylogSetting;
    }

    /**
     * @param ProjectDailylogIndex $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(ProjectDailylogIndex $request): JsonResponse
    {
        $user = auth()->user();
        $queryParams = $request->validatedOnly();

        $standardDailylogSetting = $this->standardDailylogSetting->get();
        $autoCopy = 0;

        if (count($standardDailylogSetting) > 0) {
            $autoCopy = $standardDailylogSetting[0]['automatically_copy'];
        }
        $projectDailylog = $this->projectDailylog
            ->where('project_id', $queryParams['project_id']);

        if ($autoCopy === 0) {
            $projectDailylog = $projectDailylog->where('is_copied', $autoCopy);
        }
        $projectDailylogs = $projectDailylog->orderBy('updated_at', 'desc')->get();
        return $this->respond([
            'projectDailylogs' => $projectDailylogs,
            'userName' => $user['first_name']. ' '. $user['last_name']
        ]);
    }

    /**
     * @param int $form_id
     * @param ProjectDailylogIndex $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($form_id, ProjectDailylogIndex $request): JsonResponse
    {
    	$queryParams = $request->validatedOnly();

        $form = $this->standardForm->where('form_id', $queryParams['form_id'])->first();
        $defaultForm = $this->defaultFormData->where('form_id', $queryParams['form_id'])->first();
        if ($form && $form['additional_notes_show'] == 0) {
            return $this->respond([
                'is_enable' => false
            ]);
        } else if (!$form) {
            if (!$defaultForm || ($defaultForm && $defaultForm['additional_notes_show'] == 0)) {
                return $this->respond([
                    'is_enable' => false
                ]);
            }
        }
        $projectDailylog = $this->projectDailylog
        	->where('project_id', $queryParams['project_id'])
        	->where('is_copied', $queryParams['is_copied'])
        	->where('form_id', $queryParams['form_id'])
        	->get();

        return $this->respond([
            'is_enable' => true,
            'project_daily_log' => $projectDailylog
        ]);
    }

    /**
     * @param ProjectDailylogStore $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ProjectDailylogStore $request): JsonResponse
    {
    	$queryParams = $request->validatedOnly();
    	$queryParams['company_id'] = auth()->user()->company_id;
        $projectDailylog = $this->projectDailylog->create($queryParams);

        return $this->respond(['message' => 'Project Dailylog successfully created', 'projectDailylog' => $projectDailylog]);
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
        $queryParams = $request->validatedOnly();
        unset($queryParams['id']);
        $projectDailylog->update($queryParams);

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
