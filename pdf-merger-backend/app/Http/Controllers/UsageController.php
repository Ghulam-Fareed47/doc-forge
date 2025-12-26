<?php

namespace App\Http\Controllers;

use App\Models\Usage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsageController extends Controller
{
    public function index()
    {
        // Simple authorization check (ensure only logged in users can see)
        // In a real app, check for isAdmin flag
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $logs = Usage::with('user')->latest()->limit(100)->get();
        return response()->json($logs);
    }

    public function log(Request $request)
    {
        $request->validate([
            'tool_name' => 'required|string',
            'file_size' => 'nullable|integer',
        ]);

        Usage::create([
            'user_id' => Auth::id(),
            'tool_name' => $request->tool_name,
            'file_size' => $request->file_size,
            'ip_address' => $request->ip(),
        ]);

        return response()->json(['message' => 'Usage logged successfully']);
    }
}
