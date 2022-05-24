<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->first_name = "Super";
        $user->last_name = "Admin";
        $user->email = "superadmin@gmail.com";
        $user->password = Hash::make('admin@123');
        $user->user_type = 'Admin';
        $user->is_active = 'Yes';
        $user->save();
    }
}
