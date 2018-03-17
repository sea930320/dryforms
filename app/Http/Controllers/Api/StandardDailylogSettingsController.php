<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\StandardDailylogSetting;
use App\Http\Requests\StandardDailylogSettings\StandardDailylogSettingsUpdate;
use App\Http\Requests\StandardDailylogSettings\StandardDailylogSettingsStore;

use Symfony\Component\HttpFoundation\JsonResponse;

class StandardDailylogSettingsController extends ApiController
{
     /**
     * @var StandardDailylogSetting
     */
    private $dailylog;

    /**
     * StandardDailylogSettingsController constructor.
     *
     * @param StandardDailylogSetting $dailylog
     */
    public function __construct(StandardDailylogSetting $dailylog)
    {
        $this->dailylog = $dailylog;
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $dailylog = $this->dailylog->first();

        return $this->respond($dailylog);
    }

    /**
     * @param StandardDailylogSettingsUpdate $request
     *
     * @return JsonResponse
     */
    public function update(StandardDailylogSettingsUpdate $request): JsonResponse
    {
    	$dailylog = $this->dailylog->findOrFail($request->input('id'));
        $dailylog->update($request->validatedOnly());

        return $this->respond(['message' => 'Dailylog Setting successfully updated', 'dailylog' => $dailylog]);
    }

    /**
     * @param StandardDailylogSettingsStore $request
     *
     * @return JsonResponse
     */
    public function store(StandardDailylogSettingsStore $request): JsonResponse
    {
        $dailylog = $this->dailylog->create([
        	'company_id' => auth()->user()->company_id,
        	'automatically_copy' => $request->input('automatically_copy')
        ]);

        return $this->respond(['message' => 'Dailylog Setting successfully created', 'dailylog' => $dailylog]);
    }
}
