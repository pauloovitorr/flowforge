<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Service\EmailService;
use App\Http\Requests\StoreEmailRequest;
use App\Http\Requests\UpdateEmailRequest;
use App\Models\Email;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class EmailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $emails = Email::where('user_id', Auth::id())->get();

        return view('email.index')->with('emails', $emails);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('email.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEmailRequest $request)
    {

        try {

            EmailService::addEmail($request->validated());

            return redirect()->route('email.index')->with('success', 'Template criado com sucesso!');

        } catch (\Exception $e) {

            Log::error('Erro ao criar template de email: '.$e->getMessage());

            return redirect()->back()
                ->withErrors(['error' => 'Não foi possível criar o template. Tente novamente mais tarde.'])
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Email $email)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($email)
    {

        try {
            $email = Email::where('id', $email)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            return view('email.edit')->with('email', $email);

        } catch (\Exception $e) {

            Log::error('Erro ao buscar o Template de email: '.$e->getMessage());

            redirect()->back()
                ->withErrors(['error' => 'Não foi possível acessar a tela de edição de template. Tente novamente mais tarde.']);

        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmailRequest $request, $email)
    {
        try {

            EmailService::updateEmail($email, $request->validated());

            return redirect()->route('email.index')->with('success', 'Email atualizado com sucesso!');

        } catch (\Exception $e) {
            Log::error('Erro ao atualizar o email: '.$e->getMessage());

            return redirect()->back()
                ->withErrors(['error' => 'Erro ao atualizar o email.'])
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($email)
    {

        try {
            $email = Email::where('id', $email)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            $email->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Template de email excluído permanentemente.',
            ]);
        } catch (\Exception $e) {

            Log::error('Erro ao excluir o Template de email: '.$e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Erro ao excluir o Template de email.',
            ], 500);
        }

    }
}
