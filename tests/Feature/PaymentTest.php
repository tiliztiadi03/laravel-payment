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
        // make data dummy
        Payment::unguard();
        Payment::truncate();
        $payment = factory(Payment::class, 10)->create();
        Payment::reguard();

        $response = $this->get('payments', $payment->toArray());

        $response->assertStatus(200);
    }

    /**
     * Test create payments.
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

    /**
     * Test update payments.
     *
     * @return void
     */
    public function testUpdatePayments()
    {
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

    /**
     * Test delete payments.
     *
     * @return void
     */
    public function testDeletePayments()
    {        
        // find data where id = 1 to deleted
        $payment = Payment::find(1);
        $payment->delete();

        $response = $this->delete('/payments/'.$payment->id);

        $this->delete('/payments/'.$payment->id);
        
        // Expected payment deleted from database
        $this->assertDatabaseMissing('payments', ['id' => $payment->id]);
    }

    /**
     * Test active payments.
     *
     * @return void
     */
    public function testActivePayments()
    {
        $payment = Payment::find(1);
        $payment->is_active = 1;
        $payment->save();

        $response = $this->patch('/payments/'.$payment->id.'/active');

        // Payment is_active should be 1 where id.
        $this->assertDatabaseHas('payments', ['id' => $payment->id, 'is_active' => 1]);

        // expected response code 200
        $response->assertStatus(200);
    }

    /**
     * Test active payments.
     *
     * @return void
     */
    public function testDeactivePayments()
    {
        $payment = Payment::find(2);
        $payment->is_active = 0;
        $payment->save();

        $response = $this->patch('/payments/'.$payment->id.'/deactive');

        // Payment is_active should be 0 where id.
        $this->assertDatabaseHas('payments', ['id' => $payment->id, 'is_active' => 0]);

        // expected response code 200
        $response->assertStatus(200);
    }

}
