<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyEmployee extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'company_employees';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'company_id', 'status_id'
    ];

    /**
     * Relation with user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation with company.
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Relation with status.
     */
    public function status()
    {
        return $this->belongsTo(EmployeeStatus::class);
    }
}
