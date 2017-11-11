<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Category extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = "categories";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'prefix'
    ];

    /**
     * Relation with equipments.
     */
    public function models()
    {
        return $this->hasMany(Models::class, 'category_id');
    }

    /**
     * Get categories list
     *
     * @return mixed
     */
    public static function getList()
    {
        return self::get();
    }

    public static function getSummorizedList()
    {
        return DB::table('categories')
            ->join('models', 'models.category_id', '=', 'categories.id')
            ->join('equipments', 'equipments.model_id', '=', 'models.id')
            ->select(DB::raw('count(*) as user_count, status'));
    }

    /**
     * Get category by id
     *
     * @param integer $id
     *
     * @return mixed
     */
    public static function getById($id)
    {
        return self::find($id);
    }

    /**
     * Get category by name
     *
     * @param string $name
     *
     * @return mixed
     */
    public static function getByName($name)
    {
        return self::where('name', $name)->first();
    }

    /**
     * Create new category
     *
     * @param array $data
     *
     * @return mixed
     */
    public static function createCategory($data)
    {
        try {
            $category = self::create([
                'name' => $data['name'],
                'prefix' => $data['prefix']
            ]);
        }
        catch (\Exception $exception) {
            return false;
        }

        return $category;
    }

    /**
     * Update category
     *
     * @param array $data
     * @param object $category
     *
     * @return mixed
     */
    public static function updateCategory($data, $category)
    {
        try {
            $category->name = $data['name'];
            $category->prefix = $data['prefix'];
            $category->save();
        }
        catch (\Exception $exception) {
            return false;
        }

        return $category;
    }

    /**
     * Delete category
     *
     * @param object $category
     *
     * @return boolean
     */
    public static function deleteCategory($category)
    {
        try{
            $category->delete();
        }
        catch (\Exception $exception) {
            return false;
        }

        return true;
    }
}
