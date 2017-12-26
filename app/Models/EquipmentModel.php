<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EquipmentModel extends Model
{
    /**
     * @var string
     */
    protected $table = 'equipment_models';

    /**
     * @var array
     */
    protected $fillable = [
        'name', 'category_id', 'total', 'description', 'company_id'
    ];

    /**
     * @var array
     */
    protected $visible = [
        'id', 'name', 'category_id', 'total', 'description', 'company_id', 'company', 'category', 'equipment'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function equipment()
    {
        return $this->hasMany(Equipment::class, 'model_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
