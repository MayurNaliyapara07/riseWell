<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BaseController extends Controller
{

    protected function successResponse($message = null, $data = [], $code = 200)
    {
        $response = [
            'status' => true,
            'message' => $message,
            'data' => $data,
        ];
        return response()->json($response, $code);
    }

    protected function errorResponse($message = null, $data = [], $code = 400)
    {
        return response()->json([
            'status' => false,
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    public function checkValidation($request, $array)
    {
        $errorFields = [];

        $validator = Validator::make($request->all(), $array);

        if ($validator->fails()) {
            foreach ($validator->errors()->toArray() as $key => $value) {
                $validations = $key.':'.trim($value[0], '.');
                array_push($errorFields, $validations);
            }

            return ['status' => true, 'message' => 'Some fields have errors '.implode(',', $errorFields)];
        } else {
            return ['status' => false];
        }
    }

    protected function webResponse($message = null, $status = true, $data = array(), $code = 200)
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ], $code);
    }
}
