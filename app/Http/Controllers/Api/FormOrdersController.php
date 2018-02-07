<?php

namespace App\Http\Controllers\Api;

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
        	->with(['form', 'standard_form' => function($query) {
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
