<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'companies';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'logo', 'name', 'email', 'street', 'city', 'state', 'zip', 'phone', 'cloud_link'
    ];

    /**
     * Relation with user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation with employees.
     */
    public function employees()
    {
        return $this->hasMany(CompanyEmployee::class, 'company_id');
    }
}
