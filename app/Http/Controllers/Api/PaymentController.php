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

        return response()->json($data);
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

        $data['message'] = 'success added';

        return response()->json($data, 201);
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

        $payment->name = $request->name;
        $payment->email = $request->email;
        $payment->save();
        $data['message'] = 'success updated';

        return response()->json($data, 200);
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

        $payment->delete();
        $data['message'] = 'success deleted';

        return response()->json($data, 200);
    }

   
}
