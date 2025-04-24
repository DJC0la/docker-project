<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use App\Services\UserService;
use App\Enums\TypesRole;

class UserController extends Controller
{
    public function __construct(
        protected UserService $userService
    ) {}

    public function index(Request $request)
    {
        $showUserTable = auth()->user()->hasRole(TypesRole::ADMIN);

        $users = $showUserTable
            ? $this->userService->getFilteredUsers(
                $request->only(['search_name', 'search_email']),
                $request->input('perPage', 10)
            )
            : collect();

        return view('dashboard', [
            'users' => $users,
            'showUserTable' => $showUserTable
        ]);
    }

    public function index_organization(Request $request)
    {
        $showUserTable = auth()->user()->hasRole(TypesRole::ADMIN);

        return view('organization', [
            'organizations' => $organizations,
            'showUserTable' => $showUserTable
        ]);
    }

    public function store(UserStoreRequest $request)
    {
        $this->userService->createUser($request->validated());
        return redirect()->route('dashboard')
            ->with('success', 'User created successfully');
    }

    public function edit(User $user)
    {
        return view('users.edit', [
            'user' => $user,
            'roles' => TypesRole::cases()
        ]);
    }

    public function update(UserUpdateRequest $request, User $user)
    {
        $this->userService->updateUser($user, $request->validated());
        return redirect()->route('dashboard')
            ->with('success', 'User updated successfully');
    }

    public function destroy(User $user)
    {
        if ($this->userService->isLastAdmin($user)) {
            return redirect()->route('dashboard')
                ->with('error', 'Cannot delete last administrator');
        }

        $this->userService->deleteUser($user);
        return redirect()->route('dashboard')
            ->with('success', 'User deleted successfully');
    }
}
