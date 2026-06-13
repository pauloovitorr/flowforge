<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Service\Api\EventService;
use App\Http\Requests\Api\StoreEventRequest;
use App\Http\Requests\Api\UpdateEventRequest;
use App\Models\Api\Event;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEventRequest $request)
    {
        try {
            // 1. Busca as informações vinculadas
            $project_id = EventService::searchProject($request->bearerToken());
            $workflows_id = EventService::searchWorkflow($project_id, $request->event_name);
            $actions = EventService::searchActions($workflows_id);

            // 2. CORREÇÃO: Primeiro criamos o registro do Evento na tabela 'events' com status 'pending'
            // Passamos o project_id e os dados validados do request
            $event = EventService::createProject($project_id, $request->validated());

            // 3. CORREÇÃO: Agora sim, disparamos o Job PASSANDO o ID do evento recém-criado ($event->id)
            $dispatch_tasks = EventService::dispatchJob($actions, $request->payload, $event->id);

            return response()->json([
                'status' => 'success',
                'data' => $event,
            ], 200, [], JSON_UNESCAPED_UNICODE);

        } catch (\Exception $e) {

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 404, [], JSON_UNESCAPED_UNICODE);

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEventRequest $request, Event $event)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        //
    }
}
