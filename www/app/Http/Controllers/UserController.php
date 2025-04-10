<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
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

    public function store(UserStoreRequest $request)
    {
        if (!$this->authService->isAdmin()) {
            abort(403);
        }

        $validated = $request->validated();
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

    public function update(UserUpdateRequest $request, User $user)
    {
        if (!$this->authService->isAdmin()) {
            abort(403);
        }

        $validated = $request->validated();
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