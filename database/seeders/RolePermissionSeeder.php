<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'view_courses',
            'create_courses',
            'edit_courses',
            'delete_courses',
        ];

        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission,
            ]);
        }

        // Membuat Role Teacher
        $teacherRole = Role::create([
            "name" => "teacher",
        ]);

        $teacherRole->givePermissionTo([
            'view_courses',
            'create_courses',
            'edit_courses',
            'delete_courses',
        ]);

        // Membuat Role Student
        $studentRole = Role::create([
            'name' => 'student',
        ]);

        $studentRole->givePermissionTo([
            'view_courses',
        ]);

        // Membuat User Super Admin
        $user = User::create([
            "name" => "Super Admin",
            "email" => "superadmin@baycourse.com",
            "password" => bcrypt("12345678"),
        ]);
        $user->assignRole($teacherRole);
    }
}
