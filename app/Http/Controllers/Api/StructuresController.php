<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Structures\StructureIndex;
use App\Http\Requests\Structures\StructureStore;
use App\Http\Requests\Structures\StructureUpdate;
use App\Models\StandardStructure;
use Illuminate\Http\JsonResponse;

class StructuresController extends ApiController
{
    /**
     * @var StandardStructure
     */
    private $structures;

    /**
     * StructuresController constructor.
     *
     * @param StandardStructure $structures
     */
    public function __construct(StandardStructure $structures)
    {
        $this->structures = $structures;
    }

    /**
     * @param StructureIndex $request
     *
     * @return JsonResponse
     */
    public function index(StructureIndex $request): JsonResponse
    {
        $provided_structures = $this->structures->where('type', 'system');
        $manual_structures = $this->structures->where('company_id', auth()->user()->company->id);
        $provided_structures = $provided_structures->get();
        $manual_structures = $manual_structures->get();

        return $this->respond([
            'provided_structures' => $provided_structures,
            'manual_structures'=> $manual_structures
        ]);
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $structure = $this->structures
            ->where('company_id', auth()->user()->company->id)
            ->orWhere('type', 'system')
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
        $structure = $this->structures->create([
            'title' => $request->get('title'),
            'type' => $request->get('type'),
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
        $structure = $this->structures
            ->where('company_id', auth()->user()->company->id)
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
        $this->structures->findOrFail($id)->delete();

        return $this->respond(['message' => 'Structure successfully deleted']);
    }
}
