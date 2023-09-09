<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Throwable;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        // バリデーション
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        try
        {
            $user = User::where('email', $request->email)->first();

            if(!$user || !Hash::check($request->password, $user->password)) {
                throw ValidationException::withMessages([
                    'email' => ['The provided credentials are incorrect.'],
                ]);
            }

            $token = $user->createToken('auth_token')->plainTextToken;

            Log::info($user->name.' がログインしました。');

            return response()->json(['access_token' => $token, 'token_type' => 'Bearer']);
        }
        catch(Throwable $e)
        {
            Log::error('ログインに失敗しました。');
            return response()->json(['message' => 'ログインに失敗しました。ログインIDとパスワードをご確認ください。'], 500);
        }
    }
}
