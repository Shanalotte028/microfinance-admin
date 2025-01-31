<?php 

namespace App\Helpers;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

class AuditHelper {
    public static function log($action, $module, $description = null, $oldData = null, $newData = null) {
        AuditLog::create([
            'user_id' => Auth::id(),  // Automatically gets the logged-in user's ID
            'action' => $action,  // What action was performed
            'module' => $module,  // In which module (e.g., "User Management")
            'description' => $description,  // A short explanation of what happened
            'ip_address' => request()->ip(),  // The IP address of the user
            'old_data' => $oldData,  // Data before modification
            'new_data' => $newData  // Data after modification
        ]);
    }
}
