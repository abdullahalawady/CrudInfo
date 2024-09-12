<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;

abstract class BaseController extends Controller
{
    // Define HTTP status codes for responses

    //Success responses
    protected const HTTP_OK = 200; //The request was successful, and the server returned the requested data.
    protected const HTTP_CREATED = 201; //The request was successful, and a new resource was created as a result.
    protected const HTTP_NO_CONTENT = 204; //The request was successful, but there is no content to send in the response.
    //Error Responses
    protected const HTTP_BAD_REQUEST = 400; //The server could not understand the request due to invalid syntax.
    protected const HTTP_VALIDATION_ERROR = 422; //The request was well-formed but contained invalid data or failed validation checks.
    protected const HTTP_UNAUTHORIZED = 401; //The request requires user authentication [With unauthorized user].
    protected const HTTP_FORBIDDEN = 403; //The server understood the request but refuses to authorize it [With permissions].
    protected const HTTP_NOT_FOUND = 404; //The requested resource could not be found on the server.
    protected const HTTP_INTERNAL_SERVER_ERROR = 500; //The server encountered an unexpected condition that prevented it from fulfilling the request.

    // Default status code for responses
    protected int $statusCode = self::HTTP_OK;

    /**
     * Get the current status code.
     *
     * @return int Status code
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * Set the status code for the response and return the instance.
     *
     * @param int $statusCode HTTP status code
     * @return self
     */
    public function setStatusCode(int $statusCode): self
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    /**
     * Generate a JSON response with the provided data and headers.
     *
     * @param array $data Response data
     * @param array $headers Custom headers (optional)
     * @return JsonResponse
     */
    protected function respond(array $data, array $headers = []): JsonResponse
    {
        return response()->json($data, $this->getStatusCode(), $headers);
    }

    /**
     * Handle a JSON response with the provided data and headers.
     *
     * @param mixed|null $data Response data
     * @param null $message
     * @param int $status_code
     * @return JsonResponse
     */
    protected function handleResponse(mixed $data = null, $message = null, int $status_code = self::HTTP_OK): JsonResponse
    {
        $returnedData = ['status' => true, 'data' => $data, 'message' => $message, 'code' => $status_code];
        if(!in_array($status_code, [self::HTTP_OK, self::HTTP_CREATED, self::HTTP_NO_CONTENT])){
            unset($returnedData['data']);
            $returnedData['status'] = false;
            $returnedData['errors'] = $data;
        }

        return $this->setStatusCode($status_code)->respond($returnedData);
    }

    /**
     * Generate a successful response with data.
     *
     * @param mixed $data Response data
     * @param int $status_code HTTP status code (default: 200)
     * @param string|null $message Optional message
     * @return JsonResponse
     */
    protected function respondData(mixed $data, string $message = null, int $status_code = self::HTTP_OK): JsonResponse
    {
        return $this->handleResponse($data, $message, $status_code);
    }

    /**
     * Build pagination response data.
     *
     * @param $items
     * @param string|null $message Optional message
     * @param int $status_code HTTP status code (default: 200)
     * @return JsonResponse
     */
    protected function respondWithPagination($items, string $message = null, int $status_code = self::HTTP_OK): JsonResponse
    {
        return $this->handleResponse([
            'list' => $items->items(),
            'paginator' => [
                'total_count' => $items->total(),
                'total_pages' => $items->lastPage(),
                'current_page' => $items->currentPage(),
                'per_page' => $items->perPage(),
            ]
        ], $message, $status_code);
    }

    /**
     * Generate a response with a message.
     *
     * @param string|null $message Optional message
     * @param int $status_code HTTP status code (default: 200)
     * @return JsonResponse
     */
    protected function respondMessage(string $message = null, int $status_code = self::HTTP_OK, $data = null): JsonResponse
    {
        return $this->handleResponse($data, $message, $status_code);
    }

    /**
     * Generate a response with no content.
     *
     * @return JsonResponse
     */
    protected function respondWithNoContent()
    {
        return $this->handleResponse();
    }

    /**
     * Generate an error response with a message.
     *
     * @param string|null $message Optional error message
     * @param int $status_code HTTP status code (default: 500)
     * @return JsonResponse
     */
    protected function respondError(string $message = null, int $status_code = self::HTTP_BAD_REQUEST): JsonResponse
    {
        return $this->handleResponse(null, $message, $status_code);
    }

    /**
     * Generate an error response with a message.
     *
     * @param string|null $message Optional error message
     * @param int $status_code HTTP status code (default: 500)
     * @return JsonResponse
     */
    protected function respondErrorWithoutMessage(string $message = null, int $status_code = self::HTTP_BAD_REQUEST): JsonResponse
    {
        return $this->handleResponse(null, $message, $status_code);
    }

    /**
     * Generate an error response with a message.
     *
     * @param string|null $message Optional error message
     * @param array $errors
     * @param int $status_code HTTP status code (default: 500)
     * @return JsonResponse
     */
    protected function respondValidationErrors(string $message = null, array $errors, int $status_code = self::HTTP_VALIDATION_ERROR): JsonResponse
    {
        if(!$message){
            $message = 'Validation Error';
        }
        return $this->handleResponse($errors, $message, $status_code);
    }
}
