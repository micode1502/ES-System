<?php

namespace App\Http\Controllers;

use App\DataTables\UserDataTable;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(UserDataTable $userDataTable)
    {
        if (!Gate::allows('user-index')) {
            abort(403);
        }
        return $userDataTable->render('user.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!Gate::allows('user-create')) {
            abort(403);
        }
        $user = new User();
        $roles = Role::all();
        return view('user.action', ['user' => $user, 'roles' => $roles]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $userRequest)
    {
        $register = new User();
        $register->name = $userRequest->input('name');
        $register->lastname = $userRequest->input('lastname');
        $register->username = $this->generateUsername($register->name, $register->lastname);
        $register->email = $userRequest->input('email');
        $register->password = $userRequest->input('password');
        $register->assignRole($userRequest->input('role'));
        $register->save();
        return response()->json([
            'status' => 'success',
            'message' => __('Usuario registrado correctamente')
            ]
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (!Gate::allows('user-edit')) {
            abort(403);
        }
        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('user.action', ['user' => $user, 'roles' => $roles]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $userRequest, string $id)
    {
        $register = User::findOrFail($id);
        $register->name = $userRequest->input('name');
        $register->lastname = $userRequest->input('lastname');
        $register->username = $this->generateUsername($register->name, $register->lastname);
        $register->email = $userRequest->input('email');
        $password = $userRequest->input('password');
        if (!empty($password)) {
            $register->password = $password;
        }
        $register->assignRole($userRequest->input('role'));
        $register->save();
        return response()->json([
            'status' => 'success',
            'message' => __('Usuario actualizado correctamente')
            ]
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (!Gate::allows('user-delete')) {
            abort(403);
        }
        $register = User::find($id);
        $register->delete();
        return response()->json(
            [
                'status' => 'success',
                'message' => __($register->username . ' eliminado exitosamente')
            ]
        );
    }

    /**
     * Generate username 
     */
    private function generateUsername($name, $lastname)
    {
        $lastnameArray = explode(' ', $lastname);
        $paternalSurname = $lastnameArray[0];
        $maternalSurname = isset($lastnameArray[1]) ? $lastnameArray[1] : '';

        $nameComplete = explode(' ', $name);
        $firstName = $nameComplete[0];
        $secondName = isset($nameComplete[1]) ? $nameComplete[1] : '';

        $username = substr($paternalSurname, 0, 1) . $maternalSurname . $firstName;
        if ($secondName) {
            $username .= substr($secondName, 0, 3);
        }
        return $username;
    }
}
