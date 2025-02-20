<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TokenController extends Controller
{
    public function index(Request $request)
    {
        return response()->json([
            'tokens' => $request->user()->tokens
        ]);
    }

    public function destroy($id)
    {
        $token = auth()->user()->tokens()->findOrFail($id);
        $token->delete();
        
        return response()->json([
            'message' => 'Token deleted successfully'
        ]);
    }

    public function revokeAll()
    {
        auth()->user()->tokens()->delete();
        
        return response()->json([
            'message' => 'All tokens revoked successfully'
        ]);
    }
} 