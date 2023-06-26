<?php

namespace Database\Seeders;

// 追加
use App\Models\Admin;
use Illuminate\Database\Seeder;
// 追加
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::create([
            'name' => '管理者',
            'email' => 'admin@minna-systems.com',
            'password' => Hash::make('password'),
        ]);
    }
}
