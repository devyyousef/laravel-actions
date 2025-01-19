<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ErrorResponseResource extends JsonResource
{
    public $message;
    public $statusCode;
    public $errors;

    public function __construct($message = null, $statusCode = 200, $errors = [])
    {
        $this->message = $message;
        $this->errors = $errors;
        $this->statusCode = $statusCode;
    }

    public function toArray(Request $request): array
    {
        return [
            'status' => 'error',
            'message' => $this->message,
            'pagination' => [],
            'data' => [],
            'errors' => $this->errors ? array_merge($this->errors, [
                'message' => $this->message,
            ])  : [
                'message' => $this->message,
            ],
        ];
    }

    public function withResponse($request, $response)
    {
        $response->setStatusCode($this->statusCode);
    }
}
