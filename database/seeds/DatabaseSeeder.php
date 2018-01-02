<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
     public function run()
     {
         $this->call(UsersTableSeeder::class);
     }
 }
 	class UsersTableSeeder extends Seeder {
 	public function run(){
 		DB::table('users')->delete();
 		DB::table('users')->insert([
 		'username' 	=> 'admin',
 		'email' 	=> 'info@admin.com',
 		'password' 	=> bcrypt('123456'),
 		'name' 		=> 'Administrator',
 		'tel'		=> '095-3439818',
 		'level' 	=> 'admin',
 		'active'	=> 'Y',
 		'created_at' => date('Y-m-d H:i:s'),
 		'updated_at' => date('Y-m-d H:i:s')
 		]);
 	}
 }
