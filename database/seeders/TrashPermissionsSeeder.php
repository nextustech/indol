<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class TrashPermissionsSeeder extends Seeder
{
    public function run()
    {
        $resources = [
            'user' => 'Users',
            'branch' => 'Branches',
            'patient' => 'Patients',
            'payment' => 'Payments',
            'expense' => 'Expenses',
            'collection' => 'Collections',
            'invoice' => 'Invoices',
            'schedule' => 'Schedules',
            'servicetype' => 'Service Types',
            'ecat' => 'Expense Categories',
            'call' => 'Calls',
            'bill' => 'Bills',
            'mode' => 'Payment Modes',
            'contact' => 'Contacts',
            'holiday' => 'Holidays',
            'blog-post' => 'Blog Posts',
            'blog-category' => 'Blog Categories',
            'blog-tag' => 'Blog Tags',
            'slider' => 'Sliders',
            'zoom-meeting' => 'Zoom Meetings',
            'branch-appointment-type' => 'Branch Appointment Types',
            'availability-window' => 'Availability Windows',
            'appointment-type' => 'Appointment Types',
            'appointment' => 'Appointments',
        ];

        $permissions = [];

        foreach ($resources as $key => $label) {
            $permissions[] = Permission::firstOrCreate(['name' => "view-trash-{$key}", 'guard_name' => 'web']);
            $permissions[] = Permission::firstOrCreate(['name' => "restore-{$key}", 'guard_name' => 'web']);
            $permissions[] = Permission::firstOrCreate(['name' => "force-delete-{$key}", 'guard_name' => 'web']);
        }

        $permissions[] = Permission::firstOrCreate(['name' => 'view-audit-logs', 'guard_name' => 'web']);

        $superAdminRoles = ['Super-Admin', 'owner', 'DIRECTOR'];
        foreach ($superAdminRoles as $roleName) {
            $role = Role::where('name', $roleName)->first();
            if ($role) {
                foreach ($permissions as $permission) {
                    $role->givePermissionTo($permission);
                }
            }
        }

        $adminRole = Role::where('name', 'Admin')->first();
        if ($adminRole) {
            foreach ($permissions as $permission) {
                if (!str_starts_with($permission->name, 'force-delete-')) {
                    $adminRole->givePermissionTo($permission);
                }
            }
        }

        $this->command->info('Trash permissions created and assigned successfully!');
    }
}
