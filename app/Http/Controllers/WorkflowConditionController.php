<?php

namespace App\Http\Controllers;

use App\Models\WorkflowCondition;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWorkflowConditionRequest;
use App\Http\Requests\UpdateWorkflowConditionRequest;

class WorkflowConditionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(StoreWorkflowConditionRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(WorkflowCondition $workflowCondition)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WorkflowCondition $workflowCondition)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWorkflowConditionRequest $request, WorkflowCondition $workflowCondition)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WorkflowCondition $workflowCondition)
    {
        //
    }
}
