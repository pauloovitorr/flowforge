<?php

namespace App\Http\Controllers\Service\Api;

use App\Models\Api\Event;
use App\Models\Project;
use Exception;
use Illuminate\Support\Facades\Log;

class EventService
{
    public static function searchProject(string $token)
    {

        try {
            $project = Project::where('api_key', $token)
                ->select('id')
                ->firstOrFail();

            return $project->id;

        } catch (Exception $e) {
            Log::error('Erro ao buscar projeto: '.$e->getMessage());
            throw $e;
        }

    }

    public static function createProject(int $id, array $data)
    {
        try {

            $data['project_id'] = $id;
            $data['status'] = 'pending';
            $event = Event::create($data);
            return $event;

        } catch (Exception $e) {
            Log::error('Erro ao cadastrar o evento: '.$e->getMessage());
            throw $e;
        }

    }
}
