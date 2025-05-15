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


public function store(Request $request)
{
    $request->validate([
        'brandName' => 'required|string|max:255',
        'brandFile' => 'required|image|max:2048',
    ]);

    // Store image in storage/app/public/brands
    $path = $request->file('brandFile')->store('brands', 'public');

    // Get public URL: e.g., https://yourdomain.com/storage/brands/filename.jpg
    $imageUrl = asset('storage/' . $path);

    Brand::create([
        'brandName' => $request->brandName,
        'brandImg' => $imageUrl,
    ]);

    return response()->json(['message' => 'Brand created successfully!']);
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
