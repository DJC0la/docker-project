<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Enums\TypesRole;

class EnsureUserHasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $role
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $roleEnum = TypesRole::tryFrom($role);

        if (! $request->user() || ! $roleEnum || ! $request->user()->hasRole($roleEnum)) {
            abort(403, "Requires {$role} role");
        }

        return $next($request);
    }
}
