<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ReviewerController extends Controller
{
    /**
     * Get a list of all reviewers.
     */
    public function index()
    {
        try {
                
            // Assuming 'reviewer' is a role in the users table
            $reviewers = User::where('role', 'reviewer')->select('id', 'name', 'email')->get();

            return response()->json([
                'success' => true,
                'data' => $reviewers
            ]);
        } catch (\Exception $e) {           

            return response()->json([
                'success' => false,
                'message' =>  $e->getMessage()
            ], 500);
        }
    }
}
