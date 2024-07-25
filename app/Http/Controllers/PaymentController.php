<?php

namespace App\Http\Controllers;

use App\DataTables\PaymentDataTable;
use App\Http\Requests\PaymentRequest;
use App\Models\Payment;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Dompdf\Dompdf;
use Dompdf\Options;


class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(PaymentDataTable $paymentDataTable)
    {
        if (! Gate::allows('payment-index')) {
            abort(403);
        }
        return $paymentDataTable->render('payment.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (! Gate::allows('payment-create')) {
            abort(403);
        }
        $patients = Patient::all();
        $payment = new Payment();
        return view('payment.action', compact('patients', 'payment'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PaymentRequest $paymentRequest)
    {   
        $register = new Payment();
        $register->patient_id = $paymentRequest->input('patient_id');
        $register->city = $paymentRequest->input('city');
        $register->state = $paymentRequest->input('state');
        $register->postal_code = $paymentRequest->input('postal_code');
        $register->payment_method = $paymentRequest->input('payment_method');
        $register->amount = $paymentRequest->input('amount');
        $register->save();
        return response()->json([
            'status' => 'success',
            'message' => __('Pago registrado exitosamente')
            ]
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if (! Gate::allows('payment-edit')) {
            abort(403);
        }
        $payment = Payment::findOrFail($id);
        $patients = Patient::all();
        return view('payment.action', compact('payment','patients'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PaymentRequest $paymentRequest, $id)
    {
        $register = Payment::findOrFail($id);
        $register->patient_id = $paymentRequest->input('patient_id');
        $register->city = $paymentRequest->input('city');
        $register->state = $paymentRequest->input('state');
        $register->postal_code = $paymentRequest->input('postal_code');
        $register->payment_method = $paymentRequest->input('payment_method');
        $register->amount = $paymentRequest->input('amount');
        $register->status = 1;
        $register->save();
        return response()->json([
            'status' => 'success',
            'message' => __('Pago actualizado exitosamente')
            ]
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (! Gate::allows('payment-delete')) {
            abort(403);
        }
        $register = Payment::find($id);
        $register->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Eliminado exitosamente'
            ]
        );
    }

    public function print($id)
    {
        if (!Gate::allows('payment-print')) {
            abort(403);
        }

        $payment = Payment::findOrFail($id);
        $patient = $payment->patient;

        $html = view('payment.invoice', compact('payment', 'patient'))->render();

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return $dompdf->stream("invoice_{$id}.pdf", [
            'Attachment' => false
        ]);
    }
}
