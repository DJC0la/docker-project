<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AuthService;
use App\Services\UserService;
use App\Models\User;

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

    public function edit(User $user)
    {
        if (!$this->authService->isAdmin()) {
            abort(403);
        }

        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        if (!$this->authService->isAdmin()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'password' => 'nullable|string|min:8',
            'role' => 'required|in:user,admin',
        ]);

        $this->userService->updateUser($user, $validated);

        return redirect()->route('dashboard')->with('success', 'Пользователь успешно обновлен');
    }

    public function destroy(User $user)
    {
        if (!$this->authService->isAdmin()) {
            abort(403);
        }

        $this->userService->deleteUser($user);

        return redirect()->route('dashboard')->with('success', 'Пользователь успешно удален');
    }
}