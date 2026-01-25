<?php

if(! function_exists('responseSuccess')){
    function responseSuccess($message, $data = null){
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ],200);
    }
}


if(! function_exists('responseFailed')){
    function responseFailed($message, $httpCode = null){
        return response()->json([
            'successs' => false,
            'message' => $message,
        ], isset($httpCode) ? $httpCode : 404);
    }
}


?>
