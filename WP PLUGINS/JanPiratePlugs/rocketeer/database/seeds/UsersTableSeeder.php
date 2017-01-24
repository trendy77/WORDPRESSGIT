<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'username'              =>  'admin',
            'email'                 =>  'admin@admin.com',
            'password'              =>  bcrypt('admin'),
            'upl_dir'               =>  'a/1/admin',
            'status'                =>  1,
            'isAdmin'               =>  2,
            'display_name'          =>  'admin',
            'autoapprove'           =>  2,
            'email_confirmed'       =>  2,
            'created_at'            =>  \Carbon\Carbon::now(),
            'updated_at'            =>  \Carbon\Carbon::now()
        ]);
    }
}
