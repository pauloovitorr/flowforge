<?php

namespace App\Http\Controllers\Service;

use App\Models\Email;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class EmailService
{
    public static function addEmail(array $data)
    {

        try {
            $data['user_id'] = Auth::id();
            Email::create($data);

        } catch (Exception $e) {
            
            throw $e;
        }

    }

    // public static function updateEmail($id, array $data)
    // {
    //     try {
    //         $Email = Email::find($id);

    //         if (! empty($data['generate_key']) && $data['generate_key'] == true) {
    //             $data['api_key'] = Str::random(32);
    //         }

    //         $Email->update($data);
    //     } catch (Exception $e) {
            
    //         throw $e;
    //     }
    // }

}
