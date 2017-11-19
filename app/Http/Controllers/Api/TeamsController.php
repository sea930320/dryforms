<?php
namespace App\Http\Controllers\Api;

use App\Http\Requests\Teams\TeamStore;
use App\Http\Requests\Teams\TeamUpdate;
use App\Models\Team;
use Symfony\Component\HttpFoundation\JsonResponse;

class TeamsController extends ApiController
{
    /**
     * @var Team
     */
    private $team;

    /**
     * EquipmentCategoriesController constructor.
     *
     * @param Team $team
     */
    public function __construct(Team $team)
    {
        $this->team = $team;
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $teams = $this->team->paginate(20);

        return $this->respond($teams);
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $team = $this->team->findOrFail($id);

        return $this->respond($team);
    }

    /**
     * @param TeamStore $request
     *
     * @return JsonResponse
     */
    public function store(TeamStore $request): JsonResponse
    {
        $team = $this->team->create([
            'name' => $request->get('name'),
            'description' => $request->get('description'),
        ]);

        return $this->respond(['message' => 'Team successfully created', 'team' => $team]);
    }

    /**
     * @param TeamUpdate $request
     *
     * @return JsonResponse
     */
    public function update(TeamUpdate $request): JsonResponse
    {
        $team = $this->team->find($request->input('team_id'));
        $team->update($request->validatedOnly());

        return $this->respond(['message' => 'Team successfully updated', 'team' => $team]);
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $this->team->findOrFail($id)->delete();

        return $this->respond(['message' => 'Team successfully deleted']);
    }
}