<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use App\Services\UserService;

class UserController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
        $this->middleware('auth');
        $this->middleware('admin')->except(['index']);
    }

    public function index(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
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
        $this->userService->createUser($request->validated());
        return redirect()->route('dashboard')
            ->with('success', 'User successfully created');
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(UserUpdateRequest $request, User $user)
    {
        $this->userService->updateUser($user, $request->validated());
        return redirect()->route('dashboard')
            ->with('success', 'User updated successfully');
    }

    public function destroy(User $user)
    {
        if ($user->isAdmin() && User::where('role', 'admin')->count() <= 1) {
            return redirect()->route('dashboard')
                ->with('error', 'Cannot delete last administrator');
        }
        
        $this->userService->deleteUser($user);
        return redirect()->route('dashboard')
            ->with('success', 'User successfully deleted');
    }
}