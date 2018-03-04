<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DefaultTeam;

class StandardTeamsController extends Controller
{
	/**
     * @var DefaultTeam
     */
    private $defaultTeam;

    /**
     * StandardTeamsController constructor.
     *
     * @param DefaultTeam $defaultTeam
     */
    public function __construct(DefaultTeam $defaultTeam)
    {
    	$this->defaultTeam = $defaultTeam;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function teamsPage()
    {
        return view('dashboard.standard-forms.teams');
    }

    /**
     *
     * @return JsonResponse
     */
    public function index() {
    	$teams = $this->defaultTeam->get();
    	return response()->json([
            'teams' => $teams
        ]);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $team = $this->defaultTeam->create([
            'name' => $request->get('name')
        ]);

        return response()->json(['message' => 'Team successfully created', 'team' => $team]);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function update(Request $request)
    {
        $team = $this->defaultTeam
            ->findOrFail($request->input('team_id'));
        $team->update([
        	'name' => $request->get('name')
        ]);

        return response()->json(['message' => 'Team successfully updated', 'team' => $team]);
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function destroy(int $id)
    {
        $this->defaultTeam->findOrFail($id)->delete();

        return response()->json(['message' => 'Team successfully deleted']);
    }
}
