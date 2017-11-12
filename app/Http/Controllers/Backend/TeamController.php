<?php

namespace App\Http\Controllers\Backend;

use App\Models\Team;
use App\Http\Requests\Teams\TeamCreate;
use App\Http\Requests\Teams\TeamUpdate;
use App\Repositories\Contracts\TeamInterface;
use Prologue\Alerts\Facades\Alert;
use App\Http\Controllers\Controller;

class TeamController extends Controller
{
    /**
     * @var Team
     */
    private $team;

    /**
     * @param TeamInterface $team
     */
    public function __construct(TeamInterface $team)
    {
        $this->team = $team;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teams = $this->team->all(['id', 'name']);

        return view('dashboard.teams.index', compact('teams'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.teams.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  TeamCreate  $request
     *
     * @return mixed
     */
    public function store(TeamCreate $request)
    {
        $data = $request->only(['name']);

        if( ! $team = $this->team->create($data)) {

            Alert::error('Could not create team')->flash();

            return back()->withInput();
        }

        Alert::success('Team created successfully')->flash();

        return redirect()->route('teams.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        if( ! $team = $this->team->find($id)) {

            Alert::error('Could not get team with id ' . $id . ' from database')->flash();

            return back();
        }

        return view('dashboard.teams.edit', compact('team'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  TeamUpdate  $request
     * @param  int  $id
     * @return mixed
     */
    public function update(TeamUpdate $request, int $id)
    {
        if( ! $team = $this->team->find($id)) {

            Alert::error('Could not get team with id ' . $id . ' from database')->flash();

            return back()->withInput();
        }

        $data = $request->only(['name']);

        if( ! $update = $this->team->update($data, $team->id)) {

            Alert::error('Could not update team')->flash();

            return back()->withInput();
        }

        Alert::success('Team updated successfully')->flash();

        return redirect()->route('teams.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return mixed
     */
    public function destroy(int $id)
    {
        if( ! $team = $this->team->find($id)) {

            Alert::error('Could not find team in database')->flash();

            return back();
        }

        if( ! $delete = $this->team->delete($team->id)) {

            Alert::error('Could not delete team from database')->flash();

            return back();
        }

        Alert::success('Team deleted successfully')->flash();

        return redirect()->route('teams.index');
    }
}
