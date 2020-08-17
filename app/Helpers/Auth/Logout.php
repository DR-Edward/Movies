<?php
namespace App\Helpers\Auth;
 
class Logout {
    /**
     * @param Request $request
     * 
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