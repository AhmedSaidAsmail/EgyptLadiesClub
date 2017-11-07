<?php

use Illuminate\Database\Seeder;
//use App\User;

class UserTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
//        $user           = new User();
//        $user->name     = 'Admin';
//        $user->email    = 'admin@admin.com';
//        $user->password = Hash::make('Admin');
//        $user->save();
        DB::table('users')->delete();
        $user = [
            'name' => 'admin',
            'password' => Hash::make('admin'),
            'email' => 'admin@admin.com'
        ];
        DB::table('users')->insert($user);
    }

}
