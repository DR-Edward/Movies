<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The validation rules.
     *
     * @var array
     */
    public static $rules_make_token = [
        'email'       => 'required|string|email',
        'password'    => 'required|string',
    ];

    /**
     * @param Request $request
     * Make token
     * @return string
    */
    public static function create_token($request) {
        // $request->validate(User::$rules_make_token);

        if(!Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            return response()->json([
                'message_type' => 'error',
                'message_text' => 'Incorrect user or password',
            ], 401);
        }

        $user = Auth::user();
        $credentials = $user->createToken('Access from API client');

        return [
            'user' => $user,
            'credentials' => $credentials
        ];
    }

    /**
     * @param Request $request
     * Revoke Token
     * @return string
    */
    public static function revoke_token($request) {
        $request->user()->token()->revoke();
        
        return [
            'message_type' => 'success',
            'message_text' => 'See you later',
        ];
    }
}
