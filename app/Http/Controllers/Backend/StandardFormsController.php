<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\DefaultFromData;
use App\Http\Requests\Standards\FormUpdate;
use Prologue\Alerts\Facades\Alert;

class StandardFormsController extends Controller
{
    /**
     * @var DefaultFromData
     */
    private $defaultFormData;

    /**
     * StandardFormsController constructor.
     *
     * @param DefaultFromData $defaultFromData
     */
    public function __construct(DefaultFromData $defaultFromData)
    {
        $this->defaultFormData = $defaultFromData;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $forms = $this->defaultFormData->paginate(20);

        return view('dashboard.standard-forms.index', compact('forms'));
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(int $id)
    {
        $form = $this->defaultFormData->findOrFail($id);

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
        $form->statement = $request->get('statement');
        $form->save();

        Alert::success('Form successfully updated')->flash();

        return redirect()->route('forms.index')->with('alerts', Alert::all());
    }
}