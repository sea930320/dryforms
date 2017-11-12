<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Category extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = "equipment_categories";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'prefix'
    ];

    /**
     * Relation with equipments.
     */
    public function models()
    {
        return $this->hasMany(Models::class, 'category_id');
    }
}
