<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Equipment;
use App\Models\Models;
use App\Models\Status;
use App\Models\Team;
use Illuminate\Http\Request;
use App\Http\Requests\Equipments\EquipmentCreate;
use Illuminate\Http\Response;
use Prologue\Alerts\Facades\Alert;

class EquipmentController extends Controller
{
    /**
     * Display summarized equipments info.
     *
     * @return \Illuminate\Http\Response
     */
    public function summarized()
    {
        // get categories
        $categories = Category::getList();

        // get models
        $models = Models::getList();

        // get teams
        $teams = Team::getList();

        // get statuses
        $statuses = Status::getList();

        return view('dashboard.equipments.summarized', compact('categories','models', 'teams', 'statuses'));
    }

    /**
     * Display a listing of the resource.
     *
     * @param int $id Model id
     *
     * @return mixed
     */
    public function index($id)
    {
        // check model
        if( ! $model = Models::getById($id)) {

            Alert::error('Could not find model')->flash();

            return back()->withInput();
        }

        // get teams
        $teams = Team::getList();

        // get statuses
        $statuses = Status::getList();

        return view('dashboard.equipments.index', compact('model', 'teams', 'statuses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.equipments.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  EquipmentCreate  $request
     * @return mixed
     */
    public function store(EquipmentCreate $request)
    {
        // get request data
        $data = $request->all();

        // check category
        if( ! $category = Category::getById($data['category'])) {

            Alert::error('Could not find category')->flash();

            return back()->withInput();
        }

        // check model
        if( ! $model = Models::getById($data['model'])) {

            Alert::error('Could not find model')->flash();

            return back()->withInput();
        }

        // check team
        if( ! $team = Models::getById($data['team'])) {

            Alert::error('Could not find team')->flash();

            return back()->withInput();
        }

        // check team
        if( ! $status = Status::getById($data['status'])) {

            Alert::error('Could not find status')->flash();

            return back()->withInput();
        }

        // create equipments
        for($i = $model->equipments_count; $i < $data['quantity'] + $model->equipments_count; $i++) {

            // generate serial
            $serial = '#' . $category->prefix . str_pad($i, 4, '0', STR_PAD_LEFT);


            if ( ! Equipment::createEquipment(['model_id' => $model->id, 'team_id' => $team->id, 'serial' => $serial, 'status_id' => $status->id])) {

                Alert::error('Could not create equipment with serial ' . $serial)->flash();

                return back()->withInput();
            }
        }

        // update model
        Models::updateEquipmentsCount($data['quantity'], $model);

        return redirect()->route('equipments.summarized');
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Change team for equipment
     *
     * @param Request $request
     *
     * @return Response
     */
    public function changeTeam(Request $request)
    {
        // check request
        if( ! $request->ajax()) {

            return response(['status' => 'error', 'message' => 'You don\'t have permission to view this page']);
        }

        // get request data
        $data = $request->all();

        // check request data
        if( ! isset($data['equipment_id']) || ! isset($data['team_id'])) {

            return response(['status' => 'error', 'message' => 'Requested data is not full']);
        }

        // get equipment
        if( ! $equipment = Equipment::getById($data['equipment_id'])) {

            return response(['status' => 'error', 'message' => 'Could not find equipment in database']);
        }

        // get team
        if( ! Team::getById($data['team_id'])) {

            return response(['status' => 'error', 'message' => 'Could not find team in database']);
        }

        // update equipment`s team
        if( ! $equipment = Equipment::updateTeam($equipment, $data['team_id'])) {

            return response(['status' => 'error', 'message' => 'Could not update team for equipment in database']);
        }

        return response(['status' => 'success', 'message' => 'The equipment with serial ' . $equipment->serial . ' updated successfully']);
    }

    /**
     * Change status for equipment
     *
     * @param Request $request
     *
     * @return Response
     */
    public function changeStatus(Request $request)
    {
        // check request
        if( ! $request->ajax()) {

            return response(['status' => 'error', 'message' => 'You don\'t have permission to view this page']);
        }

        // get request data
        $data = $request->all();

        // check request data
        if( ! isset($data['equipment_id']) || ! isset($data['status_id'])) {

            return response(['status' => 'error', 'message' => 'Requested data is not full']);
        }

        // get equipment
        if( ! $equipment = Equipment::getById($data['equipment_id'])) {

            return response(['status' => 'error', 'message' => 'Could not find equipment in database']);
        }

        // get team
        if( ! $status = Status::getById($data['status_id'])) {

            return response(['status' => 'error', 'message' => 'Could not find status in database']);
        }

        // update equipment`s team
        if( ! $equipment = Equipment::updateStatus($equipment, $data['status_id'])) {

            return response(['status' => 'error', 'message' => 'Could not update status for equipment in database']);
        }


        $hideLocation = $status->name == 'Set' || $status->name == 'Loan' ? false : true;

        return response(['status' => 'success', 'message' => 'The equipment with serial ' . $equipment->serial . ' updated successfully',
                         'data' => ['disabled' => $hideLocation]]);
    }

    /**
     * Change location for equipment
     *
     * @param Request $request
     *
     * @return Response
     */
    public function changeLocation(Request $request)
    {
        // check request
        if( ! $request->ajax()) {

            return response(['status' => 'error', 'message' => 'You don\'t have permission to view this page']);
        }

        // get request data
        $data = $request->all();

        // check request data
        if( ! isset($data['equipment_id'])) {

            return response(['status' => 'error', 'message' => 'Requested data is not full']);
        }

        // get equipment
        if( ! $equipment = Equipment::getById($data['equipment_id'])) {

            return response(['status' => 'error', 'message' => 'Could not find equipment in database']);
        }

        // update equipment`s team
        if( ! $equipment = Equipment::updateLocation($equipment, $data['location'])) {

            return response(['status' => 'error', 'message' => 'Could not update location for equipment in database']);
        }

        return response(['status' => 'success', 'message' => 'The equipment with serial ' . $equipment->serial . ' updated successfully']);
    }

    /**
     * Delete selected equipments
     *
     * @param Request $request
     *
     * @return Response
     */
    public function bulkDelete(Request $request)
    {
        // check request
        if( ! $request->ajax()) {

            return response(['status' => 'error', 'message' => 'You don\'t have permission to view this page']);
        }

        // get request data
        $data = $request->all();

        // check request data
        if(empty($data['ids'])) {

            return response(['status' => 'error', 'message' => 'Requested data is not full']);
        }

        // delete equipments
        if( ! Equipment::bulkDelete($data['ids'])) {

            return response(['status' => 'error', 'message' => 'Could not delete equipments']);
        }

        return response(['status' => 'success', 'message' => 'Equipments deleted successfully']);
    }

    /**
     * Get models by category
     *
     * @param Request $request
     *
     * @return Response
     */
    public function getModels(Request $request)
    {
        // check request
        if( ! $request->ajax()) {

            return response(['status' => 'error', 'message' => 'You don\'t have permission to view this page']);
        }

        // get request data
        $data = $request->all();

        // check request data
        if(empty($data['id'])) {

            return response(['status' => 'error', 'message' => 'Requested data is not full']);
        }

        // get category
        if( ! $category = Category::getById($data['id'])) {

            return response(['status' => 'error', 'message' => 'Could not find category in database']);
        }

        return response(['status' => 'success', 'data' => [
            'models' => view('dashboard.equipments.models', ['models' => $category->models->pluck('name', 'id')->toArray()])->render()
        ]]);
    }
}
