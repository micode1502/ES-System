<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\DataTables\AppointmentDataTable;
use App\Http\Requests\AppointmentRequest;
use App\Models\Availability;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class AppointmentController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(AppointmentDataTable $dataTable)
    {
        if (! Gate::allows('appointment-index')) {
            abort(403);
        }
        return $dataTable->render('appointment.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (! Gate::allows('appointment-create')) {
            abort(403);
        }
        $patients = Patient::all();
        $doctors = Doctor::all();
        $appointment = new Appointment();
        return view('appointment.action', compact('patients', 'doctors', 'appointment'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AppointmentRequest $request)
    {
        $doctorId = $request->input('doctor');
        $doctor = Doctor::getNameById($doctorId);
        $date = $request->input('date');
        $startTime = $request->input('start');

        // Convertir el startTime en un formato de 24 horas
        $startTime = date('H:i:s', strtotime($startTime));

        if (!$this->isDoctorAvailable($doctorId, $date, $startTime)) {
            return response()->json([
                'status' => 'error',
                'message' => __('Doctor not available at the selected time')
            ]);
        }

        try {
            $record = new Appointment();
            $record->patient_id = $request->input('patient');
            $record->doctor = $doctor;
            $record->date = $date;
            $record->start = $startTime;
            
            $record->save();
            return response()->json([
                'status' => 'success',
                'message' => __('Appointment created successfully')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => __('Appointment creation failed')
            ]);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if (! Gate::allows('appointment-edit')) {
            abort(403);
        }
        $appointment = Appointment::find($id);
        $patients = Patient::all();
        $doctors = Doctor::all();
        return view('appointment.action', compact('appointment', 'patients', 'doctors'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Appointment $appointment)
    {
        $doctorId = $request->input('doctor');
        $doctor = Doctor::getNameById($doctorId);
        $date = $request->input('date');
        $startTime = $request->input('start');

        // Convertir el startTime en un formato de 24 horas
        $startTime = date('H:i:s', strtotime($startTime));

        // Verificar si el doctor está disponible en la nueva fecha y hora, excluyendo la cita actual
        if (!$this->isDoctorAvailableForUpdate($doctorId, $date, $startTime, $appointment->id)) {
            return response()->json([
                'status' => 'error',
                'message' => __('Doctor not available at the selected time')
            ]);
        }

        try {
            $record = new Appointment();
            $record->patient_id = $request->input('patient');
            $record->doctor = $doctor;
            $record->date = $date;
            $record->start = $startTime;
            return response()->json([
                'status' => 'success',
                'message' => __('Appointment updated successfully')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => __('Appointment update failed')
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (! Gate::allows('appointment-delete')) {
            abort(403);
        }
        try {
            Appointment::destroy($id);
            return response()->json([
                'status' => 'success',
                'message' => __('Appointment deleted successfully')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => __('Appointment deletion failed')
            ]);
        }
    }

    private function isDoctorAvailable($doctorId, $date, $startTime)
    {
        $doctor = Doctor::getNameById($doctorId);
        $dayOfWeek = date('N', strtotime($date));
        $startHour = date('H', strtotime($startTime));

        $availability = Availability::where('doctor_id', $doctorId)
                                    ->where('day', $dayOfWeek)
                                    ->get();

        foreach ($availability as $slot) {
            $slotStartHour = $slot->hour_start;
            $slotEndHour = $slotStartHour + $slot->duration;

            if ($startHour >= $slotStartHour && $startHour < $slotEndHour) {
                $appointmentStartTime = date('H:i:s', strtotime($startTime));
                $appointmentEndTime = date('H:i:s', strtotime("+1 hour", strtotime($startTime)));

                /* $overlappingAppointments = Appointment::where('doctor_id', $doctorId) */
                $overlappingAppointments = Appointment::where('doctor', $doctor)
                                                    ->where('date', $date)
                                                    ->where(function($query) use ($appointmentStartTime, $appointmentEndTime) {
                                                        $query->whereBetween('start', [$appointmentStartTime, $appointmentEndTime])
                                                        ->orWhereRaw('? BETWEEN start AND DATE_SUB(DATE_ADD(start, INTERVAL 1 HOUR), INTERVAL 1 MINUTE)', [$appointmentStartTime])
                                                        ->orWhereRaw('? BETWEEN start AND DATE_SUB(DATE_ADD(start, INTERVAL 1 HOUR), INTERVAL 1 MINUTE)', [$appointmentEndTime]);
                                                    })
                                                    ->count();

                if ($overlappingAppointments == 0) {
                    return true;
                }
            }
        }

        return false;
    }
    private function isDoctorAvailableForUpdate($doctorId, $date, $startTime, $appointmentId)
    {
        $doctor = Doctor::getNameById($doctorId);
        $dayOfWeek = date('N', strtotime($date));
        $startHour = date('H', strtotime($startTime));

        $availability = Availability::where('doctor_id', $doctorId)
                                    ->where('day', $dayOfWeek)
                                    ->get();

        foreach ($availability as $slot) {
            $slotStartHour = $slot->hour_start;
            $slotEndHour = $slotStartHour + $slot->duration;

            if ($startHour >= $slotStartHour && $startHour < $slotEndHour) {
                $appointmentStartTime = date('H:i:s', strtotime($startTime));
                $appointmentEndTime = date('H:i:s', strtotime("+1 hour", strtotime($startTime)));

                /* $overlappingAppointments = Appointment::where('doctor_id', $doctorId) */
                $overlappingAppointments = Appointment::where('doctor', $doctor)
                                                    ->where('date', $date)
                                                    ->where('id', '!=', $appointmentId)
                                                    ->where(function($query) use ($appointmentStartTime, $appointmentEndTime) {
                                                        $query->whereBetween('start', [$appointmentStartTime, $appointmentEndTime])
                                                        ->orWhereRaw('? BETWEEN start AND DATE_SUB(DATE_ADD(start, INTERVAL 1 HOUR), INTERVAL 1 MINUTE)', [$appointmentStartTime])
                                                        ->orWhereRaw('? BETWEEN start AND DATE_SUB(DATE_ADD(start, INTERVAL 1 HOUR), INTERVAL 1 MINUTE)', [$appointmentEndTime]);
                                                    })
                                                    ->count();

                if ($overlappingAppointments == 0) {
                    return true;
                }
            }
        }

        return false;
    }
}
