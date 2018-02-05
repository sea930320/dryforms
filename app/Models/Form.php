<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    /**
     * @var string
     */
    public $table = 'forms';

    /**
     * @var array
     */
    public $fillable = ['name'];

    /**
     * @var array
     */
    public $visible = ['id', 'name', 'default_data'];
}