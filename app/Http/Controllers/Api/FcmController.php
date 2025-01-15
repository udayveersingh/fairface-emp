<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Google\Client as GoogleClient;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class FcmController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function updateDeviceToken(Request $request)
    {
        $user = auth()->user();
        if (is_null($user)) {
            return response()->json(['success' => false, 'message' => "Invalid Request"], 401);
        } else {
            $request->validate([
                'fcm_token' => 'required|string',
            ]);
            $user = User::find($user->id);
            $user->fcm_token =  $request->fcm_token;
            $user->save();
        }
        // $request->user()->update(['fcm_token' => $request->fcm_token]);

        return response()->json([
            'success' => true,
            'message' => 'Device token updated successfully'
        ]);
    }


    public function sendFcmNotification(Request $request)
    {
        $user = auth()->user();
        if (is_null($user)) {
            return response()->json(['success' => false, 'message' => "Invalid Request"], 401);
        } else {
            $request->validate([
                'title' => 'required|string',
                'body' => 'required|string',
            ]);

            $user = User::find($user->id);
            $fcm = $user->fcm_token;
            if (!$fcm) {
                return response()->json(['message' => 'User does not have a device token'], 400);
            }
            $title = $request->title;
            $description = $request->body;
            // $projectId = config('services.fcm.project_id'); # INSERT COPIED PROJECT ID
            $projectId = 'ukvicks-staging'; # INSERT COPIED PROJECT ID

            $credentialsFilePath = Storage::path('json/ukvicks-staging-firebase.json');
            $client = new GoogleClient();
            $client->setAuthConfig($credentialsFilePath);
            $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
            $client->refreshTokenWithAssertion();
            $token = $client->getAccessToken();

            $access_token = $token['access_token'];

            $headers = [
                "Authorization: Bearer $access_token",
                'Content-Type: application/json'
            ];

            $data = [
                "message" => [
                    "token" => $fcm,
                    "notification" => [
                        "title" => $title,
                        "body" => $description,
                    ],
                ]
            ];
            $payload = json_encode($data);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send");
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
            curl_setopt($ch, CURLOPT_VERBOSE, true); // Enable verbose output for debugging
            $response = curl_exec($ch);
            $err = curl_error($ch);
            curl_close($ch);

            if ($err) {
                return response()->json([
                    'message' => 'Curl Error: ' . $err
                ], 500);
            } else {
                return response()->json([
                    'message' => 'Notification has been sent.',
                    'response' => json_decode($response, true)
                ]);
            }
        }
    }
}
