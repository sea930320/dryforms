<?php
namespace App\Http\Controllers\Api;

use App\Models\DefaultFromData;
use App\Models\DefaultStatement;
use App\Models\StandardForm;
use App\Models\StandardStatement;
use App\Models\Form;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FormsController extends ApiController
{
    /**
     * @var Form
     */
    private $form;

    /**
     * @var DefaultFromData
     */
    private $standardForm;

    /**
     * @var DefaultStatement
     */
    private $standardStatement;

    private $defaultFromData;

    private $defaultStatement;

    /**
     * FormsController constructor.
     *
     * @param Form $form
     * @param DefaultFromData $defaultFromData
     */
    public function __construct(Form $form, StandardForm $standardForm, StandardStatement $standardStatement, DefaultFromData $defaultFromData, DefaultStatement $defaultStatement)
    {
        $this->form = $form;
        $this->standardForm = $standardForm;
        $this->standardStatement = $standardStatement;
        $this->defaultFromData = $defaultFromData;
        $this->defaultStatement = $defaultStatement;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        $forms = $this->form->get();

        return $this->respond($forms);
    }

    public function store(Request $request): JsonResponse
    {
        $newform = $this->form->create([
            'company_id' => auth()->user()->company_id,
            'name' => $request->form_name
        ]);
        $this->defaultFromData->create([
            'form_id' => $newform->id,
            'name' => $request->form_menuname,
            'title' => $request->form_title,
            'additional_notes_show' => $request->addNotes,
            'footer_text_show' => $request->addFooter
        ]);
        $this->standardForm->create([
            'company_id' => auth()->user()->company_id,
            'form_id' => $newform->id,
            'name' => $request->form_menuname,
            'title' => $request->form_title,
            'additional_notes_show' => $request->addNotes,
            'footer_text_show' => $request->addFooter
        ]);
        $statements = $request->statements;
        foreach($statements as $key => $statement){
            $this->defaultStatement->create([
                'form_id' => $newform->id,
                'title' => $statement['title'],
                'statement' => '<h1>some content</h1>'
            ]);
            $this->standardStatement->create([
                'company_id' => auth()->user()->company_id,
                'form_id' => $newform->id,
                'title' => $statement['title'],
                'statement' => '<h1>some content</h1>'
            ]);
        }
        return $this->respond(['message' => 'Form successfully saved']);
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