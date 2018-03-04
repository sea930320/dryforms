<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DefaultFromData;
use App\Models\DefaultArea;

use App\Http\Requests\DefaultForms\DefaultFormUpdate;

class StandardAffectedAreasController extends Controller
{
    /**
     * @var DefaultFromData
     */
    private $defaultFormData;
    /**
     * @var DefaultArea
     */
    private $defaultArea;

    /**
     * StandardAffectedAreasController constructor.
     *
     * @param DefaultFromData $defaultFromData
     * @param DefaultArea $defaultArea
     */
    public function __construct(DefaultFromData $defaultFromData, DefaultArea $defaultArea)
    {
    	$this->defaultFormData = $defaultFromData;
    	$this->defaultArea = $defaultArea;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function areaPage()
    {
        return view('dashboard.standard-forms.area');
    }
	/**
     *
     * @return JsonResponse
     */
    public function form()
    {
    	$form = $this->defaultFormData->where('form_id', 12)->first();
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

    /**
     *
     * @return JsonResponse
     */
    public function index() {
    	$areas = $this->defaultArea->get();
    	return response()->json([
            'areas' => $areas
        ]);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $area = $this->defaultArea->create([
            'title' => $request->get('title')
        ]);

        return response()->json(['message' => 'Area successfully created', 'area' => $area]);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function update(Request $request)
    {
        $structure = $this->defaultArea
            ->findOrFail($request->input('area_id'));
        $structure->update([
        	'title' => $request->get('title')
        ]);

        return response()->json(['message' => 'Area successfully updated', 'structure' => $structure]);
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function destroy(int $id)
    {
        $this->defaultArea->findOrFail($id)->delete();

        return response()->json(['message' => 'Area successfully deleted']);
    }
}
