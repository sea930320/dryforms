<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Models extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = "models";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'category_id'
    ];

    /**
     * Relation with categories.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relation with equipments.
     */
    public function equipments()
    {
        return $this->hasMany(Equipment::class, 'model_id');
    }

    /**
     * Get model list
     *
     * @return mixed
     */
    public static function getList()
    {
        return self::get();
    }

    /**
     * Get model by id
     *
     * @param int $id
     *
     * return mixed
     */
    public static function getById($id)
    {
        return self::find($id);
    }

    /**
     * Create model
     *
     * @param array $data
     *
     * @return bool
     */
    public static function createModel($data)
    {
        try{
            $model = Models::create([
                'name' => $data['name'],
                'category_id' => $data['category_id']
            ]);
        }
        catch (\Exception $exception) {
            return false;
        }

        return $model;
    }

    /**
     * Update model
     *
     * @param object $model
     * @param array $data
     *
     * @return mixed
     */
    public static function updateModel($model, $data)
    {
        try{
            $model->name = $data['name'];
            $model->category_id = $data['category_id'];
            $model->save();
        }
        catch (\Exception $exception) {
            return false;
        }

        return $model;
    }

    /**
     * Delete model
     *
     * @param object $category
     *
     * @return boolean
     */
    public static function deleteModel($category)
    {
        try {
            $category->delete();
        }
        catch (\Exception $exception) {
            return false;
        }

        return true;
    }

    /**
     * Update equipment count for serial generating
     *
     * @param int $quantity
     * @param object $model
     *
     * @return bool
     */
    public static function updateEquipmentsCount($quantity, $model)
    {
        try {
            $model->equipments_count = $model->equipments_count + $quantity;
            $model->save();
        }
        catch (\Exception $exception) {
            return false;
        }

        return true;
    }

}
