<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\FormOrders\FormOrdersStore;

use App\Models\FormOrder;
use App\Models\Form;

use Illuminate\Http\JsonResponse;

class FormOrdersController extends ApiController
{
    /**
     * @var FormOrder
     */
    private $formOrder;

    /**
     * @var Form
     */
    private $form;

    /**
     * FormOrdersController constructor.
     *
     * @param FormOrder $formOrder
     * @param Form $form
     */
    public function __construct(FormOrder $formOrder, Form $form)
    {
        $this->formOrder = $formOrder;
        $this->form = $form;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        $formOrders = $this->formOrder
        	->with(['form', 'default_forms_data', 'standard_form' => function($query) {
        		$query->where('company_id', auth()->user()->company_id);
        	}])
        	->where('company_id', auth()->user()->company_id);

        $forms = $this->form->get();

        if ($formOrders->count() === 0) {
        	$this->storeNewOrders($forms);
        } else if ($formOrders->count() !== $this->form->count()) {
        	$formOrders->delete();
			$this->storeNewOrders($forms);
        }

        $formOrders = $formOrders->get();
        return $this->respond($formOrders);
    }

    /**
     * @param FormOrdersStore $request
     *
     * @return JsonResponse
     */
    public function store(FormOrdersStore $request): JsonResponse
    {
    	$formsOrder = $request->get('formsOrder');
    	$formsOrderIDs = array_map(function($formOrder) {
    		return $formOrder['id'];
    	}, $formsOrder);
    	sort($formsOrderIDs, SORT_NUMERIC);
    	foreach ($formsOrderIDs as $key => $id) {
    		$this->formOrder->find($id)->update([
    			'form_id' => $formsOrder[$key]['form_id']
    		]);
    	}
        return $this->respond(['message' => 'Form Order successfully saved']);
    }

    /**
     * @param array forms
     *
     * @return void
     */
    private function storeNewOrders($forms) {
    	$company_id = auth()->user()->company_id;

    	foreach ($forms as $key => $form) {
			$formOrder = $this->formOrder->create([
	            'company_id' => $company_id,
	            'form_id' => $form->id
	        ]);
		}
    }
}
