<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected function redirectTo()
    {
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            return '/admin';
        }
        if ($user->hasRole('manager')) {
            return '/manager';
        }
        if ($user->hasRole('user')) {
            return '/user';
        }
    }

    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'team' => ['required', 'string'],
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

        $response = Http::withHeaders([
            'Authorization' => "Bearer e2c64203-f4a7-46e5-8737-1caa5f90bf43",
        ])->get('https://api.plugnpaid.com/v1/customers/list');
        $name = $response['customers'][0]['name'];
        $email = $response['customers'][0]['email'];


        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($name),
        ])->assignRole('manager');

        Team::create([
            'name' => 'Team Name',
            'user' => $name,
            'created_by' => $name,
            'user_id' => $user->id,
        ]);

        return $user;
    }
}
