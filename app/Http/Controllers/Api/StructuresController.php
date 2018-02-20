<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Structures\StructureIndex;
use App\Http\Requests\Structures\StructureStore;
use App\Http\Requests\Structures\StructureUpdate;
use App\Models\StandardStructure;
use App\Models\DefaultStructure;

use Illuminate\Http\JsonResponse;

class StructuresController extends ApiController
{
    /**
     * @var StandardStructure
     */
    private $structure;

    /**
     * @var DefaultStructure
     */
    private $defaultStructure;

    /**
     * StructuresController constructor.
     *
     * @param StandardStructure $structure
     * @param DefaultStructure $defaultStructure
     */
    public function __construct(StandardStructure $structure, DefaultStructure $defaultStructure)
    {
        $this->structure = $structure;
        $this->defaultStructure = $defaultStructure;
    }

    /**
     * @param StructureIndex $request
     *
     * @return JsonResponse
     */
    public function index(StructureIndex $request): JsonResponse
    {
        if ($this->structure->count() == 0) {
            $defaultStructures = $this->defaultStructure->get();
            foreach ($defaultStructures as $key => $defaultStructure) {
                $this->structure->create([
                    'title' => $defaultStructure['title'],
                    'company_id' => auth()->user()->company->id
                ]);
            }
        }
        $structures = $this->structure->get();
        return $this->respond([
            'structures' => $structures
        ]);
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $structure = $this->structure
            ->findOrFail($id);
        return $this->respond($structure);
    }

    /**
     * @param StructureStore $request
     *
     * @return JsonResponse
     */
    public function store(StructureStore $request): JsonResponse
    {
        $structure = $this->structure->create([
            'title' => $request->get('title'),
            'company_id' => auth()->user()->company->id,
        ]);

        return $this->respond(['message' => 'Structure successfully created', 'structure' => $structure]);
    }

    /**
     * @param StructureUpdate $request
     *
     * @return JsonResponse
     */
    public function update(StructureUpdate $request): JsonResponse
    {
        $structure = $this->structure
            ->findOrFail($request->input('structure_id'));
        $structure->update($request->validatedOnly());

        return $this->respond(['message' => 'Structure successfully updated', 'structure' => $structure]);
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $this->structure->findOrFail($id)->delete();

        return $this->respond(['message' => 'Structure successfully deleted']);
    }
}
