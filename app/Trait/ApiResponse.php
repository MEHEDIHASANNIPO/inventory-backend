<?php

namespace App\Trait;

use Illuminate\Http\JsonResponse;

trait ApiResponse
{
    // Success Response
    public function ResponseSuccess($data, $metadata = null, $message = 'Successfull', $status_code = JsonResponse::HTTP_OK, $status = 'success') {
        return response()->json([
            'status_code' => $status_code,
            'status' => $status,
            'message' => $message,
            'data' => $data,
            'metadata' => $metadata
        ]);
    }

    // Error Response
    public function ResponseError($errors, $metadata = null, $message = 'Data Proccess Error', $status_code = JsonResponse::HTTP_BAD_REQUEST, $status = 'error') {
        return response()->json([
            'status_code' => $status_code,
            'status' => $status,
            'message' => $message,
            'errors' => $errors,
            'metadata' => $metadata
        ]);
    }

    // Info Response
    public function ResponseInfo($data, $metadata = null, $message = 'Notification', $status_code = JsonResponse::HTTP_OK, $status = 'info') {
        return response()->json([
            'status_code' => $status_code,
            'status' => $status,
            'message' => $message,
            'data' => $data,
            'metadata' => $metadata
        ]);
    }
}
