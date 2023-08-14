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
}
