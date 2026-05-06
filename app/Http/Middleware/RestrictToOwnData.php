<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RestrictToOwnData
{
    protected array $ownDataOnlyRoutes = [
        'patients.index' => 'created_by',
        'patients.show' => 'created_by',
        'patients.edit' => 'created_by',
        'patients.update' => 'created_by',
        'expenses.index' => 'user_id',
        'expenses.edit' => 'user_id',
        'expenses.update' => 'user_id',
        'expenses.destroy' => 'user_id',
        'collection.index' => 'user_id',
        'collection.edit' => 'user_id',
        'collection.update' => 'user_id',
        'collection.destroy' => 'user_id',
        'schedules.edit' => 'user_id',
        'schedules.update' => 'user_id',
        'schedules.destroy' => 'user_id',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (!$user) {
            return redirect('/login');
        }

        $role = $user->roles->pluck('name')->first();

        if ($role === 'HomePhysiotherapist') {
            $currentRouteName = $request->route()->getName();

            if (isset($this->ownDataOnlyRoutes[$currentRouteName])) {
                $foreignKey = $this->ownDataOnlyRoutes[$currentRouteName];
                $modelId = $request->route()->parameter($this->getModelName($currentRouteName));

                if ($modelId && $modelId->$foreignKey !== $user->id) {
                    abort(403, 'You can only access your own records.');
                }
            }
        }

        return $next($request);
    }

    protected function getModelName(string $routeName): string
    {
        return match ($routeName) {
            'patients.index', 'patients.show', 'patients.edit', 'patients.update' => 'patient',
            'expenses.index', 'expenses.edit', 'expenses.update', 'expenses.destroy' => 'expense',
            'collection.index', 'collection.edit', 'collection.update', 'collection.destroy' => 'collection',
            'schedules.edit', 'schedules.update', 'schedules.destroy' => 'schedule',
            default => 'id'
        };
    }
}