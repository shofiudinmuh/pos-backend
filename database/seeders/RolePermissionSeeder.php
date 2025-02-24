<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'view product',
            'create product',
            'edit product',
            'delete product',
            'view categories',
            'create categories',
            'edit categories',
            'delete categories',
            'view transaction',
            'create transaction',
            'edit transaction',
            'delete transaction',
            'view customer',
            'create customer',
            'edit customer',
            'delete customer',
            'view supplier',
            'create supplier',
            'edit supplier',
            'delete supplier',
            'view purchase',
            'create purchase',
            'edit purchase',
            'delete purchase',
            'view inventory',
            'create inventory',
            'edit inventory',
            'delete inventory'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $roles = ['admin', 'kasir', 'manager'];

        foreach ($roles as $role) {
            $roleInstance = Role::firstOrCreate(['name' => $role]);

            if ($role === 'admin') {
                $roleInstance->givePermissionTo(Permission::all());
            } elseif ($role === 'kasir') {
                $roleInstance->givePermissionTo([
                    'view product',
                    'view transaction',
                    'create transaction',
                    'edit transaction',
                    'view customer',
                    'create customer',
                    'edit customer',
                ]);
            } elseif ($role === 'manager') {
                $roleInstance->givePermissionTo([
                    'view transaction',
                    'view product',
                    'view categories',
                    'view customer',
                    'view supplier'
                ]);
            }
        }
    }
}