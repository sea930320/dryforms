<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectCompany extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'project_companies';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'project_id', 'user_id', 'logo', 'name', 'email', 'street', 'city', 'state', 'zip', 'phone', 'cloud_link'
    ];

    /**
     * Relation with user.
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

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
