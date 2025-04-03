<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AuthService;
use App\Services\UserService;

class UserController extends Controller
{
    protected $authService;
    protected $userService;

    public function __construct(AuthService $authService, UserService $userService)
    {
        $this->authService = $authService;
        $this->userService = $userService;
    }

    public function index(Request $request)
    {     
        if (!$this->authService->isAuthenticated()) {
            return $this->authService->redirectToLogin();
        }
    
        if (!$this->authService->isAdmin()) {
            return view('dashboard', ['showUserTable' => false]);
        }
    
        $users = $this->userService->getFilteredUsers(
            $request->only(['search_name', 'search_email']),
            $request->input('perPage', 10)
        );
    
        return view('dashboard', [
            'users' => $users,
            'showUserTable' => true
        ]);
    }

    public function store(Request $request)
    {
        if (!$this->authService->isAdmin()) {
            abort(403);
        }

        $user = $this->userService->createUser($validated);

        return redirect()->route('dashboard')->with('success', 'Пользователь успешно создан');
    }
}