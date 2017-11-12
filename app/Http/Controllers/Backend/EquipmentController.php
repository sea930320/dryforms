<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Equipment;
use App\Models\Models;
use App\Models\Status;
use App\Models\Team;
use App\Repositories\Contracts\CategoryInterface;
use App\Repositories\Contracts\EquipmentInterface;
use App\Repositories\Contracts\ModelInterface;
use App\Repositories\Contracts\StatusInterface;
use App\Repositories\Contracts\TeamInterface;
use Illuminate\Http\Request;
use App\Http\Requests\Equipments\EquipmentCreate;
use Illuminate\Http\Response;
use Prologue\Alerts\Facades\Alert;

class EquipmentController extends Controller
{
    /**
     * @var Equipment
     */
    private $equipment;
    /**
     * @var Category
     */
    private $category;
    /**
     * @var Models
     */
    private $model;
    /**
     * @var Team
     */
    private $team;
    /**
     * @var Status
     */
    private $status;

    /**
     * EquipmentController constructor.
     *
     * @param EquipmentInterface $equipment
     * @param CategoryInterface  $category
     * @param StatusInterface    $status
     * @param TeamInterface      $team
     * @param ModelInterface     $model
     */
    public function __construct(EquipmentInterface $equipment, CategoryInterface $category, StatusInterface $status,
                                TeamInterface $team, ModelInterface $model) {

        $this->equipment = $equipment;
        $this->category = $category;
        $this->model = $model;
        $this->status = $status;
        $this->team = $team;
    }


    /**
     * Display summarized equipments info.
     *
     * @return \Illuminate\Http\Response
     */
    public function summarized()
    {
        $categories = $this->category->all();
        $models = $this->model->all();
        $teams = $this->team->all();
        $statuses = $this->status->all();

        return view('dashboard.equipments.summarized', compact('categories','models', 'teams', 'statuses'));
    }

    /**
     * Display a listing of the resource.
     *
     * @param int $id Model id
     *
     * @return mixed
     */
    public function index(int $id)
    {
        if( ! $model = $this->model->find($id)) {

            Alert::error('Could not find model')->flash();

            return back()->withInput();
        }

        $teams = $this->team->all();
        $statuses = $this->status->all();

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
        $data = $request->all();

        // check category
        if( ! $category = $this->category->find($data['category'])) {

            Alert::error('Could not find category')->flash();

            return back()->withInput();
        }

        if( ! $model = $this->model->find($data['model'])) {

            Alert::error('Could not find model')->flash();

            return back()->withInput();
        }

        if( ! $team = $this->team->find($data['team'])) {

            Alert::error('Could not find team')->flash();

            return back()->withInput();
        }

        if( ! $status = $this->status->find($data['status'])) {

            Alert::error('Could not find status')->flash();

            return back()->withInput();
        }

        // create equipments
        for($i = $model->equipments_count; $i < $data['quantity'] + $model->equipments_count; $i++) {

            // generate serial
            $serial = '#' . $category->prefix . str_pad($i, 4, '0', STR_PAD_LEFT);


            if ( ! $this->equipment->create(['model_id' => $model->id, 'team_id' => $team->id, 'serial' => $serial, 'status_id' => $status->id])) {

                Alert::error('Could not create equipment with serial ' . $serial)->flash();

                return back()->withInput();
            }
        }

        $this->model->update(['quantity' => $data['quantity']], $model->id);

        return redirect()->route('equipments.summarized');
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
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
        if( ! $request->ajax()) {

            return response(['status' => 'error', 'message' => 'You don\'t have permission to view this page']);
        }

        $data = $request->only(['equipment_id', 'team_id']);

        if( ! isset($data['equipment_id']) || ! isset($data['team_id'])) {

            return response(['status' => 'error', 'message' => 'Requested data is not full']);
        }

        if( ! $equipment = $this->equipment->find($data['equipment_id'])) {

            return response(['status' => 'error', 'message' => 'Could not find equipment in database']);
        }

        if( ! $this->team->find($data['team_id'])) {

            return response(['status' => 'error', 'message' => 'Could not find team in database']);
        }

        if( ! $this->equipment->update(['team_id' => $data['team_id']], $equipment->id)) {

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
        if( ! $request->ajax()) {

            return response(['status' => 'error', 'message' => 'You don\'t have permission to view this page']);
        }

        $data = $request->only(['equipment_id', 'status_id']);

        if( ! isset($data['equipment_id']) || ! isset($data['status_id'])) {

            return response(['status' => 'error', 'message' => 'Requested data is not full']);
        }

        if( ! $equipment = $this->equipment->find($data['equipment_id'])) {

            return response(['status' => 'error', 'message' => 'Could not find equipment in database']);
        }

        if( ! $status = $this->status->find($data['status_id'])) {

            return response(['status' => 'error', 'message' => 'Could not find status in database']);
        }

        if( ! $this->equipment->update(['status_id' => $data['status_id']], $equipment->id)) {

            return response(['status' => 'error', 'message' => 'Could not update status for equipment in database']);
        }

        // hide location input field depend of status
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
        if( ! $request->ajax()) {

            return response(['status' => 'error', 'message' => 'You don\'t have permission to view this page']);
        }

        $data = $request->only(['equipment_id', 'location']);

        if( ! isset($data['equipment_id'])) {

            return response(['status' => 'error', 'message' => 'Requested data is not full']);
        }

        if( ! $equipment = $this->equipment->find($data['equipment_id'])) {

            return response(['status' => 'error', 'message' => 'Could not find equipment in database']);
        }

        if( ! $this->equipment->update(['location' => $data['location']], $equipment->id)) {

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
        if( ! $request->ajax()) {

            return response(['status' => 'error', 'message' => 'You don\'t have permission to view this page']);
        }

        $data = $request->only(['ids']);

        if(empty($data['ids'])) {

            return response(['status' => 'error', 'message' => 'Requested data is not full']);
        }

        if( ! $this->equipment->bulkDelete($data['ids'])) {

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
        if( ! $request->ajax()) {

            return response(['status' => 'error', 'message' => 'You don\'t have permission to view this page']);
        }

        $data = $request->only(['id']);

        if(empty($data['id'])) {

            return response(['status' => 'error', 'message' => 'Requested data is not full']);
        }

        if( ! $category = $this->category->find($data['id'])) {

            return response(['status' => 'error', 'message' => 'Could not find category in database']);
        }

        return response(['status' => 'success', 'data' => [
            'models' => view('dashboard.equipments.models', ['models' => $category->models->pluck('name', 'id')->toArray()])->render()
        ]]);
    }
}
