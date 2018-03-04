<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DefaultMaterial;

class StardardMoistureMapMaterialController extends Controller
{
    /**
     * @var DefaultMaterial
     */
    private $defaultMaterial;
    /**
     * StardardMoistureMapMaterialController constructor.
     *
     * @param DefaultMaterial $defaultMaterial
     */
    public function __construct(DefaultMaterial $defaultMaterial)
    {
    	$this->defaultMaterial = $defaultMaterial;
    }

    /**
     *
     * @return JsonResponse
     */
    public function index() {
    	$materials = $this->defaultMaterial->get();
    	return response()->json([
            'materials' => $materials
        ]);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $material = $this->defaultMaterial->create([
            'title' => $request->get('title')
        ]);

        return response()->json(['message' => 'Material successfully created', 'material' => $material]);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function update(Request $request)
    {
        $material = $this->defaultMaterial
            ->findOrFail($request->input('material_id'));
        $material->update([
        	'title' => $request->get('title')
        ]);

        return response()->json(['message' => 'Material successfully updated', 'material' => $material]);
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function destroy(int $id)
    {
        $this->defaultMaterial->findOrFail($id)->delete();

        return response()->json(['message' => 'Material successfully deleted']);
    }
}
