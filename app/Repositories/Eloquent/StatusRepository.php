<?php
    namespace App\Repositories\Eloquent;

    use App\Repositories\Contracts\StatusInterface;
    use App\Models\Status;

    class StatusRepository implements StatusInterface
    {
        /**
         * @var Status
         */
        public $status;

        /**
         * StatusRepository constructor.
         *
         * @param Status $status
         */
        function __construct(Status $status)
        {
            $this->status = $status;
        }

        /**
         * Get all statuses
         *
         * @param array $columns
         *
         * @return \Illuminate\Database\Eloquent\Collection | boolean
         */
        public function all(array $columns = ['*'])
        {
            try {
                $statuses = $this->status->get($columns);
            }
            catch (\Throwable $exception) {
                return false;
            }

            return $statuses;
        }

        /**
         * Find status by id
         *
         * @param int $id
         * @param array $columns
         *
         * @return \Illuminate\Database\Eloquent\Collection | boolean
         */
        public function find(int $id, array $columns = ['*'])
        {
            try {
                $status = $this->status->find($id, $columns);
            }
            catch (\Throwable $exception) {
                return false;
            }

            return $status;
        }

        /**
         * Find status by field
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
                $status = $this->status->where($field, '=', $value)->first($columns);
            }
            catch (\Throwable $exception) {
                return false;
            }

            return $status;
        }

        /**
         * Create status
         *
         * @param array $data
         *
         * @return \Illuminate\Database\Eloquent\Collection | boolean
         */
        public function create(array $data)
        {
            try {
                $status = $this->status->create($data);
            }
            catch (\Throwable $exception) {
                return false;
            }

            return $status;
        }

        /**
         * Update status
         *
         * @param array $data
         * @param int $id
         *
         * @return \Illuminate\Database\Eloquent\Collection | boolean
         */
        public function update(array $data, int $id)
        {
            try {
                $status = $this->status->where('id', '=', $id)->update($data);
            }
            catch (\Throwable $exception) {
                return false;
            }

            return $status;
        }

        /**
         * Delete status
         *
         * @param int $id
         *
         * @return boolean
         */
        public function delete(int $id)
        {
            try {
                $this->status->destroy($id);
            }
            catch (\Throwable $exception) {
                return false;
            }

            return true;
        }
    }