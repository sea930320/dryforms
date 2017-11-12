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
}
