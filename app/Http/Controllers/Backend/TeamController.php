<?php

namespace App\Http\Controllers\Backend;

use App\Models\Team;
use App\Http\Requests\Teams\TeamCreate;
use App\Http\Requests\Teams\TeamUpdate;
use Prologue\Alerts\Facades\Alert;
use App\Http\Controllers\Controller;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get teams
        $teams = Team::getList();

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
        // get request data
        $data = $request->all();

        // create team
        if( ! $team = Team::createTeam($data)) {

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
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // get team
        if( ! $team = Team::getById($id)) {

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
    public function update(TeamUpdate $request, $id)
    {
        // get team
        if( ! $team = Team::getById($id)) {

            Alert::error('Could not get team with id ' . $id . ' from database')->flash();

            return back()->withInput();
        }

        // get request data
        $data = $request->all();

        // update team
        if( ! $update = Team::updateTeam($data, $team)) {

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
    public function destroy($id)
    {
        // get team
        if( ! $team = Team::getById($id)) {

            Alert::error('Could not find team in database')->flash();

            return back();
        }

        // delete team
        if( ! $delete = Team::deleteTeam($team)) {

            Alert::error('Could not delete team from database')->flash();

            return back();
        }

        Alert::success('Team deleted successfully')->flash();

        return redirect()->route('teams.index');
    }
}
