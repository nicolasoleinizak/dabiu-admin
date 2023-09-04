<?php

namespace App\Http\Controllers;

use App\Models\WCCredential;
use Illuminate\Http\Request;

class WCCredentialController extends Controller
{
    public function create(Request $request)
    {
        $user_id = auth()->user()->id;

        $existing_credential = WCCredential::where([
            'user_id' => $user_id,
        ])->first();

        if($existing_credential) {
            $existing_credential->url = $request->url;
            $existing_credential->username = $request->username;
            $existing_credential->password = $request->password;
            $existing_credential->save();

            return response()->json(['message' => 'Credential updated']);
        }

        $existing_credential = new WCCredential();
        $existing_credential->url = $request->url;
        $existing_credential->username = $request->username;
        $existing_credential->password = $request->password;
        $existing_credential->user_id = $user_id;
        $existing_credential->save();

        return response()->json(['message' => 'Credential created']);
    }

    public function check(Request $request)
    {
        $user_id = auth()->user()->id;

        $credential = WCCredential::where([
            'user_id' => $user_id,
        ])->first();

        return response()->json(['credentials' => $credential]);

        if($credential) {
            return response()->json([
                'credentials' => [
                    'exists' => true,
                ]
            ]);
        }

        return response()->json([
            'credentials' => [
                'exists' => false,
            ]
        ]);
    }

    public function delete(Request $request)
    {
        $user_id = auth()->user()->id;

        $credential = WCCredential::where([
            'user_id' => $user_id,
        ])->first();

        if($credential->delete()) {
            return response()->json(['message' => 'ok']);
        }
        return response()->json(['message', 'error']);
    }
}
