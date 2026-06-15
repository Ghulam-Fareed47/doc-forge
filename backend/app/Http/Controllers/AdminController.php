<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Usage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Check if current user is admin (middleware-like check)
     */
    private function ensureAdmin()
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized. Admin access required.');
        }
    }

    /**
     * Get dashboard statistics
     */
    public function dashboard()
    {
        $this->ensureAdmin();

        return response()->json([
            'total_users' => User::count(),
            'admin_users' => User::where('is_admin', true)->count(),
            'total_operations' => Usage::count(),
            'total_data_processed' => Usage::sum('file_size'),
            'recent_activity' => Usage::with('user')->latest()->limit(10)->get(),
        ]);
    }

    /**
     * Get all users
     */
    public function users()
    {
        $this->ensureAdmin();

        return response()->json(
            User::select('id', 'name', 'email', 'is_admin', 'created_at')
                ->orderBy('created_at', 'desc')
                ->get()
        );
    }

    /**
     * Update user admin status
     */
    public function updateUser(Request $request, User $user)
    {
        $this->ensureAdmin();

        $request->validate([
            'is_admin' => 'sometimes|boolean',
            'name' => 'sometimes|string|max:255',
        ]);

        // Prevent self-demotion
        if ($user->id === Auth::id() && $request->has('is_admin') && !$request->is_admin) {
            return response()->json(['message' => 'Cannot remove your own admin status'], 400);
        }

        $user->update($request->only(['is_admin', 'name']));

        return response()->json(['message' => 'User updated successfully', 'user' => $user]);
    }

    /**
     * Delete a user
     */
    public function deleteUser(User $user)
    {
        $this->ensureAdmin();

        // Prevent self-deletion
        if ($user->id === Auth::id()) {
            return response()->json(['message' => 'Cannot delete yourself'], 400);
        }

        $user->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }

    /**
     * Get all usage logs
     */
    public function usageLogs(Request $request)
    {
        $this->ensureAdmin();

        $query = Usage::with('user')->latest();

        if ($request->has('tool')) {
            $query->where('tool_name', $request->tool);
        }

        return response()->json($query->paginate(50));
    }

    /**
     * Get analytics data for charts
     */
    public function analytics()
    {
        $this->ensureAdmin();

        // Get usage by day for the last 30 days
        $usageByDay = Usage::selectRaw('DATE(created_at) as date, COUNT(*) as count, SUM(file_size) as total_size')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Get usage by tool type
        $usageByTool = Usage::selectRaw('tool_name, COUNT(*) as count')
            ->groupBy('tool_name')
            ->orderByDesc('count')
            ->get();

        // Get new users by day for the last 30 days
        $usersByDay = User::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return response()->json([
            'usage_by_day' => $usageByDay,
            'usage_by_tool' => $usageByTool,
            'users_by_day' => $usersByDay,
        ]);
    }
}
