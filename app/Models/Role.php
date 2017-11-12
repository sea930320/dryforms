<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = "roles";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug', 'level'
    ];

    /**
     * Find role by slug
     *
     * @param $slug
     *
     * @return mixed
     */
    public static function findBySlug($slug)
    {
        return self::where('slug', $slug)->first();
    }
}
