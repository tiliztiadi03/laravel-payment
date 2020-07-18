<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Payment;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Payment::unguard();
        Payment::truncate();
        factory(Payment::class, 10)->create();
        Payment::reguard();
    }
}
