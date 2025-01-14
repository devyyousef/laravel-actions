<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BaseResponseResource extends JsonResource
{
    public $message;
    public $resource;
    public $statusCode = 200;

    public function __construct($message = null, $resource = null, int $statusCode = 200)
    {
        parent::__construct($resource);
        $this->message = $message;
        $this->resource = $resource;
        $this->statusCode = $statusCode;
    }

    public function toArray(Request $request)
    {
        return [
            'status' => 'success',
            'message' => $this->message,
            'data' => $this->resource,
        ];
    }
    public function withResponse($request, $response)
    {
        $response->setStatusCode($this->statusCode);
    }
}
