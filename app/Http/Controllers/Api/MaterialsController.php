<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Materials\MaterialIndex;
use App\Http\Requests\Materials\MaterialStore;
use App\Http\Requests\Materials\MaterialUpdate;
use App\Models\StandardMaterial;
use Illuminate\Http\JsonResponse;

class MaterialsController extends ApiController
{
    /**
     * @var StandardMaterial
     */
    private $materials;

    /**
     * MaterialsController constructor.
     *
     * @param StandardMaterial $materials
     */
    public function __construct(StandardMaterial $materials)
    {
        $this->materials = $materials;
    }

    /**
     * @param MaterialIndex $request
     *
     * @return JsonResponse
     */
    public function index(MaterialIndex $request): JsonResponse
    {
        $provided_materials = $this->materials->where('type', 'system');
        $manual_materials = $this->materials->where('company_id', auth()->user()->company->id);
        $provided_materials = $provided_materials->get();
        $manual_materials = $manual_materials->get();

        return $this->respond([
            'provided_materials' => $provided_materials,
            'manual_materials'=> $manual_materials
        ]);
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $material = $this->materials
            ->where('company_id', auth()->user()->company->id)
            ->orWhere('type', 'system')
            ->findOrFail($id);

        return $this->respond($material);
    }

    /**
     * @param MaterialStore $request
     *
     * @return JsonResponse
     */
    public function store(MaterialStore $request): JsonResponse
    {
        $material = $this->materials->create([
            'title' => $request->get('title'),
            'type' => $request->get('type'),
            'company_id' => auth()->user()->company->id,
        ]);

        return $this->respond(['message' => 'Material successfully created', 'material' => $material]);
    }

    /**
     * @param MaterialUpdate $request
     *
     * @return JsonResponse
     */
    public function update(MaterialUpdate $request): JsonResponse
    {
        $material = $this->materials
            ->where('company_id', auth()->user()->company->id)
            ->findOrFail($request->input('material_id'));
        $material->update($request->validatedOnly());

        return $this->respond(['message' => 'Material successfully updated', 'material' => $material]);
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $this->materials->findOrFail($id)->delete();

        return $this->respond(['message' => 'Material successfully deleted']);
    }
}
