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
        $user->name = 'tuannguyensn2001';
        $user->email = 'devpro2001@gmail.com';
        $user->password = Hash::make('java2001');
        $user->is_admin=1;
        $user->save();

        $user = new User();
        $user->name = 'mistaken';
        $user->email = 'nguyenvantuan_t64@hus.edu.vn';
        $user->password = Hash::make('java2001');
        $user->is_admin=1;
        $user->save();
    }
}
