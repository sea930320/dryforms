<?php
    namespace App\Repositories\Eloquent;

    use App\Repositories\Contracts\ModelInterface;
    use App\Models\EquipmentModel;


    class ModelRepository implements ModelInterface
    {
        /**
         * @var EquipmentModel
         */
        public $model;

        /**
         * ModelRepository constructor.
         *
         * @param EquipmentModel $model
         */
        function __construct(EquipmentModel $model)
        {
            $this->model = $model;
        }

        /**
         * Get all models
         *
         * @param array $columns
         *
         * @return \Illuminate\Database\Eloquent\Collection | boolean
         */
        public function all(array $columns = ['*'])
        {
            try {
                $models = $this->model->get($columns);
            }
            catch (\Throwable $exception) {
                return false;
            }

            return $models;
        }

        /**
         * Find model by id
         *
         * @param int $id
         * @param array $columns
         *
         * @return \Illuminate\Database\Eloquent\Collection | boolean
         */
        public function find(int $id, array $columns = ['*'])
        {
            try {
                $model = $this->model->find($id, $columns);
            }
            catch (\Throwable $exception) {
                return false;
            }

            return $model;
        }

        /**
         * Find model by field
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
                $model = $this->model->where($field, '=', $value)->first($columns);
            }
            catch (\Throwable $exception) {
                return false;
            }

            return $model;
        }

        /**
         * Create model
         *
         * @param array $data
         *
         * @return \Illuminate\Database\Eloquent\Collection | boolean
         */
        public function create(array $data)
        {
            try {
                $model = $this->model->create($data);
            }
            catch (\Throwable $exception) {
                return false;
            }

            return $model;
        }

        /**
         * Update model
         *
         * @param array $data
         * @param int $id
         *
         * @return \Illuminate\Database\Eloquent\Collection | boolean
         */
        public function update(array $data, int $id)
        {
            try {
                $model = $this->model->where('id', '=', $id)->update($data);
            }
            catch (\Throwable $exception) {
                return false;
            }

            return $model;
        }

        /**
         * Delete model
         *
         * @param int $id
         *
         * @return boolean
         */
        public function delete(int $id)
        {
            try {
                return $this->model->destroy($id);
            }
            catch (\Throwable $exception) {
                return false;
            }
        }
    }