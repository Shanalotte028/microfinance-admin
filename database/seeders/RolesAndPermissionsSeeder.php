<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement("SET SQL_MODE='ALLOW_INVALID_DATES';");
        // Create roles
        $admin = Role::create(['name' => 'Admin']);
        $staff = Role::create(['name' => 'Staff']);
        $staffManager = Role::create(['name' => 'Staff Manager']);
        $lawyer = Role::create(['name' => 'Lawyer']);
        $fieldOfficer = Role::create(['name'=> 'Field Officer']);
        $Trainer = Role::create(['name' => 'Trainer']);

        $permissions = [
            'clients.index','clients.show','clients.edit','clients.update','clients.block',
            'compliances.index','compliances.show','compliances.approve','compliances.reject',
            'audit',
            'legal.index','legal.show','legal.edit','legal.create','legal.update',
            'users.index','users.show','users.create','users.edit','users.update','users.deactivate',
            'investigation.assign', 'investigation.index', 'investigation.show', 'investigation.edit','investigation.update', 'investigation.credit_investigations',
            'approve.users', 'reject.users', 'approve.legal_cases', 'reject.legal_cases',
            'assess.risk'
        ];

          // Create and assign permissions
          foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Define roles and their associated permissions
        $roles = [
            'Admin' => $permissions,  // Full access
            'Staff Manager' => ['clients.index','clients.show','clients.block',
                                'compliances.index','compliances.show','compliances.approve','compliances.reject',
                                'audit','legal.index','legal.show','legal.edit','legal.create','legal.update','users.index','users.show','users.create',
                                'investigation.assign', 'investigation.credit_investigations',
                                'approve.users', 'reject.users', 'approve.legal_cases', 'reject.legal_cases','assess.risk'],
            'Staff' => ['clients.index','clients.show',
                        'compliances.index','compliances.show','compliances.approve','compliances.reject','assess.risk'],
            'Lawyer' => ['clients.show','legal.show','legal.edit','legal.update','compliances.show'],
            'Field Officer' => ['clients.show', 'compliances.show', 'investigation.show', 'investigation.edit', 'investigation.update', 'investigation.credit_investigations']
        ];

        // Create roles and assign permissions
        foreach ($roles as $roleName => $rolePermissions) {
            $role = Role::firstOrCreate(['name' => $roleName]);
            $role->syncPermissions($rolePermissions);
        }
    }
}


