<?php

namespace Database\Seeders;

use Carbon\Carbon;
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
        User::insert([
            [   
                'usertype'      => 'adm',
                'firstname'     => 'Rhannel',
                'lastname'      => 'Dinlasan',
                'gender'        => 'male',
                'email'         => 'rhanneldinlasan@gmail.com',
                'password'      => Hash::make('123123123'),
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
        ]);
    }
}
