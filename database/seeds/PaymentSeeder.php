<?php

use Illuminate\Database\Seeder;
// Custom namespace
use Faker\Factory as Faker;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');

        for($i = 0; $i < 10; $i++){
        	// Insert data
        	DB::table('payments')->insert([
        		'name' => $faker->name,
        		'email' => $faker->email,
        		'is_active' => 1,
        	]);
        }
    }
}
