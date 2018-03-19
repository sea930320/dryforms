<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests\ProjectStatement\ProjectStatementIndex;
use App\Http\Requests\ProjectStatement\ProjectStatementStore;
use App\Http\Requests\ProjectStatement\ProjectStatementUpdate;

use App\Models\ProjectStatement;
use App\Models\StandardStatement;
use App\Models\DefaultStatement;

use Symfony\Component\HttpFoundation\JsonResponse;

class ProjectStatementsController extends ApiController
{
    /**
     * @var ProjectStatement
     */
    private $projectStatement;

    /**
     * @var StandardStatement
     */
    private $standardStatement;

    /**
     * @var DefaultStatement
     */
    private $defaultStatement;
    /**
     * ProjectStatementsController constructor.
     *
     * @param ProjectStatement $projectStatement
     * @param StandardStatement $standardStatement
     * @param DefaultStatement $defaultStatement
     */
    public function __construct(ProjectStatement $projectStatement, StandardStatement $standardStatement, DefaultStatement $defaultStatement)
    {
        $this->projectStatement = $projectStatement;
        $this->standardStatement = $standardStatement;
        $this->defaultStatement = $defaultStatement;
    }

    /**
     * @param ProjectStatementIndex $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(ProjectStatementIndex $request): JsonResponse
    {
    	$queryParams = $request->validatedOnly();
        $projectStatement = $this->projectStatement
        	->where('project_id', $queryParams['project_id'])
        	->where('form_id', $queryParams['form_id']);
        $projectStatements = [];

        if ($projectStatement->count() === 0) {
        	$standardStatement = $this->standardStatement
        		->where('form_id', $queryParams['form_id']);        	
        	if ($standardStatement->count() === 0) {
        		$defaultStatements = $this->defaultStatement
	        	->where('form_id', $queryParams['form_id'])
	        	->get();
        		foreach ($defaultStatements as $key => $defaultStatement) {
        			$defaultStatement = $defaultStatement->toArray();
        			unset($defaultStatement['id']);
        			unset($defaultStatement['created_at']);
        			unset($defaultStatement['updated_at']);
	        		$defaultStatement['company_id'] = auth()->user()->company_id;
	        		
	        		$this->standardStatement->create($defaultStatement);
	        		$defaultStatement['project_id'] = $queryParams['project_id'];
	        		$this->projectStatement->create($defaultStatement);
	        	}
	        	$projectStatements = $projectStatement->get();
        	} else {
        		$standardStatements = $standardStatement->get();
        		foreach ($standardStatements as $key => $standardStatement) {
        			$standardStatement = $standardStatement->toArray();
        			unset($standardStatement['id']);
        			unset($standardStatement['created_at']);
        			unset($standardStatement['updated_at']);
	        		$standardStatement['company_id'] = auth()->user()->company_id;
	        		$standardStatement['project_id'] = $queryParams['project_id'];
	        		$this->projectStatement->create($standardStatement);
	        	}
	        	$projectStatements = $projectStatement->get();
        	}
        } else {
        	$projectStatements = $projectStatement->get();
        }
        return $this->respond([
        	'projectStatements' => $projectStatements
        ]);
    }

    /**
     * @param ProjectStatementUpdate $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ProjectStatementUpdate $request): JsonResponse
    {
    	$queryParams = $request->validatedOnly();
       	$projectStatement = $this->projectStatement
            ->findOrFail($queryParams['id']);
        unset($queryParams['id']);
        $projectStatement->update($queryParams);

        return $this->respond(['message' => 'Project Statement successfully updated', 'projectStatement' => $projectStatement]);
    }
}
