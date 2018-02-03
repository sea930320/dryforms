<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnitOfMeasure extends Model
{
    /**
     * @var string
     */
    public $table = 'units_of_measure';

    /**
     * @var array
     */
    public $fillable = [
        'title'
    ];

    public $visible = [
        'id',
        'title'
    ];
}