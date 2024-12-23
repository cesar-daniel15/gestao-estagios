<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UnitCurricular;
use App\Models\UcResponsible; 
use App\Models\User; 
use Illuminate\Support\Str; 
use App\Http\Resources\UcResponsibleResource; 
use Illuminate\Support\Facades\Validator; 
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ResponsibleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->profile !== 'Responsible') {
            return redirect()->back()->with('error', 'Você não tem permissão para eceder a esta página.');
        }

        $user = Auth::user();

        return view('users.responsible.dashboard', compact('user'));
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
    public function store(Request $request)
    {
        $user = Auth::user();
        $responsible = $user->responsible;

        // Validação
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string|max:15|unique:uc_responsibles,phone' . ($responsible ? ',' . $responsible->id : ''),
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $validator->validated();

        if ($responsible) {
            // Atualiza o registro existente
            $responsible->update($data);

            // Verifica se a imagem foi enviada e faz o upload
            if ($request->hasFile('picture')) {
                if ($responsible->picture && Storage::exists($responsible->picture)) {
                    Storage::delete($responsible->picture);
                }
                $path = $request->file('picture')->store('images/uploads', 'public');
                $responsible->update(['picture' => $path]);
            }

            return redirect()->route('responsible.profile')->with('success', 'Perfil atualizado com sucesso!');
        } else {
            // Cria um novo registro
            $responsible = UcResponsible::create($data);

            // Associa o responsável ao utilizador logado
            $user->id_responsible = $responsible->id;
            $user->save();

            if ($request->hasFile('picture')) {
                $path = $request->file('picture')->store('images/uploads', 'public');
                $responsible->update(['picture' => $path]);
            }

            return redirect()->route('responsible.profile')->with('success', 'Perfil criado com sucesso!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $user = Auth::user();
        $responsible = $user->responsible ?? null;
        $unitsCurricular = UnitCurricular::all(); 

        return view('users.responsible.profile', compact('user', 'responsible', 'unitsCurricular'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
{
    $responsible = Responsible::findOrFail($id);

    // Validação dos dados
    $validator = Validator::make($request->all(), [
        'phone' => 'required|string|max:15|unique:responsibles,phone,' . $responsible->id,
        'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Verifica se a validação falhou
    if ($validator->fails()) {
        // Passa os erros para a sessão e redireciona
        session()->flash('error', 'Erro de validação!');
        session()->flash('validation_errors', $validator->errors()->all());

        return redirect()->back()->withInput();
    }

    // Dados validados
    $validated = $validator->validated();

    // Prepara os dados para atualização
    $dataToUpdate = [];

    // Atualiza apenas os campos que mudaram
    if (isset($validated['phone']) && $validated['phone'] !== $responsible->phone) {
        $dataToUpdate['phone'] = $validated['phone'];
    }

    if ($request->hasFile('picture')) {
        // Remove a imagem antiga, se existir
        if ($responsible->picture && Storage::exists($responsible->picture)) {
            Storage::delete($responsible->picture);
        }

        // Faz o upload da nova imagem
        $path = $request->file('picture')->store('images/uploads', 'public');
        $dataToUpdate['picture'] = $path;
    }

    // Verifica se há algo para atualizar
    if (!empty($dataToUpdate)) {
        $responsible->update($dataToUpdate);

        return redirect()->route('responsibles.profile')->with('success', 'Perfil atualizado com sucesso!');
    }

    return redirect()->route('responsibles.profile')->with('info', 'Nenhuma alteração foi feita.');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $responsible = Responsible::findOrFail($id);

        if ($responsible->picture && Storage::exists($responsible->picture)) {
            Storage::delete($responsible->picture);
        }

        $responsible->delete();

        return redirect()->route('responsibles.index')->with('success', 'Responsável removido com sucesso!');
    }
}