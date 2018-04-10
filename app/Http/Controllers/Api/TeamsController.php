<?php
namespace App\Http\Controllers\Api;

use App\Http\Requests\Teams\TeamIndex;
use App\Http\Requests\Teams\TeamStore;
use App\Http\Requests\Teams\TeamUpdate;
use App\Models\Team;
use App\Services\QueryBuilders\SettingsTeamQueryBuilder;
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
     * @param TeamIndex $request
     *
     * @return JsonResponse
     */
    public function index(TeamIndex $request): JsonResponse
    {
        $queryParams = $request->validatedOnly();
        $queryBuilder = new SettingsTeamQueryBuilder();
        $teams = $queryBuilder->setQuery($this->team->query())->setQueryParams($queryParams);
        $teams = $teams->paginate($request->get('per_page'));        
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
            'company_id' => auth()->user()->company_id,
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
        $team = $this->team->findOrFail($request->input('team_id'));
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