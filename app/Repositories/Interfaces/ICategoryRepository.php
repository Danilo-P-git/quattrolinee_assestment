<?php

namespace App\Repositories\Interfaces;

interface ICategoryRepository
{
    public function getAll($perPage = 10);
    public function create(array $data);
    public function findById($id);
    public function update($id, array $data);
    public function delete($id);
}
