<?php

namespace App\Models;

use App\Traits\BelongsToCompany;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use BelongsToCompany;

    /**
     * @var string
     */
    protected $table = 'equipment_categories';

    /**
     * @var array
     */
    protected $fillable = [
        'name', 'prefix', 'description', 'company_id'
    ];

    /**
     * @var array
     */
    protected $visible = [
        'id',
        'name',
        'prefix',
        'description',
        'company_id',
        'company',
        'equipments',
        'models'
    ];

    /**
     * Relation with models.
     */
    public function models()
    {
        return $this->hasMany(EquipmentModel::class, 'category_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function equipments()
    {
        return $this->hasManyThrough(
            Equipment::class,
            EquipmentModel::class,
            'category_id',
            'model_id'
            );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
