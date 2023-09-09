<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;
use App\Models\User;

class LogoutController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        // dd(auth('sanctum')->user()->name);
        try{
            $user = auth('sanctum')->user();
            $user->tokens()->delete();
            Log::info($user->name.' がログアウトしました。');
            return response()->json(['message' => 'User logged out successfully']);
        }
        catch(Throwable $e)
        {
            Log::error($user->name.' がログアウトに失敗しました。');
            return response()->json(['message' => 'ログアウトに失敗しました。']);
        }
    }
}