<?php

namespace App\Http\Controllers\Service;

use App\Models\Email;
use App\Models\WorkflowActions;
use Exception;
use Illuminate\Support\Facades\Auth;

class ActionService
{
    public static function addAction(array $data)
    {

        try {

            if ($data['type'] == 'email') {
                WorkflowActions::create([
                    'workflow_id' => $data['workflow_id'],
                    'email_id' => $data['email_id'],
                    'type' => 'email',
                ]);
            } elseif ($data['type'] == 'api') {

                $headers = array_filter(array_combine($data['headers_keys'], $data['headers_values']));
                $body = array_filter(array_combine($data['body_keys'], $data['body_values']));

                $config_api = [
                    'url' => $data['url'],
                    'method' => $data['method'],
                    'headers' => $headers,
                    'body' => $body,
                ];

                WorkflowActions::create([
                    'workflow_id' => $data['workflow_id'],
                    'type' => 'api',
                    'config_api' => $config_api,
                ]);

            }

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
