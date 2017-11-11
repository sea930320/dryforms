<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = "statuses";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * Relation with equipments.
     */
    public function equipments()
    {
        return $this->hasMany(Equipment::class, 'status_id');
    }

    /**
     * Get statuses list
     *
     * @return mixed
     */
    public static function getList()
    {
        return self::get();
    }

    /**
     * Get status by id
     *
     * @param int $id
     *
     * @return mixed
     */
    public static function getById($id)
    {
        return self::find($id);
    }

    /**
     * Create status
     *
     * @param array $data
     *
     * @return mixed
     */
    public static function createStatus($data)
    {
        try {
            $status = self::create([
                'name' => $data['name']
            ]);
        }
        catch (\Exception $exception) {
            return false;
        }

        return $status;
    }

    /**
     * Update status
     *
     * @param array $data
     * @param object $status
     *
     * @return mixed
     */
    public static function updateStatus($data, $status)
    {
        try {
            $status->name = $data['name'];
            $status->save();
        }
        catch (\Exception $exception) {
            return false;
        }

        return $status;
    }

    /**
     * Delete status
     *
     * @param object $status
     *
     * @return bool
     */
    public static function deleteStatus($status)
    {
        try {
            $status->delete();
        }
        catch (\Exception $exception) {
            return false;
        }

        return true;
    }
}
