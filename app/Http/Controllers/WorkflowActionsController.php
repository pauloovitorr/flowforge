<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Service\ActionService;
use App\Http\Requests\StoreWorkflowActionsRequest;
use App\Http\Requests\UpdateWorkflowActionsRequest;
use App\Models\Email;
use App\Models\Workflow;
use App\Models\WorkflowActions;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class WorkflowActionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $id_user = Auth::id();
        $actions = WorkflowActions::whereHas('workflow', function ($query) use ($id_user) {
            $query->where('user_id', $id_user);
        })->with('workflow')->get();

        return view('workflow-actions.index')->with('actions', $actions);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $id_user = Auth::id();

        $workflows = Workflow::where('user_id', $id_user)->select(['id', 'name'])->get();

        $emails = Email::where('user_id', $id_user)->where('status', 'active')->select(['id', 'subject', 'body'])->get();

        return view('workflow-actions.create')->with(['workflows' => $workflows, 'emails' => $emails]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWorkflowActionsRequest $request)
    {

        try {

            ActionService::addAction($request->validated());

            return redirect()->route('workflow_action.index')->with('success', 'Action criada com sucesso!');

        } catch (Exception $e) {

            Log::error('Erro ao criar action: '.$e->getMessage());

            return redirect()->back()
                ->withErrors(['error' => 'Não foi possível criar a action. Tente novamente mais tarde.'])
                ->withInput();
        }

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
    public function edit($workflowActions)
    {
        $id_user = Auth::id();

        $workflows = Workflow::where('user_id', $id_user)->select(['id', 'name'])->get();

        $emails = Email::where('user_id', $id_user)->where('status', 'active')->select(['id', 'subject', 'body'])->get();

        $action = WorkflowActions::with('workflow')
            ->where('id', $workflowActions)
            ->whereHas('workflow', function ($query) use ($id_user) {
                $query->where('user_id', $id_user);
            })
            ->first();

        // dd($action);

        return view('workflow-actions.edit')->with(['workflows' => $workflows, 'emails' => $emails, 'action' => $action]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWorkflowActionsRequest $request, $workflow_action)
    {
        try {
            
            $validated = $request->validated();
            
            $configApi = [
                'url' => $validated['url'] ?? '',
                'method' => $validated['method'] ?? 'POST',
                'headers' => [],
                'body' => [],
            ];

            

            // Combina os arrays de KEY => VALUE dos Headers
            if (! empty($validated['headers_keys']) && ! empty($validated['headers_values'])) {
                // array_combine transforma ['0' => 'Autorization1'] e ['0' => 'Bearer...'] em ['Autorization1' => 'Bearer...']
                $configApi['headers'] = array_combine($validated['headers_keys'], $validated['headers_values']);
            }

            // Combina os arrays de KEY => VALUE do Body
            if (! empty($validated['body_keys']) && ! empty($validated['body_values'])) {
                $configApi['body'] = array_combine($validated['body_keys'], $validated['body_values']);
            }

           
            $dataToUpdate = [
                'workflow_id' => $validated['workflow_id'],
                'type' => $validated['type'],
                'email_id' => $validated['email_id'] ?? null,
                'config_api' => $configApi, // O Laravel vai converter isso em JSON graças ao cast('array')
            ];

            // Envio o array estruturado para o Service
            ActionService::updateAction($workflow_action, $dataToUpdate);

            return redirect()->route('workflow_action.index')->with('success', 'Action atualizada com sucesso!');

        } catch (Exception $e) {
            Log::error('Erro ao atualizar action: '.$e->getMessage());

            return redirect()->back()
                ->withErrors(['error' => 'Não foi possível atualizar a action. Tente novamente mais tarde.'])
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WorkflowActions $workflow_action)
    {
        try {

            $workflow_action->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Action Excluída com sucesso.',
            ]);

        } catch (Exception $e) {
            Log::error('Erro ao excluir action: '.$e->getMessage());

            return response()
                ->json(
                    ['error' => 'Não foi possível excluir a action. Tente novamente mais tarde.'],
                    500);
        }
    }
}
