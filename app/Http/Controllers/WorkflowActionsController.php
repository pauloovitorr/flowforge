<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWorkflowActionsRequest;
use App\Http\Requests\UpdateWorkflowActionsRequest;
use App\Models\Email;
use App\Models\Workflow;
use App\Models\WorkflowActions;
use Illuminate\Support\Facades\Auth;

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
        $id_user = Auth::id();

        $workflows = Workflow::where('user_id', $id_user)->select(['id', 'name'])->get();

        $emails = Email::where('user_id', $id_user)->where('status', 'active')->select(['id', 'subject', 'body'])->get();

        
        return view('workflow-actions.create')->with(['workflows' => $workflows, 'emails' => $emails ]);
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
