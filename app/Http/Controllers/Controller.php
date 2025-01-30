<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * success response method.
     */
    public function sendSuccessResponse($code, $message, $data = [])
    {
        $response = [
            'status' => $code,
            'message' => $message
        ];
        if (!empty($data)) {
            $response['data'] = $data;
        }
        return new JsonResponse($response, $code);
    }

    /**
     * error response method.
     */

    public function sendErrorResponse($code, $error, $errorMessages = [])
    {
        $response = [
            'status' => $code,
            'message' => $error,
        ];

        if (!empty($errorMessages)) {
            $response['error-message'] = $errorMessages;
        }

        return new JsonResponse($response, $code);
    }
}
