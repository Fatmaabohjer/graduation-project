<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        // ✅ Admin ثابت
        User::updateOrCreate(
            ['email' => 'admin@vitaplan.test'],
            [
                'name' => 'VitaPlan Admin',
                'password' => Hash::make('Admin12345!'),
                'is_admin' => 1,
                'is_active' => 1,
            ]
        );

        // ✅ Users Active
        $activeUsers = [
            ['name' => 'Fatma User', 'email' => 'fatma.user@vitaplan.test'],
            ['name' => 'Arwa User',  'email' => 'arwa.user@vitaplan.test'],
            ['name' => 'Sara User',  'email' => 'sara.user@vitaplan.test'],
            ['name' => 'Omar User',  'email' => 'omar.user@vitaplan.test'],
        ];

        foreach ($activeUsers as $u) {
            User::updateOrCreate(
                ['email' => $u['email']],
                [
                    'name' => $u['name'],
                    'password' => Hash::make('User12345!'),
                    'is_admin' => 0,
                    'is_active' => 1,
                ]
            );
        }

        // ✅ Users Disabled (باش تختبري منع الدخول)
        $disabledUsers = [
            ['name' => 'Disabled One', 'email' => 'disabled1@vitaplan.test'],
            ['name' => 'Disabled Two', 'email' => 'disabled2@vitaplan.test'],
        ];

        foreach ($disabledUsers as $u) {
            User::updateOrCreate(
                ['email' => $u['email']],
                [
                    'name' => $u['name'],
                    'password' => Hash::make('User12345!'),
                    'is_admin' => 0,
                    'is_active' => 0,
                ]
            );
        }

        // ✅ User يكون Admin جاهز للتجربة (اختياري)
        User::updateOrCreate(
            ['email' => 'admin2@vitaplan.test'],
            [
                'name' => 'Second Admin',
                'password' => Hash::make('Admin12345!'),
                'is_admin' => 1,
                'is_active' => 1,
            ]
        );
    }
}
