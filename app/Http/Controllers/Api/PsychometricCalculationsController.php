<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\PsychometricCalculationRequest;
use App\Services\Psychometric\CalculationService;

class PsychometricCalculationsController extends ApiController
{
    /**
     * @var CalculationService
     */
    private $calculationService;

    /**
     * PsychometricCalculationsController constructor.
     * @param CalculationService $calculationService
     */
    public function __construct(CalculationService $calculationService)
    {
        $this->calculationService = $calculationService;
    }

    /**
     * @param PsychometricCalculationRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function calculate(PsychometricCalculationRequest $request)
    {
        $result = $this->calculationService->calculate($request->get('temperature'), $request->get('rh'));

        return $this->respond(['result' => $result]);
    }
}