<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class LogController extends Controller
{
    public function index(Request $request)
    {
        $logType = $request->get('type', 'laravel');
        $lines = $request->get('lines', 50);
        
        $logPath = storage_path("logs/{$logType}.log");
        
        if (!File::exists($logPath)) {
            return response()->json(['error' => 'Log file not found'], 404);
        }
        
        $logContent = File::get($logPath);
        $logLines = array_slice(explode("\n", $logContent), -$lines);
        
        return response()->json([
            'log_type' => $logType,
            'lines' => array_filter($logLines)
        ]);
    }
}