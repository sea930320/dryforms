<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectPsychometricDays extends Model
{
    /**
     * @var string
     */
    public $table = 'project_psychometric_days';

    /**
     * @var array
     */
    public $fillable = ['area_id', 'containment_id', 'current_time', 'outside', 'unaffected', 'affected', 'dehumidifier', 'hvac'];

    /**
     * @var array
     */
    public $visible = ['id', 'area_id', 'containment_id', 'current_time', 'outside', 'unaffected', 'affected', 'dehumidifier', 'hvac'];
}
