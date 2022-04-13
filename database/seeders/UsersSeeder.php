<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = 'Alejandro Salgado';
        $user->email = 'alejandrosram@outlook.com';
        $user->password = bcrypt('1234567890');
        $user->save();
    }
}
