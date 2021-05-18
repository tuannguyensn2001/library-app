<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
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
        $user = new User();
        $user->name = 'admin';
        $user->email = 'admin@gmail.com';
        $user->password = Hash::make('123456');
        $user->avatar = 'https://www.lewesac.co.uk/wp-content/uploads/2017/12/default-avatar.jpg';
        $user->is_admin=1;
        $user->save();

        $user = new User();
        $user->name = 'admin1';
        $user->email = 'admin1@hus.edu.vn';
        $user->password = Hash::make('123456');
        $user->avatar = 'https://www.lewesac.co.uk/wp-content/uploads/2017/12/default-avatar.jpg';
        $user->is_admin=1;
        $user->save();
    }
}
