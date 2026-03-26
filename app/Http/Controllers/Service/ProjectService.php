<?php

namespace App\Http\Controllers\Service;

use App\Models\Project;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ProjectService
{
    public static function addProject(array $data)
    {

        try {
            $data['user_id'] = Auth::id();
            $data['api_key'] = Str::random(32);
            Project::create($data);

        } catch (Exception $e) {
            Log::error('Erro ao criar projeto: '.$e->getMessage());
            throw $e;
        }

    }

    public static function updateProject($id, array $data)
    {
        try {

            $project = Project::find($id);

            $project->update($data);
        } catch (Exception $e) {
            Log::error('Erro ao atualizar projeto ID '.$project->id.': '.$e->getMessage());
            throw $e;
        }
    }
}
