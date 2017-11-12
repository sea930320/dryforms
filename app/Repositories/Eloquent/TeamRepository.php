<?php
    namespace App\Repositories\Eloquent;

    use App\Repositories\Contracts\TeamInterface;
    use App\Models\Team;

    class TeamRepository implements TeamInterface
    {
        /**
         * @var Team
         */
        public $team;

        /**
         * TeamRepository constructor.
         *
         * @param Team $team
         */
        function __construct(Team $team)
        {
            $this->team = $team;
        }

        /**
         * Get all teams
         *
         * @param array $columns
         *
         * @return \Illuminate\Database\Eloquent\Collection | boolean
         */
        public function all(array $columns = ['*'])
        {
            try {
                $teams = $this->team->get($columns);
            }
            catch (\Throwable $exception) {
                dd($exception->getMessage());
                return false;
            }

            return $teams;
        }

        /**
         * Get team by id
         *
         * @param int $id
         * @param array $columns
         *
         * @return \Illuminate\Database\Eloquent\Collection | boolean
         */
        public function find(int $id, array $columns = ['*'])
        {
            try {
                $team = $this->team->find($id, $columns);
            }
            catch (\Throwable $exception) {
                return false;
            }

            return $team;
        }

        /**
         * Get team by field
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
                $team = $this->team->where($field, '=', $value)->first($columns);
            }
            catch (\Throwable $exception) {
                return false;
            }

            return $team;
        }

        /**
         * Create team
         *
         * @param array $data
         *
         * @return \Illuminate\Database\Eloquent\Collection | boolean
         */
        public function create(array $data)
        {
            try {
                $team = $this->team->create($data);
            }
            catch (\Throwable $exception) {
                return false;
            }

            return $team;
        }

        /**
         * Update team
         *
         * @param array $data
         * @param int $id
         *
         * @return \Illuminate\Database\Eloquent\Collection | boolean
         */
        public function update(array $data, int $id)
        {
            try {
                $team = $this->team->where('id', '=', $id)->update($data);
            }
            catch (\Throwable $exception) {
                return false;
            }

            return $team;
        }

        /**
         * Delete team
         *
         * @param int $id
         *
         * @return boolean
         */
        public function delete(int $id)
        {
            try {
                $this->team->destroy($id);
            }
            catch (\Throwable $exception) {
                return false;
            }

            return true;
        }
    }