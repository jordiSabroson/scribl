<?php

namespace App\Http\Controllers;

use App\Mail\RecoverPassword;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

use Illuminate\Auth\Events\PasswordReset;

use App\Models\User;
use Exception;

class UserController extends Controller
{
    /* --------- GET METHODS --------- */

    function show_register()
    {
        return view('access/register');
    }

    function show_login()
    {
        return view('access/login');
    }

    function show_recover()
    {
        return view('access/recover');
    }

    function show_reset_password($token)
    {
        return view('access/reset-password')->with($token);
    }

    function show_edit()
    {
        $user = Auth::user();
        return view('user/main')->with('user', $user);
    }

    /* --------- POST METHODS --------- */
    function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'min:5'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $token = $user->createToken('API Token')->accessToken;

        return response()->json(['state' => 200, 'message' => 'User registered successfully']);
    }

    function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email',  $request->email)->first();

        if (Auth::attempt($credentials)) {
            $user->tokens()->delete();
            $request->session()->regenerate();
            return response()->json(['state' => 200, 'message' => 'User logged in successfully']);
            // 'name' => $user->name, 'token' => $user->createToken('auth_token')->plainTextToken]);
        } else {
            return response()->json(['state' => 422, 'message' => 'Credentials are incorrect']);
        }
    }

    function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return redirect()->route('login');
        // return response()->json(['state' => 200, 'message' => 'User logged out successfully']);
    }

    function recover(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $mailData = [
            'title', 'Recover your Scribl password',
            'token', 'hola'
        ];

        $status = Password::sendResetLink(
            $request->only('email')
        );

        // // $userMail = $request->only('email');
        // $userMail = "jmanya@apiabalit.com";

        // try {
        //     Mail::to($userMail)->send(new RecoverPassword($mailData));
        //     return response()->json(['state' => 200, 'message' => 'Check your inbox']);
        // } catch (Exception $e) {
        //     return response()->json(['state' => 404, 'message' => $e]);
        // }
        // $status = Password::sendResetLink(
        //     $request->only('email')
        // );
        return $status === Password::RESET_LINK_SENT
            ? response()->json(['state' => 200, 'message' => $status])
            : response()->json(['state' => 404, 'message' => $status]);
    }

    function reset_password(Request $request)
    {
        $request->validate([
            'token' => ['required'],
            'password' => ['required', 'string', 'min:5', 'confirmed'],
        ]);

        $status = Password::reset(
            $request->only('password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? response()->json(['state' => 200, 'message' => $status])
            : response()->json(['state' => 404, 'message' => $status]);
    }

    function edit_user(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
        ]);

        $user = User::find($id);

        $user->update([
            'name' => $request->name,
            'surname' => $request->surname,
            'email' => $request->email
        ]);

        return response()->json(['state' => 200, 'message' => 'user info updated successfully']);
    }

    function change_password(Request $request)
    {
        $request->validate([
            'old_password' => ['required', 'string'],
            'new_password' => ['required', 'string', 'min:5', 'confirmed']
        ]);

        $auth = Auth::user();

        if (!Hash::check($request->get('old_password'), $auth->password)) {
            return response()->json(['state' => 422, 'message' => 'Your current password is not correct']);
        }

        if (strcmp($request->get('old_password'), $request->new_password) == 0) {
            return response()->json(['state' => 422, 'message' => 'Your new password cannot be the same as your current one']);
        }

        $user =  User::find($auth->id);
        $user->password =  Hash::make($request->new_password);
        $user->save();
        return response()->json(['state' => 200, 'message' => 'Password updated successfully']);
    }
}