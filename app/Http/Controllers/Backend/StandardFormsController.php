<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\DefaultFromData;
use App\Models\DefaultStatement;

use App\Http\Requests\Standards\FormUpdate;
use Prologue\Alerts\Facades\Alert;

class StandardFormsController extends Controller
{
    /**
     * @var DefaultFromData
     */
    private $defaultFormData;

    /**
     * @var DefaultStatement
     */
    private $defaultStatement;
    /**
     * StandardFormsController constructor.
     *
     * @param DefaultFromData $defaultFromData
     * @param DefaultStatement $defaultStatement
     */
    public function __construct(DefaultFromData $defaultFromData, DefaultStatement $defaultStatement)
    {
        $this->defaultFormData = $defaultFromData;
        $this->defaultStatement = $defaultStatement;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $forms = $this->defaultFormData->with(['default_statements'])->paginate(20);

        return view('dashboard.standard-forms.index', compact('forms'));
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(int $id)
    {
        $form = $this->defaultFormData->with(['default_statements'])->findOrFail($id);

        return view('dashboard.standard-forms.form', compact('form'));
    }

    /**
     * @param FormUpdate $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(FormUpdate $request)
    {
        $form = $this->defaultFormData->findOrFail($request->get('id'));
        $form->title = $request->get('title');
        $form->name = $request->get('name');
        $form->save();
        if ($request->has('statement_ids')) {
            $statement_ids = $request->get('statement_ids');
            $statement_titles = $request->get('statement_titles');
            $statement_texts = $request->get('statement_texts');
            foreach ($statement_ids as $key => $id) {
                $defaultStatement = $this->defaultStatement->find($id);
                $defaultStatement->update([
                    'title' => $statement_titles[$key],
                    'statement' => $statement_texts[$key]
                ]);
            }
        }
        Alert::success('Form successfully updated')->flash();

        return redirect()->route('forms.index')->with('alerts', Alert::all());
    }
}