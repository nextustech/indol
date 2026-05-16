<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view-audit-logs');
    }

    public function index(Request $request)
    {
        $query = AuditLog::with('user')->latest();

        if ($request->action) {
            $query->where('action', $request->action);
        }

        if ($request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->model_type) {
            $query->where('model_type', $request->model_type);
        }

        if ($request->date_from && $request->date_to) {
            $query->whereBetween('created_at', [
                $request->date_from . ' 00:00:00',
                $request->date_to . ' 23:59:59',
            ]);
        }

        $logs = $query->paginate(50);

        $actions = ['soft_delete', 'restore', 'force_delete'];
        $models = AuditLog::distinct()->pluck('model_type')->filter()->map(fn($m) => class_basename($m));
        $users = \App\Models\User::pluck('name', 'id');

        return view('audit-logs.index', compact('logs', 'actions', 'models', 'users'));
    }
}
