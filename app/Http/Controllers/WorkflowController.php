<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Service\WorkflowService;
use App\Models\Project;
use App\Models\Workflow;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWorkflowRequest;
use App\Http\Requests\UpdateWorkflowRequest;
use Illuminate\Support\Facades\Auth;

class WorkflowController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('workflow.index');
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

            return response()->json([
                'status' => 'success',
                'message' => 'Workflow criado com sucesso!',
            ], 201, [], JSON_UNESCAPED_UNICODE);

            
        } catch (\Exception $e) {

            return response()->json([
                'status' => 'error',
                'message' => 'Não foi possível criar o workflow. Tente novamente mais tarde.',
            ], 500, [], JSON_UNESCAPED_UNICODE);
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWorkflowRequest $request, Workflow $workflow)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Workflow $workflow)
    {
        //
    }
}
