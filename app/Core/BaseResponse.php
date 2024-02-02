<?php

namespace App\Core;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

abstract class BaseResponse implements Responsable
{
    /** @var String $message */
    protected $message = 'base.responses';

    /** @var array $message */
    protected $errors = [];

    /** @var int $statusCode */
    protected $statusCode = Response::HTTP_OK;

    /**
     * The authentication response.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function toResponse($request)
    {
        $data = ['message' => $this->message];

        if (!empty($this->errors)) {
            $data['errors'] = $this->errors;
        }

        return response()->json($data, $this->statusCode);
    }

    /**
     * @param int $statusCode
     * @return BaseResponse
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * @param array $errors
     * @return BaseResponse
     */
    public function setErrors($errors)
    {
        $this->errors = $errors;

        return $this;
    }

    /**
     * @param String $message
     * @return BaseResponse
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }
}
