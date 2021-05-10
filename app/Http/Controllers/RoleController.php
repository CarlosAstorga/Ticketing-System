<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_unless(Gate::allows('role_access'), 403, 'Acción no autorizada');
        return view('roles.index', ['module' => 'roles']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_unless(Gate::allows('role_create'), 403, 'Acción no autorizada');
        return view('roles.form', [
            'module'        => 'roles',
            'role'          => new Role(),
            'modules'       => Module::whereHas('permissions')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort_unless(Gate::allows('role_create'), 403, 'Acción no autorizada');
        $role = Role::create($request->validate([
            'title'         => 'required|max:100',
        ]));
        $role->permissions()->sync($request->permissions);
        return redirect('roles');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        abort_unless(Gate::allows('role_edit') && $role->id != 1, 403, 'Acción no autorizada');
        return view('roles.form', [
            'module'        => 'roles',
            'role'          => $role,
            'modules'       => Module::whereHas('permissions')->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        abort_unless(Gate::allows('role_edit'), 403, 'Acción no autorizada');
        $role->update($request->validate([
            'title'         => 'required|max:100',
        ]));
        $role->permissions()->sync($request->permissions);
        return redirect('roles');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        abort_unless(Gate::allows('role_delete'), 403, 'Acción no autorizada');
        $role->permissions()->detach();
        $role->delete();
    }

    public function list(Request $request)
    {
        $filter = $request->input('filter', null);

        $roles = Role::query();
        $roles = $filter ?
            $roles->where(function ($query) use ($filter) {
                $query->where('title', 'LIKE', '%' . $filter . '%')
                    ->orWhereHas('permissions', function ($relation) use ($filter) {
                        $relation->where('title', 'LIKE', '%' . $filter . '%');
                    });
            }) : $roles;

        $roles = $roles->orderBy('id', 'DESC');
        $paginator = $roles->paginate(10);
        return $paginator;
    }
}
