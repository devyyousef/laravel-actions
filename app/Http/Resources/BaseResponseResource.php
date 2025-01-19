<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\LengthAwarePaginator;

class BaseResponseResource extends JsonResource
{
    protected $message;
    protected $statusCode;
    protected $errors;

    public function __construct($message = null, $resource = null, int $statusCode = 200, $errors = null)
    {
        parent::__construct($resource);
        $this->message = $message;
        $this->resource = $resource;
        $this->statusCode = $statusCode;
    }

    public function toArray(Request $request)
    {
        $resource = $this->resource;

        $isPaginated = $resource instanceof LengthAwarePaginator;

        $data = $isPaginated ? $resource->items() : ($resource['data'] ?? $resource);

        $paginator = $resource['pagination'] ?? [];
        $pagination = $isPaginated ? [
            'current_page' => $resource->currentPage(),
            'total_records' => $resource->total(),
            'current_records' => $resource->count(),
            'has_next' => $resource->hasMorePages(),
            'has_previous' => $resource->currentPage() > 1,
            'total_pages' => $resource->lastPage(),
            'per_page' => $resource->perPage(),
        ] : $paginator;
        return [
            'status' => 'success',
            'message' => $this->message,
            'pagination' => $pagination,
            'data' => $data,
            'errors' => $this->errors
        ];
    }
    public function withResponse($request, $response)
    {
        $response->setStatusCode($this->statusCode);
    }
}
