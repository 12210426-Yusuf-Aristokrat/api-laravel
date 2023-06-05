<?php

namespace Database\Seeders;

use App\Models\UserModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserModel::query()->create(
            [
                'name' => 'Tester Pengguna',
                'email' => 'testpengguna@gmail.com',
                'level' => 'warga',
                'password' => bcrypt('12345'),
            ]
        );
    }
}
