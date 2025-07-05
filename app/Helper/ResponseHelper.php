<?php

namespace App\Helper;

use Illuminate\Http\JsonResponse;

class ResponseHelper
{
 public static function Out($msg,$data,$code):JsonResponse{
    //response()->json($data_array, $status_code);
   return  response()->json(['msg' => $msg, 'data' =>  $data],$code);
 }
}
