<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
    {
        Admin::truncate();
        Admin::create([
            'name' => 'Gibson Silali',
            'email' => 'silali@mail.com',
            'password' => bcrypt('password')
        ]);
    }
}
