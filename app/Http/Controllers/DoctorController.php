<?php

namespace App\Http\Controllers;

use App\DataTables\DoctorDataTable;
use App\Models\Doctor;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\DoctorRequest;
use Illuminate\Support\Facades\Log;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(DoctorDataTable $dataTable)
    {
        if (! Gate::allows('doctor-index')) {
            abort(403);
        }
        return $dataTable->render('doctor.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (! Gate::allows('doctor-create')) {
            abort(403);
        }
        $doctor = new Doctor();
        return view('doctor.action', ['doctor' => new $doctor]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DoctorRequest $doctorRequest)
    {
        $register = new Doctor();
        $register->name = $doctorRequest->input('name');
        $register->lastname = $doctorRequest->input('lastname');
        $register->specialty = $doctorRequest->input('specialty');
        $register->type_document = $doctorRequest->input('type_document');
        $register->document = $doctorRequest->input('document');
        $register->phone = $doctorRequest->input('phone');
        $register->email = $doctorRequest->input('email');
        $register->address = $doctorRequest->input('address');
        $register->save();
        return response()->json([
            'status' => 'success',
            'message' => __('Doctor registrado exitosamente')
        ]);

    }

    /**
     * Display the specified resource.
     */
    public function show(Doctor $doctor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if (! Gate::allows('doctor-edit')) {
            abort(403);
        }
        $doctor = Doctor::findOrFail($id);
        return view('doctor.action', compact('doctor'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(DoctorRequest $doctorRequest, $id)
    {
        
        $register = Doctor::findOrFail($id);
        $register->name = $doctorRequest->input('name');
        $register->lastname = $doctorRequest->input('lastname');
        $register->specialty = $doctorRequest->input('specialty');
        $register->type_document = $doctorRequest->input('type_document');
        $register->document = $doctorRequest->input('document');
        $register->phone = $doctorRequest->input('phone');
        $register->email = $doctorRequest->input('email');
        $register->address = $doctorRequest->input('address');
        $register->save();
        return response()->json([
            'status' => "success",
            'message' => __('Doctor actualizado exitosamente')
        ]);
        
    }

    public function destroy($id)
    {
        if (! Gate::allows('doctor-delete')) {
            abort(403);
        }
        $register = Doctor::find($id);
        $register->delete();
        return response()->json([
            'status' => 'success',
            'message' => $register->name . ' Eliminado exitosamente'
            ]
        );
    }
}
