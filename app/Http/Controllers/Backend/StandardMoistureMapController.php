<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DefaultFromData;

use App\Http\Requests\DefaultForms\DefaultFormUpdate;

class StandardMoistureMapController extends Controller
{
	/**
     * @var DefaultFromData
     */
    private $defaultFormData;

    /**
     * StandardMoistureMapController constructor.
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
        return view('dashboard.standard-forms.moisture');
    }
	/**
     *
     * @return JsonResponse
     */
    public function form()
    {
    	$form = $this->defaultFormData->where('form_id', 7)->first();
    	return response()->json(['form' => $form], 200);
    }
    /**
     * @param DefaultFormUpdate $request
     *
     * @return JsonResponse
     */
    public function formUpdate(DefaultFormUpdate $request)
    {
    	$form = $this->defaultFormData->where('form_id', $request->input('form_id'));
        $form->update($request->validatedOnly());
        return response()->json(['message' => 'Form successfully updated', 'form' => $form]);
    }
}
