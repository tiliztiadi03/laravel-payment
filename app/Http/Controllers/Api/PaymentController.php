<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\PaymentRequest;
use App\Notifications\PaymentStatus;
use App\Payment;
use Notification;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['payments'] = Payment::paginate(10);

        return response()->json($data, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PaymentRequest $request)
    {
        $data['payment'] = Payment::create([
            'name' => $request->name,
            'email' => $request->email,
            'is_active' => 0
        ]);

        return response()->json(['message' => 'success'], 201);
    }

    /**
     *  Show a data of the resource
     * 
     *  @param int $id
     *  @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $payment = Payment::where('id', $id)->get()->toArray();

        if (empty($payment)) {
            return response()->json(['message' => 'error'], 404);    
        }

        return response()->json([
            'message' => 'success',
            'data' => $payment
        ], 200);
    }
     
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PaymentRequest $request, $id)
    {
        $payment = Payment::find($id);

        if (is_null($payment)) {
            return response()->json(['message' => 'error update'], 404);    
        }

        $payment->update($request->all());

        return response()->json(['message' => 'success update'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $payment = Payment::find($id);

        if (is_null($payment)) {
            return response()->json(['message' => 'error'], 404);    
        }
        
        $payment->delete();

        return response()->json(['message' => 'success'], 200);
    }

    /**
     * Activate user payment.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */ 
    public function activate($id)
    {
        try {
            DB::beginTransaction();

            $payment = Payment::find($id);
            $payment->is_active = 1;
            $payment->save();

            Notification::route('mail', $payment->email)
                        ->notify(new PaymentStatus($payment));

            DB::commit();
            return response()->json(['message' => 'activation payment success'], 200);
        } catch (\Exception $e) {
            logger($e->getMessage()); // record error to log

            DB::rollBack(); // rollback update data
            return response()->json(['message' => 'activation payment failed'], 500);
        }

    }

    /**
     * Deactive user payment.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */ 
    public function deactivate($id)
    {
        try {
            DB::beginTransaction();

            $payment = Payment::find($id);
            $payment->is_active = 0;
            $payment->save();

            Notification::route('mail', $payment->email)
                        ->notify(new PaymentStatus($payment));

            DB::commit();
            return response()->json(['message' => 'deactivation payment success'], 200);
        } catch (\Exception $e) {
            logger($e->getMessage()); // record error to log

            DB::rollBack(); // rollback update data
            return response()->json(['message' => 'deactivation payment failed'], 500);
        }

    }
}
