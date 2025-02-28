<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; 
use App\Models\Contact;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->profile !== 'Admin') {
            return redirect()->back()->with('error', 'Você não tem permissão para eceder a esta página.');
        }

        $contacts = Contact::all();

        $user = Auth::user();

        $totalUsers = User::count();

        $mostCommonProfile = User::select('profile', DB::raw('count(*) as count'))
            ->groupBy('profile')
            ->orderBy('count', 'desc')
            ->first();

        $userRegistration = User::select(DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d") as date'), DB::raw('COUNT(*) as count'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('admin.dashboard', [
            'contacts' => $contacts,
            'totalUsers' => $totalUsers,
            'mostCommonProfile' => $mostCommonProfile,
            'userRegistration' => $userRegistration,
            'user' => $user, 
        ]);
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
