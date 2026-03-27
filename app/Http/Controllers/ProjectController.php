<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Service\ProjectService;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $id_user = Auth::id();
        $projects = Project::where('user_id', $id_user )->orderBy('created_at', 'desc')->get();

        return view('project.index')->with('projects', $projects);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        try {
            // Tenta executar a lógica da Service
            ProjectService::addProject($request->validated());

            return response()->json([
                'status' => 'success',
                'message' => 'Projeto criado com sucesso!',
            ], 201);

        } catch (\Exception $e) {

            return response()->json([
                'status' => 'error',
                'message' => 'Não foi possível criar o projeto. Tente novamente mais tarde.',
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, $id)
    {
        try {
            // Chamamos a service passando o modelo e apenas os dados validados
            ProjectService::updateProject($id, $request->validated());

            return response()->json([
                'message' => 'Projeto atualizado com sucesso!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao atualizar o projeto.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $project = Project::findOrFail($id);
            $project->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Projeto excluído permanentemente.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Erro ao excluir o projeto.',
            ], 500);
        }
    }
}
