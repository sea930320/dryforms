<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    const SUPER_ADMIN = 1;
    const ADMIN = 2;
    const USER = 3;

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
    protected $fillable = ['name'];

    /**
     * Relation with user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
