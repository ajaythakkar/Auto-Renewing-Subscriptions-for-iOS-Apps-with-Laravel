<?php

namespace App\Http\Controllers;

use InfyOm\Generator\Utils\ResponseUtil;
use Response;

/**
 * @SWG\Swagger(
 *   basePath="/api/v1",
 *   @SWG\Info(
 *     title="Laravel Generator APIs",
 *     version="1.0.0",
 *   )
 * )
 * This class should be parent class for other API controllers
 * Class AppBaseController
 */
class AppBaseController extends Controller
{
    public function sendResponse($result, $message)
    {
        return Response::json(ResponseUtil::makeResponse($message, $result));
    }

    public function sendError($error, $code = 404)
    {
        return Response::json(ResponseUtil::makeError($error), $code);
    }
    public function responseWithData($data)
    {
        return Response::json(array('ResponseCode' => '1', 'ResponseMessage' => 'success', 'data' => $data));
    }
    public function responseError($message)
    {
        return Response::json(array('ResponseCode' => '0', 'ResponseMessage' => $message));
    }

    public function responseSuccess($message)
    {
        return Response::json(array('ResponseCode' => '1', 'ResponseMessage' => $message));
    }
}
