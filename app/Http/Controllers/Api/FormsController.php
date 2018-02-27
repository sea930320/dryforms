<?php
namespace App\Http\Controllers\Api;

use App\Models\DefaultFromData;
use App\Models\Form;
use Illuminate\Http\JsonResponse;

class FormsController extends ApiController
{
    /**
     * @var Form
     */
    private $form;

    /**
     * @var DefaultFromData
     */
    private $defaultFormData;

    /**
     * FormsController constructor.
     *
     * @param Form $form
     * @param DefaultFromData $defaultFromData
     */
    public function __construct(Form $form, DefaultFromData $defaultFromData)
    {
        $this->form = $form;
        $this->defaultFormData = $defaultFromData;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        $forms = $this->form->get();

        return $this->respond($forms);
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $form = $this->form->findOrFail($id);
        $form->default_data = $this->defaultFormData->where('form_id', $form->id)->first();

        return $this->respond($form);
    }
}