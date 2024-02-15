<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse; // Import JsonResponse
use App\Models\Brand; // Import the Brand model class
use App\Helper\ResponseHelper;

class BrandController extends Controller
{
    //
    public function BrandList():JsonResponse{
        $data=Brand::all();//brand ar shob niye nilam datai which is fetched from database throgh brand model
        return ResponseHelper::Out('success',$data,200);
    }
}
