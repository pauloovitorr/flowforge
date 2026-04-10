<?php

namespace App\Http\Controllers;

use App\Models\WorkflowActions;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWorkflowActionsRequest;
use App\Http\Requests\UpdateWorkflowActionsRequest;

class WorkflowActionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('workflow-actions.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('workflow-actions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWorkflowActionsRequest $request)
    {
        dd($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(WorkflowActions $workflowActions)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WorkflowActions $workflowActions)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWorkflowActionsRequest $request, WorkflowActions $workflowActions)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WorkflowActions $workflowActions)
    {
        //
    }
}
