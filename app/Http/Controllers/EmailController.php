<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Service\EmailService;
use App\Http\Requests\StoreEmailRequest;
use App\Http\Requests\UpdateEmailRequest;
use App\Models\Email;
use Illuminate\Support\Facades\Log;

class EmailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('email.index');
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
                ->withErrors('error', 'Não foi possível criar o workflow. Tente novamente mais tarde.')
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
    public function edit(Email $email)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmailRequest $request, Email $email)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Email $email)
    {
        //
    }
}
