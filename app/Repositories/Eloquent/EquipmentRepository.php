<?php
    namespace App\Repositories\Eloquent;

    use App\Repositories\Contracts\EquipmentInterface;
    use App\Models\Equipment;

    class EquipmentRepository implements EquipmentInterface
    {
        /**
         * @var Equipment
         */
        public $equipment;

        /**
         * EquipmentRepository constructor.
         *
         * @param Equipment $equipment
         */
        function __construct(Equipment $equipment)
        {
            $this->equipment = $equipment;
        }

        /**
         * Get all equipments
         *
         * @param array $columns
         *
         * @return \Illuminate\Database\Eloquent\Collection | boolean
         */
        public function all(array $columns = ['*'])
        {
            try {
                $equipment = $this->equipment->get($columns);
            }
            catch (\Throwable $exception) {
                return false;
            }

            return $equipment;
        }

        /**
         * Get equipment by id
         *
         * @param int $id
         * @param array $columns
         *
         * @return \Illuminate\Database\Eloquent\Collection | boolean
         */
        public function find(int $id, array $columns = ['*'])
        {
            try {
                $equipment = $this->equipment->find($id, $columns);
            }
            catch (\Throwable $exception) {
                return false;
            }

            return $equipment;
        }

        /**
         * Get equipment by field
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
                $equipment = $this->equipment->where($field, '=', $value)->first($columns);
            }
            catch (\Throwable $exception) {
                return false;
            }

            return $equipment;
        }

        /**
         * Create equipment
         *
         * @param array $data
         *
         * @return \Illuminate\Database\Eloquent\Collection | boolean
         */
        public function create(array $data)
        {
            try {
                $equipment = $this->equipment->create($data);
            }
            catch (\Throwable $exception) {
                return false;
            }

            return $equipment;
        }

        /**
         * Update equipment
         *
         * @param array $data
         * @param int $id
         *
         * @return boolean
         */
        public function update(array $data, int $id)
        {
            try {
                $this->equipment->where('id', '=', $id)->update($data);
            }
            catch (\Throwable $exception) {
                return false;
            }

            return true;
        }

        /**
         * Delete equipment
         *
         * @param int $id
         *
         * @return boolean
         */
        public function delete(int $id)
        {
            try {
                $this->equipment->destroy($id);
            }
            catch (\Throwable $exception) {
                return false;
            }

            return true;
        }

        /**
         * Delete multiple equipments
         *
         * @param array $ids
         *
         * @return boolean
         */
        public function bulkDelete(array $ids)
        {
            try{
                $this->equipment->whereIn('id', $ids)->delete();
            }
            catch (\Throwable $exception) {
                return false;
            }

            return true;
        }
    }