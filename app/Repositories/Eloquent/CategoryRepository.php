<?php
    namespace App\Repositories\Eloquent;

    use App\Repositories\Contracts\CategoryInterface;
    use App\Models\Category;

    class CategoryRepository implements CategoryInterface
    {
        /**
         * @var Category
         */
        public $category;

        /**
         * CategoryRepository constructor.
         *
         * @param Category $category
         */
        function __construct(Category $category)
        {
            $this->category = $category;
        }

        /**
         * Get all categories
         *
         * @param array $columns
         *
         * @return \Illuminate\Database\Eloquent\Collection | boolean
         */
        public function all(array $columns = ['*'])
        {
            try {
                $categories = $this->category->get($columns);
            }
            catch (\Throwable $exception) {
                return false;
            }

            return $categories;
        }

        /**
         * Find category by id
         *
         * @param int $id
         * @param array $columns
         *
         * @return \Illuminate\Database\Eloquent\Collection | boolean
         */
        public function find(int $id, array $columns = ['*'])
        {
            try {
                $category = $this->category->find($id, $columns);
            }
            catch (\Throwable $exception) {
                return false;
            }

            return $category;
        }

        /**
         * Find category by field
         *
         * @param string $field
         * @param string $value
         * @param array $columns
         *
         * @return \Illuminate\Database\Eloquent\Collection | boolean
         */
        public function findBy(string $field, string $value, array $columns = ['*'])
        {
            try {
                $category = $this->category->where($field, '=', $value)->first($columns);
            }
            catch (\Throwable $exception) {
                return false;
            }

            return $category;
        }

        /**
         * Create category
         *
         * @param array $data
         *
         * @return \Illuminate\Database\Eloquent\Collection | boolean
         */
        public function create(array $data)
        {
            try {
                $category = $this->category->create($data);
            }
            catch (\Throwable $exception) {
                return false;
            }

            return $category;
        }

        /**
         * Update category
         *
         * @param array $data
         * @param int $id
         *
         * @return \Illuminate\Database\Eloquent\Collection | boolean
         */
        public function update(array $data, int $id)
        {
            try {
                $category = $this->category->where('id', '=', $id)->update($data);
            }
            catch (\Throwable $exception) {
                return false;
            }

            return $category;
        }

        /**
         * Delete category
         *
         * @param int $id
         *
         * @return boolean
         */
        public function delete(int $id)
        {
            try {
                $this->category->destroy($id);
            }
            catch (\Throwable $exception) {
                return false;
            }

            return true;
        }
    }