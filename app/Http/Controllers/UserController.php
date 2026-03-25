<?php

namespace App\Http\Controllers;


use App\Models\Role;
use App\Models\User;
use App\Services\SystemLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Throwable;

class UserController extends BaseController
{
    /**
     * Display all users (DataTables handles pagination).
     */
    public function index()
    {
        $users = User::all();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Summary of create
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $roles = Role::orderBy('name')->get();
        return view('admin.users.form', compact('roles'));
    }

    /**
     * Summary of edit
     * @param User $user
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(User $user)
    {
        $roles = Role::orderBy('name')->get();
        return view('admin.users.form', compact('user', 'roles'));
    }

    /**
     * Store a new user.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'nullable|min:8',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,id',
        ]);

        try {
            DB::transaction(function () use ($request) {

                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make('admin2030'),
                ]);

                // ✅ Attach roles (if any selected)
                if ($request->filled('roles')) {
                    $user->roles()->sync($request->roles);
                }
            });

            SystemLogger::log(
                'User created',
                'info',
                'users.store',
                [
                    'email' => $request->email,
                    'roles' => $request->roles ?? [],
                ]
            );

            return redirect()
                ->route('users.index')
                ->with('success', 'User created successfully.');

        } catch (Throwable $e) {

            SystemLogger::log(
                'User creation failed',
                'error',
                'users.store',
                [
                    'exception' => $e->getMessage(),
                    'email' => $request->email,
                ]
            );

            return back()
                ->withInput()
                ->with('error', 'An error occurred while creating the user.');
        }
    }


    /**
     * Update user.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,id',
        ]);

        try {
            DB::transaction(function () use ($request, $user) {

                $data = [
                    'name' => $request->name,
                    'email' => $request->email,
                ];

                // ✅ Update password only if provided
                if ($request->filled('password')) {
                    $data['password'] = $request->password ? Hash::make($request->password) : 'admin2030';
                }

                $user->update($data);

                // ✅ Sync roles (empty array removes all roles)
                $user->roles()->sync($request->roles ?? []);
            });

            SystemLogger::log(
                'User updated',
                'info',
                'users.update',
                [
                    'user_id' => $user->id,
                    'roles' => $request->roles ?? [],
                ]
            );

            return redirect()
                ->route('users.index')
                ->with('success', 'User updated successfully.');

        } catch (Throwable $e) {

            SystemLogger::log(
                'User update failed',
                'error',
                'users.update',
                [
                    'user_id' => $user->id,
                    'exception' => $e->getMessage(),
                ]
            );

            return back()
                ->withInput()
                ->with('error', 'An error occurred while updating the user.');
        }
    }


    /**
     * Delete user.
     */
    public function destroy(User $user)
    {
        try {
            DB::transaction(function () use ($user) {
                $user->delete();
            });

            SystemLogger::log(
                'User deleted',
                'warning',
                'users.destroy',
                ['user_id' => $user->id]
            );

            return redirect()
                ->route('users.index')
                ->with('success', 'User deleted successfully.');

        } catch (Throwable $e) {

            SystemLogger::log(
                'User deletion failed',
                'critical',
                'users.destroy',
                [
                    'user_id' => $user->id,
                    'exception' => $e->getMessage(),
                ]
            );

            return back()
                ->with('error', 'Unable to delete user.');
        }
    }
}
