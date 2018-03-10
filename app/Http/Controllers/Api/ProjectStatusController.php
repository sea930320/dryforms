<?php

namespace App\Http\Controllers\Api;

use App\Models\ProjectStatus;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class ProjectStatusController extends ApiController
{
    /**
     * @var ProjectStatus
     */
    private $status;

    /**
     * ProjectStatusController constructor.
     *
     * @param ProjectStatus $status
     */
    public function __construct(ProjectStatus $status)
    {
        $this->status = $status;
    }

    /**
     *
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
    	$statuses = $this->status->get();
        return $this->respond(['statuses' => $statuses]);
    }
}
