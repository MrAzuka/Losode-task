<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Business extends Controller
{
    //
    public function showBusinessInfo(Request $request)
    {
        try {
            // Retrieve the authenticated user using the token
            $user = $request->user();

            // Check if the user is authenticated
            if (!$user) {
                return $this->sendErrorResponse(401, 'Unauthorized. Please log in.');
            }

            // Return the user's information
            return $this->sendSuccessResponse(200, 'User information retrieved successfully.', $user);
        } catch (\Throwable $e) {
            return $this->sendErrorResponse(500, 'Server Error. Please try again later.', $e->getMessage());
        }
    }
}
