<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'user-index']);
        Permission::create(['name' => 'user-list']);
        Permission::create(['name' => 'user-create']);
        Permission::create(['name' => 'user-edit']);
        Permission::create(['name' => 'user-delete']);

        Permission::create(['name' => 'role-index']);
        Permission::create(['name' => 'role-list']);
        Permission::create(['name' => 'role-create']);
        Permission::create(['name' => 'role-edit']);
        Permission::create(['name' => 'role-delete']);

        Permission::create(['name' => 'patient-index']);
        Permission::create(['name' => 'patient-list']);
        Permission::create(['name' => 'patient-create']);
        Permission::create(['name' => 'patient-edit']);
        Permission::create(['name' => 'patient-delete']);

        Permission::create(['name' => 'appointment-index']);
        Permission::create(['name' => 'appointment-list']);
        Permission::create(['name' => 'appointment-create']);
        Permission::create(['name' => 'appointment-edit']);
        Permission::create(['name' => 'appointment-delete']);

        Permission::create(['name' => 'payment-index']);
        Permission::create(['name' => 'payment-list']);
        Permission::create(['name' => 'payment-print']);
        Permission::create(['name' => 'payment-create']);
        Permission::create(['name' => 'payment-edit']);
        Permission::create(['name' => 'payment-delete']);

        Permission::create(['name' => 'doctor-index']);
        Permission::create(['name' => 'doctor-list']);
        Permission::create(['name' => 'doctor-create']);
        Permission::create(['name' => 'doctor-edit']);
        Permission::create(['name' => 'doctor-delete']);

        Permission::create(['name' => 'availability-index']);
        Permission::create(['name' => 'availability-list']);
        Permission::create(['name' => 'availability-create']);
        Permission::create(['name' => 'availability-edit']);
        Permission::create(['name' => 'availability-delete']);

        $roleOne = Role::create(['name' => 'admin']);
        $roleOne->givePermissionTo(Permission::all());
        $roleTwo = Role::create(['name' => 'secretary']);

        $user = new User;
        $user->name = 'Default';
        $user->lastname = 'One';
        $user->username = 'admindefault';
        $user->email = 'admin@enfoquesalud.com';
        $user->password = bcrypt('admin@enfoquesalud.com');
        $user->assignRole($roleOne);
        $user->save();

        $user = new User;
        $user->name = 'Default';
        $user->lastname = 'Two';
        $user->username = 'secretarydefault';
        $user->email = 'secretary@enfoquesalud.com';
        $user->password = bcrypt('secretary@enfoquesalud.com');
        $user->assignRole($roleTwo);
        $user->save();
    }
}
