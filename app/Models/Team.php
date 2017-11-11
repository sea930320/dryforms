<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = "teams";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * Relation with equipments.
     */
    public function equipments()
    {
        return $this->hasMany(Equipment::class, 'team_id');
    }

    /**
     * Get teams list
     *
     * @return mixed
     */
    public static function getList()
    {
        return self::get();
    }

    /**
     * Get team by id
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
     * Create team
     *
     * @param array $data
     *
     * @return mixed
     */
    public static function createTeam($data)
    {
        try {
            $team = self::create([
                'name' => $data['name']
            ]);
        }
        catch (\Exception $exception) {
            return false;
        }

        return $team;
    }

    /**
     * Update team
     *
     * @param array $data
     * @param object $team
     *
     * @return mixed
     */
    public static function updateTeam($data, $team)
    {
        try {
            $team->name = $data['name'];
            $team->save();
        }
        catch(\Exception $exception) {
            return false;
        }

        return $team;
    }

    /**
     * Delete team
     *
     * @param object $team
     *
     * @return boolean
     */
    public static function deleteTeam($team)
    {
        try {
            $team->delete();
        }
        catch (\Exception $exception) {
            return false;
        }

        return true;
    }
}
