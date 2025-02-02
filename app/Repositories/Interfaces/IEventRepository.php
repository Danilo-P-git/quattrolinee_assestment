<?php

namespace App\Repositories\Interfaces;

interface IEventRepository
{
    public function getAll($perPage = 10);
    public function create(array $data);
    public function findById($id);
    public function update($id, array $data);
    public function delete($id);
    public function searchAndFilter($query = null, $categoryId = null, $perPage = 10);
}
