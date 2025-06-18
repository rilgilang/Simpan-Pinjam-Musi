<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Create roles
        $adminRole = Role::create(['name' => 'admin']);
        $ketuaRole = Role::create(['name' => 'ketua']);
        $anggotaRole = Role::create(['name' => 'anggota']);

        // Create permissions
        $createPinjamanPermission = Permission::create(['name' => 'create pinjaman']);
        $createSimpananPermission = Permission::create(['name' => 'create simpanan']);
        $createUserPermission = Permission::create(['name' => 'create user']);
        $createAnggotaPermission = Permission::create(['name' => 'create anggota']);
        

        // Assign permissions to roles
        $adminRole->givePermissionTo($createPinjamanPermission);
        $adminRole->givePermissionTo($createSimpananPermission);
        $adminRole->givePermissionTo($createAnggotaPermission);
        $adminRole->givePermissionTo($createUserPermission);


        // Create user
        $admin = User::create([
            'name' => "xifutang",
            'email' => "admin1@gmail.com",
            'password' => "admin123",
        ]);

        $admin->assignRole('admin');

                // Create user
        $ketua = User::create([
            'name' => "xifutang",
            'email' => "ketua1@gmail.com",
            'password' => "ketua123",
        ]);

        $ketua->assignRole('ketua');
    }
}
