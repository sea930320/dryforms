<?php
    namespace App\Repositories\Contracts;

    interface EquipmentInterface
    {
        public function all(array $columns = ['*']);
        public function create(array $data);
        public function update(array $data, int $id);
        public function delete(int $id);
        public function bulkDelete(array $id);
        public function find(int $id, array $columns = ['*']);
        public function findBy(string $field, string $value, array $columns = ['*']);
    }