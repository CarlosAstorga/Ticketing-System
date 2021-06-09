<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use App\Actions\Fortify\CreateNewUser;
use App\Models\Permission;
use Illuminate\Support\Facades\Password;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_unless(Gate::allows('user_access'), 403, 'Acción no autorizada');
        return view('users.index', ['module' => 'users']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_unless(Gate::allows('user_create'), 403, 'Acción no autorizada');
        return view('users.form', [
            'module'    => 'users',
            'user'      => new User(),
            'roles'     => Role::get()
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
        abort_unless(Gate::allows('user_create'), 403, 'Acción no autorizada');
        $user = new CreateNewUser();
        $user = $user->create($request->only(
                ['name', 'email', 'password', 'password_confirmation']
            )
        );
        $user->roles()->sync($request->roles);
        $user->sendEmailVerificationNotification();
        Password::sendResetLink($request->only(['email']));
        return redirect('admin/users');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        abort_unless(Gate::allows('user_edit'), 403, 'Acción no autorizada');
        return view('users.form', [
            'module'    => 'users',
            'user'      => $user,
            'roles'     => Role::get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        abort_unless(Gate::allows('user_edit'), 403, 'Acción no autorizada');
        $user->update($request->validate([
            'name'      => 'required|max:100',
            'email'     => 'required|'
        ]));
        $user->roles()->sync($request->roles);
        if($request->user()->hasPermission('user_access')) return redirect('admin/users');
        return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        abort_unless(Gate::allows('user_delete'), 403, 'Acción no autorizada');
        $user->roles()->detach();
        $user->assignedTickets()->update(['developer_id' => null]);
        $user->submittedTickets()->update(['submitter_id' => null]);
        $user->delete();
    }

    public function list(Request $request)
    {
        $filter = $request->input('filter', null);

        $users = User::query();
        $users = $filter ?
            $users->where(function ($query) use ($filter) {
                $query->where('name', 'LIKE', '%' . $filter . '%')
                    ->orWhere('email', 'LIKE', '%' . $filter . '%')
                    ->orWhereHas('roles', function ($relation) use ($filter) {
                        $relation->where('name', 'LIKE', '%' . $filter . '%');
                    });
            }) : $users;

        $users = $users->orderBy('id', 'DESC');
        $paginator = $users->paginate(10);
        return $paginator;
    }

    public function permissions() {
        $user = User::find(auth()->id());
        $permissions = Permission::get();
        foreach ($permissions as $p) {
            $permission[$p->title] = $user->hasPermission($p->title);
        }

        return $permission;
    }
}
