<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StandardForms\StandardFormsIndex;
use App\Http\Requests\StandardForms\StandardFormStore;
use App\Http\Requests\StandardForms\StandardFormUpdate;
use App\Http\Requests\StandardForms\StatementStore;

use App\Models\StandardForm;
use App\Models\DefaultFromData;
use App\Models\StandardStatement;

use Symfony\Component\HttpFoundation\JsonResponse;

class StandardsController extends ApiController
{
    /**
     * @var StandardForm
     */
    private $standardForm;

    /**
     * @var DefaultFromData
     */
    private $defaultFormData;

    /**
     * @var StandardStatement
     */
    private $standardStatement;

    /**
     * StandardsController constructor.
     *
     * @param StandardForm $standardForm
     * @param DefaultFromData $defaultFromData
     * @param StandardStatement $standardStatement
     */
    public function __construct(StandardForm $standardForm, DefaultFromData $defaultFromData, StandardStatement $standardStatement)
    {
        $this->standardForm = $standardForm;
        $this->defaultFormData = $defaultFromData;
        $this->standardStatement = $standardStatement;
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
     * @param int $form_id
     *
     * @return JsonResponse
     */
    public function show(int $form_id): JsonResponse
    {
        $form = $this->standardForm->where('form_id', $form_id)->first();
        $statements = $this->standardStatement->where('form_id', $form_id)->get();
        return $this->respond([
            'form' => $form,
            'statements' => $statements
        ]);
    }

    /**
     * @param StandardFormStore $request
     *
     * @return JsonResponse
     */
    public function store(StandardFormStore $request): JsonResponse
    {
        $form = $this->standardForm->create($request->validatedOnly());

        return $this->respond(['message' => 'Form successfully created', 'form' => $form]);
    }

    /**
     * @param StatementStore $request
     *
     * @return JsonResponse
     */
    public function statementStore(StatementStore $request): JsonResponse
    {
        $statement = $this->standardStatement->create([
            'form_id' => $request->get('form_id'),
            'company_id' => auth()->user()->company_id,
            'title' => $request->get('title'),
            'statement' => ''
        ]);

        return $this->respond(['message' => 'Statement successfully created', 'statement' => $statement]);
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function statementDelete(int $id): JsonResponse
    {
        $this->standardStatement->findOrFail($id)->delete();

        return $this->respond(['message' => 'Statement successfully deleted']);
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
        if ($request->has('statements')) {
            $statements = $request->get('statements');
            foreach ($statements as $key => $statement) {
                $standardStatement = $this->standardStatement->find($statement['id']);
                $standardStatement->update($statement);
            }
        }
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