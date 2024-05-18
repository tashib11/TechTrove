<?php
namespace App\Http\Controllers;
use App\Helper\ResponseHelper;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class BrandController extends Controller
{

    public function create(){
        return view('admin.products.brand');
    }

    public function store(Request $request) {
        $brand = Brand::create($request->all() );
       // return $request->all();
       if($brand) {
           return redirect()->route('brand.create')->with('success', 'brand created successfully');
       }else {
           return redirect()->route('brand.create')->with('error', 'brand creation failed');
       }
   }

    public function ByBrandPage()
    {
        return view('pages.product-by-brand');
    }


    public function BrandList():JsonResponse
    {
        $data= Brand::all();
        return ResponseHelper::Out('success',$data,200);
    }
}
