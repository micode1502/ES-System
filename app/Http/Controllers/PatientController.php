<?php

namespace App\Http\Controllers;

use App\DataTables\PatientDataTable;
use App\Http\Requests\PatientRequest;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class PatientController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(PatientDataTable $dataTable)
    {
        if (! Gate::allows('patient-index')) {
            abort(403);
        }
        return $dataTable->render('patient.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (! Gate::allows('patient-create')) {
            abort(403);
        }
        $patient = new Patient();
        return view('patient.action', ['patient' => new $patient]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PatientRequest $request)
    {
        $register = new Patient();
        $register->name = $request->input('name');
        $register->lastname = $request->input('lastname');
        $register->email = $request->input('email');
        $register->phone = $request->input('phone');
        $register->type_document = $request->input('documentType');
        $register->document = $request->input('documentNumber');
        $register->date_birth = $request->input('birthdate');
        $register->gender = $request->input('gender');
        $register->status = $request->input('status');
        $register->address = $request->input('address');
        $register->save();
        return response()->json([
            'status' => 'success',
            'message' => __('Patient successfully registered')
            ]
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Patient $patient)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if (! Gate::allows('patient-edit')) {
            abort(403);
        }
        $patient = Patient::findOrFail($id);
        return view('patient.action', compact('patient'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PatientRequest $request,string $id)
    {
        $register = Patient::findOrFail($id);
        Log::info($request->all());
        $register->name = $request->input('name');
        $register->lastname = $request->input('lastname');
        $register->email = $request->input('email');
        $register->phone = $request->input('phone');
        $register->type_document = $request->input('documentType');
        $register->document = $request->input('documentNumber');
        $register->date_birth = $request->input('birthdate');
        $register->gender = $request->input('gender');
        $register->status = $request->input('status');
        $register->address = $request->input('address');
        $register->save();
        return response()->json([
            'status' => 'success',
            'message' => __('Patient successfully updated')
            ]
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (! Gate::allows('patient-delete')) {
            abort(403);
        }
        $register = Patient::find($id);
        $register->delete();
        return response()->json([
            'status' => 'success',
            'message' => $register->name . ' eliminado exitosamente'
            ]
        );
    }
}
