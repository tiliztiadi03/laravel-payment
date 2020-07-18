<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Custom namespace
use Illuminate\Support\Facades\DB;
use App\Http\Requests\PaymentRequest;
use App\Payment;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['payments'] = Payment::paginate(5);

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
            return response()->json(['message' => 'error'], 404);    
        }

        $payment->update($request->all());

        return response()->json(['message' => 'success'], 200);
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
    public function active($id)
    {
        $payment = Payment::findOrFail($id);

        $data['message'] = 'activated success';

        return rseponse()->json($data, 200);
    }
}
