<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DefaultFromData;
use App\Models\DefaultScope;

use App\Http\Requests\DefaultForms\DefaultFormUpdate;
use Prologue\Alerts\Facades\Alert;

class StandardScopesController extends Controller
{
	/**
     * @var DefaultFromData
     */
    private $defaultFormData;

    /**
     * @var DefaultScope
     */
    private $defaultScope;

    /**
     * StandardScopesController constructor.
     *
     * @param DefaultFromData $defaultFromData
     * @param DefaultScope $defaultScope
     */
    public function __construct(DefaultFromData $defaultFromData, DefaultScope $defaultScope)
    {
        $this->defaultFormData = $defaultFromData;
        $this->defaultScope = $defaultScope;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {    	
        return view('dashboard.standard-forms.scope');
    }

    /**
     * @param int $pageID
     *
     * @return JsonResponse
     */
    public function show(int $pageID)
    {
        $scopes = $this->defaultScope
    		->where('page', $pageID)
    		->orderBy('no')
    		->get();
    	$maxPage = $this->defaultScope->max('page');
    	return response()->json([
    		'curPageScopes' => $scopes,
    		'maxPage' => $maxPage
    	], 200);
    }

    public function form()
    {
    	$form = $this->defaultFormData->where('form_id', 2)->first();
    	return response()->json(['form' => $form], 200);
    }

    public function formUpdate(DefaultFormUpdate $request)
    {
    	$form = $this->defaultFormData->where('form_id', $request->input('form_id'));
        $form->update($request->validatedOnly());
        return response()->json(['message' => 'Form successfully updated', 'form' => $form]);
    }

    public function store(Request $request)
    {
    	$scopes = $request->get('scopes');
    	$res_scopes = [];
    	foreach ($scopes as $key => $scope) {
            if ($scope['uom'] == 0)
            	$scope['uom'] = null;
            if (!array_key_exists('id', $scope) || !$scope['id']) {
	            $res_scope = $this->defaultScope->create($scope);
            }
	        else {
	        	$this->defaultScope->findOrFail($scope['id'])->update($scope);
	        	$res_scope = $scope;
	        }
	        array_push($res_scopes, $res_scope);
        }
    	return response()->json(['message' => 'Default Scopes successfully saved', 'scopes' => $res_scopes], 200);
    }

    public function destroy(int $id)
    {
        $this->defaultScope->where('page', $id)->delete();
        $maxPage = $this->defaultScope->max('page');
        for ($page = $id + 1; $page <= $maxPage; $page++) {
        	$this->defaultScope
        		->where('page', $page)
        		->update(['page' => $page - 1]);
        }
        return response()->json(['message' => 'Default Scope Page successfully deleted'], 200);
    }
}
