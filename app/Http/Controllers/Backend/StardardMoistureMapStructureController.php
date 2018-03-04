<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DefaultStructure;

class StardardMoistureMapStructureController extends Controller
{
    /**
     * @var DefaultStructure
     */
    private $defaultStructure;

    /**
     * StardardMoistureMapStructureController constructor.
     *
     * @param DefaultStructure $defaultStructure
     */
    public function __construct(DefaultStructure $defaultStructure)
    {
        $this->defaultStructure = $defaultStructure;
    }
    /**
     *
     * @return JsonResponse
     */
    public function index() {
    	$structures = $this->defaultStructure->get();
    	return response()->json([
            'structures' => $structures
        ]);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $structure = $this->defaultStructure->create([
            'title' => $request->get('title')
        ]);

        return response()->json(['message' => 'Structure successfully created', 'structure' => $structure]);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function update(Request $request)
    {
        $structure = $this->defaultStructure
            ->findOrFail($request->input('structure_id'));
        $structure->update([
        	'title' => $request->get('title')
        ]);

        return response()->json(['message' => 'Structure successfully updated', 'structure' => $structure]);
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function destroy(int $id)
    {
        $this->defaultStructure->findOrFail($id)->delete();

        return response()->json(['message' => 'Structure successfully deleted']);
    }
}
