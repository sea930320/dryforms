<?php

namespace App\Http\Controllers\Backend;

use App\Models\Status;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Statuses\StatusCreate;
use App\Http\Requests\Statuses\StatusUpdate;
use Prologue\Alerts\Facades\Alert;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get statuses list
        $statuses = Status::getList();

        return view('dashboard.statuses.index', compact('statuses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.statuses.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StatusCreate $request
     *
     * @return mixed
     */
    public function store(StatusCreate $request)
    {
        // get request data
        $data = $request->all();

        // create status
        if( ! $status = Status::createStatus($data)) {

            Alert::error('Could not create status')->flash();

            return back()->withInput();
        }

        Alert::success('Status created successfully')->flash();

        return redirect()->route('statuses.index');
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
     * @return mixed
     */
    public function edit($id)
    {
        // get status
        if( ! $status = Status::getById($id)) {

            Alert::error('Could not get status with id ' . $id . ' from database')->flash();

            return back()->withInput();
        }

        return view('dashboard.statuses.edit', compact('status'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return mixed
     */
    public function update(Request $request, $id)
    {
        // get status
        if( ! $status = Status::getById($id)) {

            Alert::error('Could not get status with id ' . $id . ' from database')->flash();

            return back()->withInput();
        }

        // get request data
        $data = $request->all();

        // update status
        if( ! $update = Status::updateStatus($data, $status)) {

            Alert::error('Could not update status')->flash();

            return back()->withInput();
        }

        Alert::success('Status updated successfully')->flash();

        return redirect()->route('statuses.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // get status
        if( ! $status = Status::getById($id)) {

            Alert::error('Could not get status with id ' . $id . ' from database')->flash();

            return back();
        }

        // delete status
        if( ! $delete = Status::deleteStatus($status)) {

            Alert::error('Could not delete status')->flash();

            return back();
        }

        Alert::success('Status deleted successfully')->flash();

        return redirect()->route('statuses.index');
    }
}
