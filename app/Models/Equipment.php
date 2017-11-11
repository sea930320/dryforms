<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = "equipments";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'model_id', 'category_id', 'status_id', 'team_id', 'serial', 'location'
    ];

    /**
     * Relation with statuses.
     */
    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    /**
     * Relation with teams.
     */
    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * Relation with model.
     */
    public function model()
    {
        return $this->belongsTo(Models::class);
    }

    /**
     * Get equipment by id
     *
     * @param int $id
     *
     * @return mixed
     */
    public static function getById($id)
    {
        return self::find($id);
    }

    /**
     * Create new equipment
     *
     * @param array $data
     *
     * @return mixed
     */
    public static function createEquipment($data)
    {
        try {
            $equipment = Equipment::create([
                'model_id' => $data['model_id'],
                'team_id' => $data['team_id'],
                'serial' => $data['serial'],
                'status_id' => $data['status_id'],
            ]);
        }
        catch (\Exception $exception) {
            return false;
        }

        return $equipment;
    }

    /**
     * Update team for equipment
     *
     * @param object $equipment
     * @param int $teamId
     *
     * @return mixed
     */
    public static function updateTeam($equipment, $teamId)
    {
        try {
            $equipment->team_id = $teamId;
            $equipment->save();
        }
        catch (\Exception $exception) {
            return false;
        }

        return $equipment;
    }

    /**
     * Update status for equipment
     *
     * @param object $equipment
     * @param int $statusId
     *
     * @return mixed
     */
    public static function updateStatus($equipment, $statusId)
    {
        try {
            $equipment->status_id = $statusId;
            $equipment->save();
        }
        catch (\Exception $exception) {
            return false;
        }

        return $equipment;
    }

    /**
     * Update status for equipment
     *
     * @param object $equipment
     * @param string $location
     *
     * @return mixed
     */
    public static function updateLocation($equipment, $location)
    {
        try {
            $equipment->location = $location;
            $equipment->save();
        }
        catch (\Exception $exception) {
            return false;
        }

        return $equipment;
    }

    /**
     * Delete multiple equipments
     *
     * @param array $ids
     *
     * @return boolean
     */
    public static function bulkDelete($ids)
    {
        try{
            self::whereIn('id', $ids)->delete();
        }
        catch (\Exception $exception) {
            dd($exception);
        }

        return true;
    }
}
