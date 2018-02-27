<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Materials\MaterialIndex;
use App\Http\Requests\Materials\MaterialStore;
use App\Http\Requests\Materials\MaterialUpdate;
use App\Models\StandardMaterial;
use App\Models\DefaultMaterial;

use Illuminate\Http\JsonResponse;

class MaterialsController extends ApiController
{
    /**
     * @var StandardMaterial
     */
    private $material;

    /**
     * @var DefaultMaterial
     */
    private $defaultMaterial;

    /**
     * MaterialsController constructor.
     *
     * @param StandardMaterial $material
     * @param DefaultMaterial $defaultMaterial
     */
    public function __construct(StandardMaterial $material, DefaultMaterial $defaultMaterial)
    {
        $this->material = $material;
        $this->defaultMaterial = $defaultMaterial;
    }

    /**
     * @param MaterialIndex $request
     *
     * @return JsonResponse
     */
    public function index(MaterialIndex $request): JsonResponse
    {
        if ($this->material->count() == 0) {
            $defaultMaterials = $this->defaultMaterial->get();
            foreach ($defaultMaterials as $key => $defaultMaterial) {
                $this->material->create([
                    'title' => $defaultMaterial['title'],
                    'company_id' => auth()->user()->company->id
                ]);
            }
        }
        $materials = $this->material->get();
        return $this->respond([
            'materials' => $materials
        ]);
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $material = $this->material
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
        $material = $this->material->create([
            'title' => $request->get('title'),
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

        $material = $this->material
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
        $this->material->findOrFail($id)->delete();

        return $this->respond(['message' => 'Material successfully deleted']);
    }
}
