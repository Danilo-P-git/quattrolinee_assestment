<?php

namespace App\Repositories;

use App\Models\Category;
use App\Models\Event;
use App\Repositories\Interfaces\ICategoryRepository;

class CategoryRepository implements ICategoryRepository
{
    public function getAll($perPage = 10)
    {
        return Category::paginate($perPage);
    }

    public function create(array $data)
    {
        return Category::create($data);
    }

    public function findById($id)
    {
        return Category::findOrFail($id);
    }

    public function update($id, array $data)
    {
        $event = $this->findById($id);
        $event->update($data);
        return $event;
    }

    public function delete($id)
    {
        $event = $this->findById($id);
        $event->delete();
        return $event;
    }
}
