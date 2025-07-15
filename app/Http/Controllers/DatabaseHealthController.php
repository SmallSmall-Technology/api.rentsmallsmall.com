<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class DatabaseHealthController extends Controller
{
    public function checkDatabaseConnection()
    {
        try {
            DB::connection()->getPdo();
            
            return response()->json([
                'status' => 'success',
                'message' => 'Database connection is healthy',
                'connected' => true
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Database connection failed',
                'connected' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function checkTablesExist()
    {
        try {
            $tables = ['user_tbl', 'bookings', 'property_tbl', 'inspection_tbl', 'admin_tbl'];
            $existingTables = [];
            $missingTables = [];

            foreach ($tables as $table) {
                try {
                    DB::table($table)->limit(1)->get();
                    $existingTables[] = $table;
                } catch (Exception $e) {
                    $missingTables[] = $table;
                }
            }

            return response()->json([
                'status' => 'success',
                'existing_tables' => $existingTables,
                'missing_tables' => $missingTables,
                'all_tables_exist' => empty($missingTables)
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to check table existence',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getTableCounts()
    {
        try {
            $counts = [];
            $tables = ['user_tbl', 'bookings', 'property_tbl', 'inspection_tbl', 'admin_tbl'];

            foreach ($tables as $table) {
                try {
                    $count = DB::table($table)->count();
                    $counts[$table] = $count;
                } catch (Exception $e) {
                    $counts[$table] = 'Error: ' . $e->getMessage();
                }
            }

            return response()->json([
                'status' => 'success',
                'table_counts' => $counts
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to get table counts',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}