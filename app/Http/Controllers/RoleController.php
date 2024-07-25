<?php

namespace App\Http\Controllers;

use App\DataTables\RoleDataTable;
use App\Http\Requests\RoleRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(RoleDataTable $roleDataTable)
    {
        if (! Gate::allows('role-index')) {
            abort(403);
        }
        return $roleDataTable->render('role.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (! Gate::allows('role-create')) {
            abort(403);
        }
        $role = new Role();
        $permissions = Permission::all();
        return view('role.action', ['role' => new $role, 'permissions' => $permissions]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleRequest $roleRequest)
    {
        $register = new Role();
        $register->name = $roleRequest->input('name');
        $register->save();
        return response()->json([
            'status' => 'success',
            'message' => 'Role creado correctamente'
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
        if (! Gate::allows('role-edit')) {
            abort(403);
        }
        $role = Role::findOrFail($id);
        $permissions = Permission::all();
        return view('role.action',['role' => $role, 'permissions' => $permissions]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleRequest $roleRequest, string $id)
    {
        $register = Role::findOrFail($id);
        $register->name = $roleRequest->input('name');
        $register->save();

        $permissions = $roleRequest->input('selected_permissions', []); 
        $register->syncPermissions($permissions);

        return response()->json([
            'status' => 'success',
            'message' => 'Role actualizado correctamente'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (! Gate::allows('role-delete')) {
            abort(403);
        }
        $register = Role::find($id);
        $register->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Role eliminado correctamente'
            ]
        );
    }
}
