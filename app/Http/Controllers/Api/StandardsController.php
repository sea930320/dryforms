<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StandardForms\StandardFormsIndex;
use App\Http\Requests\StandardForms\StandardFormStore;
use App\Http\Requests\StandardForms\StandardFormUpdate;
use App\Models\StandardForm;
use Symfony\Component\HttpFoundation\JsonResponse;

class StandardsController extends ApiController
{
    /**
     * @var StandardForm
     */
    private $standardForm;

    /**
     * StandardsController constructor.
     *
     * @param StandardForm $standardForm
     */
    public function __construct(StandardForm $standardForm)
    {
        $this->standardForm = $standardForm;
    }

    /**
     * @param StandardFormsIndex $request
     *
     * @return JsonResponse
     */
    public function index(StandardFormsIndex $request): JsonResponse
    {
        $forms = $this->standardForm->all();

        return $this->respond($forms);
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $form = $this->standardForm->find($id);

        return $this->respond($form);
    }

    /**
     * @param StandardFormStore $request
     *
     * @return JsonResponse
     */
    public function store(StandardFormStore $request): JsonResponse
    {
        $form = $this->standardForm->create([
            'form_id' => $request->get('form_id'),
            'company_id' => $request->get('company_id'),
            'name' => $request->get('name'),
            'title' => $request->get('title'),
            'statement' => $request->get('statement'),
        ]);

        return $this->respond(['message' => 'Form successfully created', 'form' => $form]);
    }

    /**
     * @param StandardFormUpdate $request
     *
     * @return JsonResponse
     */
    public function update(StandardFormUpdate $request): JsonResponse
    {
        $form = $this->standardForm->find($request->input('id'));
        $form->update($request->validatedOnly());

        return $this->respond(['message' => 'Form successfully updated', 'form' => $form]);
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $this->standardForm->findOrFail($id)->delete();

        return $this->respond(['message' => 'Form successfully deleted']);
    }
}