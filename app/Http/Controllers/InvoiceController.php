<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Http\Requests\InvoiceRequest;
use App\Models\Payment;
use App\Models\Patient;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Invoice $invoice)
    {
        return 'invoice.index';
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $patients = Patient::all();
        $payment = Payment::all();
        $invoice = new Invoice();
        return view('appointment.action', compact('patients', 'payments', 'invoice'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InvoiceRequest $invoicerequest)
    {
        $register = new Invoice();
        $register->payment_id = $invoicerequest->input('payment_id');
        $register->number = $invoicerequest->input('number');
        $register->date = $invoicerequest->input('date');
        $register->amount = $invoicerequest->input('amount');
        $register->status = $invoicerequest->input('status');
        $register->save();
        return response()->json([
            'status' => 'success',
            'message' => 'Factura registrado exitosamente'
            ]
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $invoice = Invoice::findOrFail($id);
        $patients = Patient::all();
        $payments = Payment::all();
        return view('invoice.action', compact('invoice','payments','patients'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(InvoiceRequest $invoicerequest,  $id)
    {
        $register = Invoice::findOrFail($id);
        $register->payment_id = $invoicerequest->input('payment_id');
        $register->number = $invoicerequest->input('number');
        $register->date = $invoicerequest->input('date');
        $register->amount = $invoicerequest->input('amount');
        $register->status = $invoicerequest->input('status');
        $register->save();
        return response()->json([
            'status' => 'success',
            'message' => 'Factura registrado exitosamente'
            ]
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $register = Invoice::find($id);
        $register->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Eliminado exitosamente'
            ]
        );
    }
}
