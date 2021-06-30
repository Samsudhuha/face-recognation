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
        $j = 0;
        for ($i = 1; $i < 515; $i++) {
            if ($i < 10) {
                $j = '00' . $i;
            } elseif ($i < 100) {
                $j = '0' . $i;
            } else {
                $j = $i;
            }
            $username = [
                [
                    'username'  => 'KPU' . $j,
                    'password'  => Hash::make('password'),
                    'kota_kab'  => '-',
                    'kecamatan' => '-',
                    'kelurahan' => '-',
                    'role' => '01'
                ]
            ];
            User::create($username[0]);
        }
    }
}
