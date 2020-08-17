<?php
namespace App\Helpers\Auth;
use Illuminate\Support\Facades\Auth;
 
class Login {
    /**
     * The validation rules.
     *
     * @var array
     */
    public static $rules = [
        'email'       => 'required|string|email',
        'password'    => 'required|string',
    ];

    /**
     * @param Request $request
     * 
     * @return string
     */
    public static function create_token($request) {
        $request->validate(Login::$rules);

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
}