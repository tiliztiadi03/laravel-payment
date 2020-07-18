<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Payment;

class PaymentTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    /**
     * Test data payments.
     *
     * @return void
     */
    public function testPayments()
    {
        $payment = factory(Payment::class, 10)->create();

        $response = $this->get('payments', $payment->toArray());

        $response->assertStatus(200);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCreatePayments()
    {
        $response = $this->post('payments', [
            'name' => $this->faker->name, // required validation
            'email' => $this->faker->safeEmail // required validation
        ]);

        // expected response code 200
        $response->assertStatus(201);
    }

    public function testUpdatePayments()
    {
        // make data dummy
        factory(Payment::class, 10)->create();
        
        // find data where id = 1 to updated
        $payment = Payment::find(1);
        $payment->name = 'Updated asdfsd';
        $payment->email = 'updatedemail@mail.com';

        $response = $this->put('/payments/'.$payment->id, [
            'name' => $this->faker->name, // required validation
            'email' => $this->faker->safeEmail // required validation
        ]);

        
        // Payment should be updated in the database.
        $this->assertDatabaseHas('payments', ['id' => $payment->id]);
        
        // expected response code 200
        $response->assertStatus(200);
    }

    public function testDeletePayments()
    {
        // make data dummy
        factory(Payment::class, 10)->create();
        
        // find data where id = 1 to deleted
        $payment = Payment::find(1);
        $payment->delete();

        $response = $this->delete('/payments/'.$payment->id);

        $this->delete('/payments/'.$payment->id);
        
        // Expected payment deleted from database
        $this->assertDatabaseMissing('payments', ['id' => $payment->id]);
    }

}
