<?php

namespace App\Http\Controllers\Api;

use App\Models\ProjectForm;
use App\Models\StandardForm;
use App\Models\DefaultFromData;
use Illuminate\Http\JsonResponse;

use App\Http\Requests\ProjectForm\ProjectFormIndex;
use App\Http\Requests\ProjectForm\ProjectFormStore;
use App\Http\Requests\ProjectForm\ProjectFormSignatureUpdate;
use App\Http\Requests\ProjectFooterText\ProjectFooterTextIndex;

class ProjectFormsController extends ApiController
{
    /**
     * @var ProjectForm
     */
    private $projectForm;
    /**
     * @var StandardForm
     */
    private $standardForm;
    /**
     * @var DefaultFromData
     */
    private $defaultFormData;

    /**
     * FormsController constructor.
     *
     * @param ProjectForm $projectForm
     */
    public function __construct(StandardForm $standardForm, DefaultFromData $defaultFromData, ProjectForm $projectForm)
    {
        $this->projectForm = $projectForm;
        $this->standardForm = $standardForm;
        $this->defaultFormData = $defaultFromData;
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

    /**
     * @param ProjectFooterTextIndex $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getFooter(ProjectFooterTextIndex $request): JsonResponse
    {
        $queryParams = $request->validatedOnly();

        $standardForm = $this->standardForm
            ->where('form_id', $queryParams['form_id']);
        if ($standardForm->count() > 0) {
            $standardForm = $standardForm->first();
            if ($standardForm->footer_text_show !== 0) {
                return $this->respond([
                    'standardForm' => $standardForm,
                    'message' => 'visible'
                ]);
            } else {
                return $this->respond([
                    'message' => 'invisible'
                ]);
            }
        }

        $defaultFormData = $this->defaultFormData
            ->where('form_id', $queryParams['form_id']);
        if ($defaultFormData->count() > 0) {
            $defaultFormData = $defaultFormData->first();
            if ($defaultFormData->footer_text_show !== 0) {
                return $this->respond([
                    'standardForm' => $defaultFormData,
                    'message' => 'visible'
                ]);
            } else {
                return $this->respond([
                    'message' => 'invisible'
                ]);
            }
        }
    }

    /**
     * @param ProjectFormSignatureUpdate $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function setSignature(ProjectFormSignatureUpdate $request)
    {
        $project_id = $request->input('project_id');
        $form_id = $request->input('form_id');
        $queryParams = $request->validatedOnly();
        unset($queryParams['id']);

        $projectForm = $this->projectForm
            ->where('project_id', $project_id)
            ->where('form_id', $form_id);
        $projectForm->update($queryParams);

        return $this->respond(['message' => 'Project Signature successfully updated', 'projectForm' => $projectForm->first()]);
    }
}
