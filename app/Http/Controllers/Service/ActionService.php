<?php

namespace App\Http\Controllers\Service;

use App\Models\Email;
use Exception;
use Illuminate\Support\Facades\Auth;

class ActionService
{
    public static function addAction(array $data)
    {

        try {
            
            dd($data);

        } catch (Exception $e) {

            throw $e;
        }

    }

    public static function updateAction($id, array $data)
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
