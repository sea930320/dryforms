<?php
namespace App\Http\Controllers\Api;

use App\Models\Form;
use Illuminate\Http\JsonResponse;

class FormsController extends ApiController
{
    /**
     * @var Form
     */
    private $form;

    /**
     * FormsController constructor.
     *
     * @param Form $form
     */
    public function __construct(Form $form)
    {
        $this->form = $form;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        $forms = $this->form->paginate(20);

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

        return $this->respond($form);
    }
}