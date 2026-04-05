<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Service\WorkflowService;
use App\Http\Requests\StoreWorkflowRequest;
use App\Http\Requests\UpdateWorkflowRequest;
use App\Models\Project;
use App\Models\Workflow;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class WorkflowController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $id_user = Auth::id();
        $workflows = Workflow::with('project:id,name')->where('user_id', $id_user)->orderBy('created_at', 'desc')->get();

        return view('workflow.index')->with('workflows', $workflows);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $id_user = Auth::id();

        $projects = Project::where('user_id', $id_user)->select(['id', 'name'])->get();

        return view('workflow.create')->with('projects', $projects);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWorkflowRequest $request)
    {
        try {

            WorkflowService::addWorkflow($request->validated());

            return redirect()->route('workflow.index')->with('success', 'Workflow criado com sucesso!');

        } catch (\Exception $e) {

            Log::error('Erro ao criar workflow: '.$e->getMessage());

            return redirect()->back()
                ->with('error', 'Não foi possível criar o workflow. Tente novamente mais tarde.')
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Workflow $workflow)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Workflow $workflow)
    {
        $workflow->load('project:id,name');

        $id_user = Auth::id();
        $projects = Project::where('user_id', $id_user)->select(['id', 'name'])->get();

        return view('workflow.edit')->with(['workflow' => $workflow, 'projects' => $projects]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWorkflowRequest $request, $workflow)
    {
        try {

            WorkflowService::updateProject($workflow, $request->validated());

            return redirect()->route('workflow.index')->with('success', 'Workflow atualizado com sucesso!');

        } catch (\Exception $e) {
            Log::error('Erro ao atualizar o workflow: '.$e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Erro ao atualizar o workflow.',
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($workflow)
    {
        try {
            $workflow = Workflow::where('id', $workflow)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            $workflow->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Workflow excluído permanentemente.',
            ]);
        } catch (\Exception $e) {

            Log::error('Erro ao excluir o workflow: '.$e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Erro ao excluir o workflow.',
            ], 500);
        }
    }
}
