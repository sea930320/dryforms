<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Models extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = "equipment_models";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'category_id'
    ];

    /**
     * Relation with categories.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relation with equipments.
     */
    public function equipments()
    {
        return $this->hasMany(Equipment::class, 'model_id');
    }
}
