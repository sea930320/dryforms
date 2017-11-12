<?php

namespace App\Http\Controllers\Backend;

use App\Models\Status;
use App\Repositories\Contracts\StatusInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Statuses\StatusCreate;
use App\Http\Requests\Statuses\StatusUpdate;
use Prologue\Alerts\Facades\Alert;

class StatusController extends Controller
{
    /**
     * @var Status
     */
    private $status;

    /**
     * @param StatusInterface $status
     */
    public function __construct(StatusInterface $status)
    {
        $this->status = $status;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $statuses = $this->status->all(['id', 'name']);

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
        $data = $request->only(['name']);

        // create status
        if( ! $status = $this->status->create($data)) {

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
    public function show(int $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return mixed
     */
    public function edit(int $id)
    {
        if( ! $status = $this->status->find($id)) {

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
    public function update(Request $request, int $id)
    {
        if( ! $status = $this->status->find($id)) {

            Alert::error('Could not get status with id ' . $id . ' from database')->flash();

            return back()->withInput();
        }

        $data = $request->only(['name']);

        if( ! $update = $this->status->update($data, $status->id)) {

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
    public function destroy(int $id)
    {
        if( ! $status = $this->status->find($id)) {

            Alert::error('Could not get status with id ' . $id . ' from database')->flash();

            return back();
        }

        if( ! $delete = $this->status->delete($status->id)) {

            Alert::error('Could not delete status')->flash();

            return back();
        }

        Alert::success('Status deleted successfully')->flash();

        return redirect()->route('statuses.index');
    }
}
