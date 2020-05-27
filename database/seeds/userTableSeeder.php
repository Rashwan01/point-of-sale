<?php

use App\User;
use Illuminate\Database\Seeder;

class userTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$user  = User::create([

    		"first_name"=>"Ahmed",
    		"last_name"=>"Mostafa",
    		"email"=>"ahmed@gmail.com",
    		"password"=>bcrypt("12345600"),

    	]);
    	$user->attachRole("super_admin");


    }
}
