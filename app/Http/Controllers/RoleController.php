<?php

namespace App\Http\Controllers;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class RoleController extends Controller
{
    public function index()
{

    $this->authorize('index', role::class);
    $roles = Role::all();
    return view('roles.index', compact('roles'));
}
public function create()
{
    $this->authorize('create', role::class);
    return view('roles.create');
}
public function store(Request $request)
{
    $this->authorize('store', role::class);
    // Validation logic here
    Role::create($request->all());
    return redirect()->route('roles.index');
    // Redirect or display success message
}
public function edit(Role $role)
{
    $this->authorize('edit', $role);
    return view('roles.edit', compact('role'));
}
public function update(Request $request, Role $role)
{
    // Validation logic here
    $this->authorize('update', $role);
    $role->update($request->all());
    return redirect()->route('roles.index');
    // Redirect or display success message
}
public function destroy(Role $role)
{
    $this->authorize('destroy', $role);
    $role->delete();
    return redirect()->route('roles.index');

    // Redirect or display success message
}
}
