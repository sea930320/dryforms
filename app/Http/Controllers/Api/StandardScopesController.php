<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StandardScopes\StandardScopesIndex;
use App\Http\Requests\StandardScopes\StandardScopesStore;
use App\Http\Requests\StandardScopes\StandardScopesUpdate;

use App\Models\StandardScope;
use App\Models\DefaultScope;

use Symfony\Component\HttpFoundation\JsonResponse;

class StandardScopesController extends ApiController
{
    /**
     * @var StandardScope
     */
    private $standard_scope;
    private $default_scope;
    /**
     * StandardScopesController constructor.
     *
     * @param StandardScope $standard_scope
     * @param DefaultScope $default_scope
     */
    public function __construct(StandardScope $standard_scope, DefaultScope $default_scope)
    {
        $this->standard_scope = $standard_scope;
        $this->default_scope = $default_scope;
    }

    /**
     * @param StandardScopesIndex $request
     *
     * @return JsonResponse
     */
    public function index(StandardScopesIndex $request): JsonResponse
    {
    	$standard_scope = $this->standard_scope->get();
    	$default_scope = $this->default_scope->get();
    	$scopes = $this->standard_scope->count() > 0 ? $standard_scope : $default_scope;
        return $this->respond(['scopes' => $scopes]);
    }

    /**
     * @param StandardScopesStore $request
     *
     * @return JsonResponse
     */
    public function store(StandardScopesStore $request): JsonResponse
    {
    	$this->standard_scope->where('company_id', auth()->user()->company_id)->delete();

    	$scopes = $request->get('scopes');
    	foreach ($scopes as $key => $scope) {
            $scope['company_id'] = auth()->user()->company_id;
            $this->standard_scope->create($scope);
        }

        return $this->respond(['message' => 'Standard Scopes successfully saved']);
    }
}
