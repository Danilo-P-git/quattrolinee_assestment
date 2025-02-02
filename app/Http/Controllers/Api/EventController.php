<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\EventRequest;
use App\Http\Resources\EventResource;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $perPage = 10;
            $events = Event::paginate($perPage);
            return ApiResponse::success($events);
        } catch (\Exception $e) {
            return ApiResponse::error('Error', 500, $e);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EventRequest $request)
    {
        try {
            $event = new Event($request->validated());
            $event->save();
            return ApiResponse::success($event, "Evento creato con successo", 201);
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500, $e);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $event = Event::findOrFail($id);
            return ApiResponse::success($event);
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 404, $e);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EventRequest $request, string $id)
    {
        try {
            $event = Event::findOrFail($id);
            $event->fill($request->validated());
            $event->save();
            return ApiResponse::success($event);
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 404, $e);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $event = Event::findOrFail($id);
            $event->delete();
            return ApiResponse::success($event);
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 404, $e);
        }
    }
}
