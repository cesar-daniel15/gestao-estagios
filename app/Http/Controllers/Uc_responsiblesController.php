<?php

namespace App\Http\Controllers;

use App\Models\UcResponsible;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class Uc_responsiblesController extends Controller
{
    /**
     * Display a listing of the UC Responsibles.
     */
    public function index()
    {
        $ucResponsibles = UcResponsible::all();
        return response()->json($ucResponsibles);
    }

    /**
     * Store a newly created UC Responsible in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'uc_id' => 'required|exists:units_curriculars,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:uc_responsibles,email',
            'password' => 'required|string|min:8',
            'phone' => 'required|string|max:20',
            'picture' => 'nullable|string',
            'token' => 'required|string|unique:uc_responsibles,token',
            'account_is_verify' => 'boolean',
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);

        $ucResponsible = UcResponsible::create($validatedData);

        return response()->json($ucResponsible, 201);
    }

    /**
     * Display the specified UC Responsible.
     */
    public function show($id)
    {
        $ucResponsible = UcResponsible::findOrFail($id);
        return response()->json($ucResponsible);
    }

    /**
     * Update the specified UC Responsible in storage.
     */
    public function update(Request $request, $id)
    {
        $ucResponsible = UcResponsible::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'string|max:255',
            'email' => 'email|unique:uc_responsibles,email,' . $id,
            'password' => 'string|min:8',
            'phone' => 'string|max:20',
            'picture' => 'nullable|string',
            'token' => 'string|unique:uc_responsibles,token,' . $id,
            'account_is_verify' => 'boolean',
        ]);

        if (isset($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        }

        $ucResponsible->update($validatedData);

        return response()->json($ucResponsible);
    }

    /**
     * Remove the specified UC Responsible from storage.
     */
    public function destroy($id)
    {
        $ucResponsible = UcResponsible::findOrFail($id);
        $ucResponsible->delete();

        return response()->json(null, 204);
    }
}
