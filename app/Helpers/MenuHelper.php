<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;

class MenuHelper
{
    public static function canAccessMenu(string $menu): bool
    {
        $user = Auth::user();
        
        if (!$user) {
            return false;
        }

        $role = $user->roles->pluck('name')->first();

        $menuPermissions = self::getMenuPermissions();

        if (!isset($menuPermissions[$menu])) {
            return $role === 'HomePhysiotherapist' ? false : true;
        }

        $requiredRoles = $menuPermissions[$menu]['roles'] ?? [];
        $requiredPermissions = $menuPermissions[$menu]['permissions'] ?? [];

        if (in_array($role, $requiredRoles)) {
            return true;
        }

        foreach ($requiredPermissions as $permission) {
            if ($user->can($permission)) {
                return true;
            }
        }

        return false;
    }

    public static function getMenuPermissions(): array
    {
        return [
            'dashboard' => [
                'roles' => ['HomePhysiotherapist', 'Admin', 'Super-Admin', 'owner', 'DIRECTOR'],
                'permissions' => []
            ],
            'opd' => [
                'roles' => ['HomePhysiotherapist', 'Admin', 'Super-Admin', 'owner', 'DIRECTOR'],
                'permissions' => ['Opd-Registration']
            ],
            'patients' => [
                'roles' => ['HomePhysiotherapist', 'Admin', 'Super-Admin', 'owner', 'DIRECTOR'],
                'permissions' => ['list-Patient']
            ],
            'expenses' => [
                'roles' => ['HomePhysiotherapist', 'Admin', 'Super-Admin', 'owner', 'DIRECTOR'],
                'permissions' => ['list-Expense']
            ],
            'hide_patients' => [
                'roles' => ['Super-Admin', 'owner', 'DIRECTOR'],
                'permissions' => ['Hide-Patients']
            ],
            'roles_permissions' => [
                'roles' => ['Super-Admin', 'owner', 'DIRECTOR'],
                'permissions' => []
            ],
            'users' => [
                'roles' => ['Super-Admin', 'owner', 'DIRECTOR'],
                'permissions' => []
            ],
            'invoices' => [
                'roles' => ['HomePhysiotherapist', 'Admin', 'Super-Admin', 'owner', 'DIRECTOR'],
                'permissions' => []
            ],
            'branches' => [
                'roles' => ['Admin', 'Super-Admin', 'owner', 'DIRECTOR'],
                'permissions' => []
            ],
            'payment_modes' => [
                'roles' => ['Admin', 'Super-Admin', 'owner', 'DIRECTOR'],
                'permissions' => []
            ],
            'tele_calling' => [
                'roles' => ['Admin', 'Super-Admin', 'owner', 'DIRECTOR'],
                'permissions' => []
            ],
            'service_types' => [
                'roles' => ['Admin', 'Super-Admin', 'owner', 'DIRECTOR'],
                'permissions' => []
            ],
            'reports' => [
                'roles' => ['HomePhysiotherapist', 'Admin', 'Super-Admin', 'owner', 'DIRECTOR'],
                'permissions' => ['view-collectionReport', 'view-CustomCollectionReport', 'Exp-ReportShow']
            ],
            'custom_range_report' => [
                'roles' => ['HomePhysiotherapist', 'Admin', 'Super-Admin', 'owner', 'DIRECTOR'],
                'permissions' => ['rangeDailyReport']
            ],
            'website_settings' => [
                'roles' => ['Admin', 'Super-Admin', 'owner', 'DIRECTOR'],
                'permissions' => []
            ],
            'zoom_meetings' => [
                'roles' => ['Admin', 'Super-Admin', 'owner', 'DIRECTOR'],
                'permissions' => []
            ],
            'contact_messages' => [
                'roles' => ['Admin', 'Super-Admin', 'owner', 'DIRECTOR'],
                'permissions' => []
            ],
            'settings' => [
                'roles' => ['Super-Admin', 'owner', 'DIRECTOR'],
                'permissions' => []
            ],
            'audit_logs' => [
                'roles' => ['Super-Admin', 'owner', 'DIRECTOR', 'Admin'],
                'permissions' => ['view-audit-logs']
            ]
        ];
    }

    public static function isMenuHiddenForRole(string $menu, string $role): bool
    {
        $menuPermissions = self::getMenuPermissions();
        
        if (!isset($menuPermissions[$menu])) {
            return false;
        }

        $requiredRoles = $menuPermissions[$menu]['roles'] ?? [];
        
        return !in_array($role, $requiredRoles);
    }

    public static function getAllowedMenusForCurrentUser(): array
    {
        $user = Auth::user();
        
        if (!$user) {
            return [];
        }

        $role = $user->roles->pluck('name')->first();
        $allowedMenus = [];

        foreach (self::getMenuPermissions() as $menu => $config) {
            $requiredRoles = $config['roles'] ?? [];
            
            if (in_array($role, $requiredRoles)) {
                $allowedMenus[] = $menu;
            }
        }

        return $allowedMenus;
    }
}