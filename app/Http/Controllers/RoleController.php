<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class RoleController extends BaseController
{
    public function index()
    {
        $roles = Role::withCount('users')->orderBy('name')->get();
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        return view('admin.roles.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:roles,name',
        ]);

        try {
            DB::transaction(function () use ($request) {
                Role::create([
                    'name' => $request->name,
                ]);
            });

            return redirect()
                ->route('roles.index')
                ->with('success', 'Role created successfully.');

        } catch (Throwable $e) {
            return back()
                ->withInput()
                ->with('error', 'Failed to create role.');
        }
    }

    public function edit(Role $role)
    {
        return view('admin.roles.form', compact('role'));
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:roles,name,' . $role->id,
        ]);

        // ❌ Protect Admin role
        if ($role->name === 'Admin') {
            return back()->with('error', 'The Admin role cannot be modified.');
        }

        try {
            DB::transaction(function () use ($request, $role) {
                $role->update(['name' => $request->name]);
            });

            return redirect()
                ->route('roles.index')
                ->with('success', 'Role updated successfully.');

        } catch (Throwable $e) {
            return back()->with('error', 'Failed to update role.');
        }
    }

    public function destroy(Role $role)
    {
        // ❌ Protect Admin role
        if ($role->name === 'Admin') {
            return back()->with('error', 'The Admin role cannot be deleted.');
        }

        if ($role->users()->count() > 0) {
            return back()->with('error', 'Role is assigned to users.');
        }

        $role->delete();

        return redirect()
            ->route('roles.index')
            ->with('success', 'Role deleted successfully.');
    }
}
