<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    const AVAILABLE = 1;
    const OOC = 2;
    const SET = 3;
    const LOAN = 4;

    /**
     * @var string
     */
    protected $table = 'equipment_statuses';

    /**
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function equipments()
    {
        return $this->hasMany(Equipment::class, 'status_id');
    }
}
