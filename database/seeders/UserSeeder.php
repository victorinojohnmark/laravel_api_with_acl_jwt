<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles
        $adminRole = Role::create(['name' => 'admin']);
        $userRole = Role::create(['name' => 'user']);

        // Create permissions
        $permissions = [
            $viewUser = Permission::create(['name' => 'user-view']),
            $showUser = Permission::create(['name' => 'user-show']),
            $createUser = Permission::create(['name' => 'user-store']),
            $updateUser = Permission::create(['name' => 'user-update']),
            $deleteUser = Permission::create(['name' => 'user-delete']),
        ];
        

        // Assign permissions to roles
        // $adminRole->givePermissionTo($viewUserPermission, $showUserPermission, $createUserPermission, $updateUserPermission, $deleteUserPermission);
        // $userRole->givePermissionTo($createUserPermission);

        // // Assign roles to users
        // $user = User::find(1);
        // $user->assignRole('admin');

        // Create user
        $user = User::create([
            'name' => 'John Mark Victorino',
            'email' => 'victorinojohnmark@gmail.com',
            'password' => Hash::make('P@ssw0rd')
        ]);

        foreach ($permissions as $permission) {
            $user->givePermissionTo($permission);
        }
        // $user->givePermissionTo($viewUserPermission);

        // $user->assignRole('admin');
    }
}
