<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'username'  => 'KPU010010000001',
                'password'  => Hash::make('password'),
                'kota_kab'  => '-',
                'kecamatan' => '-',
                'kelurahan' => '-',
                'role' => '01'
            ]
        ];
        for ($i = 0; $i < count($users); $i++) {
            User::create($users[$i]);
        }
    }
}
