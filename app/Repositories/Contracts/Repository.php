<?php
namespace App\Repositories\Contracts;

interface Repository
{
    public function getList(array $params, int $page, int $perPage, ?array $with = []);
}