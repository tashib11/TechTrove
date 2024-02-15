<?php

namespace App\Http\Controllers;

use App\Helper\ResponseHelper;
use App\Models\Policy;
use Illuminate\Http\Request;

class PolicyController extends Controller
{
    //
 public   function PolicyByType(Request $request){
        // return Policy::where('type',$request->type)->first();
        $data=Policy::where('type',$request->type)->first();
        //first() returns the first mmatched value of type column according to request->type from policies table
        return ResponseHelper::Out('success',$data,200);

    }
}
