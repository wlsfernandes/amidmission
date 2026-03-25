<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Services\SystemLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Throwable;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        try {
            DB::transaction(function () use ($request) {

                $user = $request->user();

                $user->fill($request->validated());

                // If email changed, require re-verification
                if ($user->isDirty('email')) {
                    $user->email_verified_at = null;
                }

                $user->save();
            });

            SystemLogger::log(
                'Profile updated',
                'info',
                'profile.update',
                ['user_id' => $request->user()->id]
            );

            return Redirect::route('profile.edit')
                ->with('success', 'Your profile has been updated successfully.');

        } catch (Throwable $e) {

            SystemLogger::log(
                'Profile update failed',
                'error',
                'profile.update',
                [
                    'user_id' => $request->user()->id,
                    'exception' => $e->getMessage(),
                ]
            );

            return Redirect::back()
                ->withInput()
                ->with('error', 'An error occurred while updating your profile.');
        }
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        try {
            DB::transaction(function () use ($request) {

                $user = $request->user();

                SystemLogger::log(
                    'User deleted own account',
                    'warning',
                    'profile.destroy',
                    ['user_id' => $user->id]
                );

                Auth::logout();

                $user->delete();
            });

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return Redirect::to('/')
                ->with('success', 'Your account has been deleted.');

        } catch (Throwable $e) {

            SystemLogger::log(
                'Profile deletion failed',
                'critical',
                'profile.destroy',
                [
                    'user_id' => $request->user()->id,
                    'exception' => $e->getMessage(),
                ]
            );

            return Redirect::route('profile.edit')
                ->with('error', 'Unable to delete your account. Please contact support.');
        }
    }
}
