<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{   //
    public function index() {
        $logs = AuditLog::all();
        return view('admin.settings.activity-log', compact('logs'));
    }
}
