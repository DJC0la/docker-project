<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'search_name' => 'nullable|string|max:255',
            'search_email' => 'nullable|string|max:255',
            'perPage' => 'nullable|integer|min:1|max:100'
        ]);
    
        $searchName = $validated['search_name'] ?? null;
        $searchEmail = $validated['search_email'] ?? null;
        $perPage = $validated['perPage'] ?? 10;
        
        if (!auth()->check()) {
            return redirect()->route('login');
        }
    
        if (auth()->user()->role !== 'admin') {
            return view('dashboard', ['showUserTable' => false]);
        }
    
        $query = User::query()->select(['id', 'name', 'email', 'email_verified_at', 'created_at', 'role']);
    
        if ($request->filled('search_name')) {
            $query->byName($request->search_name);
        }
    
        if ($request->filled('search_email')) {
            $query->byEmail($request->search_email);
        }
    
        $perPage = min($request->input('perPage', 10), 100);
        $users = $query->paginate($perPage)->withQueryString();
    
        return view('dashboard', [
            'users' => $users,
            'showUserTable' => true
        ]);
    }
}