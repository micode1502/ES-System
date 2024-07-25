<?php

namespace App\Http\Controllers;
use App\DataTables\AvailabilityDataTable;
use App\Http\Requests\AvailabilityRequest;
use App\Models\Availability;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AvailabilityController extends Controller
{
    public function index(AvailabilityDataTable $availabilityDataTable) {
        if (! Gate::allows('availability-index')) {
           abort(403);
        }
        return $availabilityDataTable->render('availability.index');   
    }

    public function create()
    {
        if (! Gate::allows('availability-create')) {
           abort(403);
        }
        $doctors = Doctor::all();
        $availability = new Availability();
        return view('availability.action', compact('doctors', 'availability'));
    }

    public function store(AvailabilityRequest $availabilityRequest)
    {   
        $register = new Availability();
        $register->doctor_id = $availabilityRequest->input('doctor_id');
        $register->day = $availabilityRequest->input('day');
        $register->hour_start = $availabilityRequest->input('hour_start');
        $register->duration = $availabilityRequest->input('duration');
        $register->save();
        return response()->json([
            'status' => 'success',
            'message' => __('Disponibilidad registrada exitosamente')
            ]
        );
    }

    public function show(Availability $availability)
    {
        //
    }

    public function edit($id)
    {
        if (! Gate::allows('availability-edit')) {
            abort(403);
        }
        $availability = Availability::findOrFail($id);
        $doctors = Doctor::all();
        return view('availability.action', compact('availability','doctors'));
    }

    public function update(AvailabilityRequest $availabilityRequest, $id)
    {
        $register = Availability::findOrFail($id);
        $register->doctor_id = $availabilityRequest->input('doctor_id');
        $register->day = $availabilityRequest->input('day');
        $register->hour_start = $availabilityRequest->input('hour_start');
        $register->duration = $availabilityRequest->input('duration');
        $register->save();
        return response()->json([
            'status' => 'success',
            'message' => __('Disponibilidad actualizada exitosamente')
            ]
        );
    }

    public function destroy($id)
    {
        if (! Gate::allows('availability-delete')) {
            abort(403);
        }
        $register = Availability::find($id);
        $register->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Eliminado exitosamente'
            ]
        );
    }
}
