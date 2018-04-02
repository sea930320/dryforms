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
    	if ($this->standard_scope->count() == 0) {
    		$default_scopes = $this->default_scope->get()->toArray();
    		foreach ($default_scopes as $key => $scope) {
	            $scope['company_id'] = auth()->user()->company_id;
		        $this->standard_scope->create($scope);
	        }
    	}
        if ($request->get('curPageNum') !== null) {
            $scopes = $this->standard_scope
                ->where('page', $request->get('curPageNum'))
                ->orderBy('no')
                ->get();
            $maxPage = $this->standard_scope->max('page');
            return $this->respond([
                'curPageScopes' => $scopes,
                'maxPage' => $maxPage
            ]);
        } else {
            $scopes = $this->standard_scope
                ->with('uom_info')
                ->orderBy('no')
                ->where('page', '<>', 0)
                ->get()
                ->groupBy('page');
            $miscScopes = $this->standard_scope
                ->with('uom_info')
                ->orderBy('no')
                ->where('page', 0)
                ->get();
            return $this->respond([
                'project_scopes' => $scopes,
                'misc_scopes' => $miscScopes
            ]);
        }
    }

    /**
     * @param StandardScopesStore $request
     *
     * @return JsonResponse
     */
    public function store(StandardScopesStore $request): JsonResponse
    {
    	$scopes = $request->get('scopes');
    	$res_scopes = [];
    	foreach ($scopes as $key => $scope) {
            $scope['company_id'] = auth()->user()->company_id;
            if ($scope['uom'] == 0)
            	$scope['uom'] = null;
            if (!array_key_exists('id', $scope) || !$scope['id']) {
	            $res_scope = $this->standard_scope->create($scope);
            }
	        else {
	        	$this->standard_scope->findOrFail($scope['id'])->update($scope);
	        	$res_scope = $scope;
	        }
	        array_push($res_scopes, $res_scope);
        }

        return $this->respond(['message' => 'Standard Scopes successfully saved', 'scopes' => $res_scopes]);
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $this->standard_scope->where('page', $id)->delete();
        $maxPage = $this->standard_scope->max('page');
        for ($page = $id + 1; $page <= $maxPage; $page++) {
        	$this->standard_scope
        		->where('page', $page)
        		->update(['page' => $page - 1]);
        }
        return $this->respond(['message' => 'Scope Page successfully deleted']);
    }
}
