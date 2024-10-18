<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class GeneralJsonException extends Exception
{

    protected $code = 422;
    protected bool $decode;
    public function __construct(string $message = "", int $code = 0,  $decode = false,?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->decode = $decode;
    }

    /**
     * Render the exception as an HTTP response.
     */
    public function render(Request $request): JsonResponse
    {
        return new JsonResponse([
            'errors' => [
                'message' => $this->decode ? json_decode($this->getMessage()) : $this->getMessage(),
            ]
        ], $this->code);
    }
}
