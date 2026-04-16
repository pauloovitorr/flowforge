<?php

namespace App\Http\Controllers\Service;

use App\Models\Email;
use Exception;
use Illuminate\Support\Facades\Auth;

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

    public static function updateEmail($id, array $data)
    {
        try {

            $email = Email::where('id', $id)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            $email->update($data);

        } catch (Exception $e) {

            throw $e;
        }
    }
}
