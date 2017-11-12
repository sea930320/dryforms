<?php
    namespace App\Repositories\Contracts;

    interface TeamInterface
    {
        public function all(array $columns = ['*']);
        public function create(array $data);
        public function update(array $data, int $id);
        public function delete(int $id);
        public function find(int $id, array $columns = ['*']);
        public function findBy(string $field, string $value, array $columns = ['*']);
    }