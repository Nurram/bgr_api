<?php


namespace App\Http\Controllers;

use App\Http\Controllers\Controller as Controller;


class BaseController extends Controller

{

    /**

     * success response method.

     *

     * @return \Illuminate\Http\Response

     */

    public function sendResponse($result = [], $message = 'Sukses')

    {

        $response = [
            'code' => 200,
            'success' => true,
            'data'    => $result,
            'message' => $message,

        ];

        return response()->json($response, 200);
    }


    /**

     * return error response.

     *

     * @return \Illuminate\Http\Response

     */

    public function sendError($errorMessages, $error = [], $code = 404)

    {

        $response = [
            'code' => $code,
            'success' => false,
            'message' => $errorMessages,
        ];


        if (!empty($error)) {
            $response['data'] = $error;
        }


        return response()->json($response, $code);
    }
}
