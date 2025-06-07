<?php

namespace App\Base;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Throwable;

abstract class BaseController extends Controller
{
    protected $per_page = 10;    // Default per page pagination
    protected $offset = 1;    // Default offset pagination

    public function __construct(Request $request)
    {
        if($request->input("per_page")){
            $this->per_page = (int) $request->input("per_page");
        }
    }

    /**
     * success response method.
     *
     * @param $result
     * @param $message
     * @param int $statusCode
     * @return JsonResponse
     */
    public function sendSuccess(array $result, $message, $statusCode = Response::HTTP_OK): JsonResponse

    {
        $pagination = [];
        if(isset($result['pagination'])){
            $pagination['pagination'] = $result['pagination'];
            unset($result['pagination']);
        }
        $response = [
            'success' => true,
            'data' => $result,
            'message' => $message,
        ];
        $response = array_merge($response, $pagination);

        return response()->json($response, $statusCode);
    }


    /**
     * return error response.
     *
     * @param $error
     * @param array|string $errorMessages
     * @param int $code
     * @return JsonResponse
     */
    public function sendError($error, $errorMessages = [], int $code = Response::HTTP_NOT_FOUND): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }

}
