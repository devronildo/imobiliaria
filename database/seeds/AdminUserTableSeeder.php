<?php

use Illuminate\Database\Seeder;

class AdminUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Administrador',
            'email' => env('ADMIN_EMAIL'),
            'email_verified_at' => now(),
            'password' => bcrypt(env('ADMIN_PASS')),
            'remember_token' => \Illuminate\Support\Str::random(10),
            'document' => '',
            'admin' => 1
        ]);
    }
}
