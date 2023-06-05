<?php

namespace Database\Seeders;

use App\Models\UserDetail;
use App\Models\UserDetailModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserDetailModel::query()->create(
            [
                'nama_lengkap'=> 'Antonia Asiu',
                'gender' => 'L',
                'tgl_lahir'=> '2002-03-09',
                'alamat'=> 'jalan kenangan indah',
                'lokasi'=> '-0.055434278458066366, 109.32210041608816',
                'user_id'=> 1,


            ],
            );
    }
}
