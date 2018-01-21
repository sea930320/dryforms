<?php

namespace App\Models;

use App\Traits\BelongsToCompany;
use Illuminate\Database\Eloquent\Model;
use App\Models\Status;

class EquipmentModel extends Model
{
    use BelongsToCompany;

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

    /**
     * EquipmentModel constructor.
     *
     * @param Status $status
     */
    public function __construct($attributes = array(), $permitted = false)
    {
        parent::__construct($attributes);
        $statuses = Status::get();
        foreach ($statuses as $key => $status) {
            $alias_status = 'status_'. $status->id. '_count';
            array_push($this->visible, $alias_status);
        }
    }
}
