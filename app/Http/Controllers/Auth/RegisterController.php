<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $user = $this->create($request->all());

        $this->guard()->login($user);

        return redirect($this->redirectPath());
    }


    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => [
                'required',
                'string',
                'min:8',               // Minimum length of 8 characters
                'regex:/[a-z]/',        // Must contain at least one lowercase letter
                'regex:/[A-Z]/',        // Must contain at least one uppercase letter
                'regex:/[0-9]/',        // Must contain at least one number
                'regex:/[@$!%*#?&]/',   // Must contain a special character
                'confirmed'             // Ensures password confirmation matches
            ],
            'address' => ['nullable', 'string', 'max:255'],
        ], [
            // Custom error messages for password requirements
            'password.min' => 'Password must be at least 8 characters.',
            'password.regex' => 'Password must include at least one lowercase letter, one uppercase letter, one number, and one special character.',
            'password.confirmed' => 'Password confirmation does not match.',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'address' => $data['address'],
            'role' => $data['role'],
        ]);
    }
    
    /**
     * Show the registration form based on role.
     */
    public function showRegistrationForm($role)
    {
        // Ensure the role is either 'admin' or 'customer' to avoid any errors
        if (!in_array($role, ['admin', 'customer'])) {
            abort(404); // Or handle this with a redirect if you prefer
        }
        return view('auth.register', ['role' => $role]);
    }
}
