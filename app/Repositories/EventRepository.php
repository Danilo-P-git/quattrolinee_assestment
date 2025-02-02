<?php

namespace App\Repositories;

use App\Models\Event;
use App\Repositories\Interfaces\IEventRepository;

class EventRepository implements IEventRepository
{
    public function getAll($perPage = 10)
    {
        return Event::paginate($perPage);
    }

    public function create(array $data)
    {
        return Event::create($data);
    }

    public function findById($id)
    {
        return Event::findOrFail($id);
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
