<?php

use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('users')->truncate();

      	\App\User::create([
	        'name' => 'Admin',
	        'username' => 'admin',
	        'email' => 'admin@gmail.com',
	        'password' => bcrypt('adminaksamedia')
      	]);
    }
}
