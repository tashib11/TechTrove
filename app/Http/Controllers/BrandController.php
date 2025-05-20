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
    $imageUrl = '/storage/' . $path;

    Brand::create([
        'brandName' => $request->brandName,
        'brandImg' => $imageUrl,
        'brandAlt' =>$request->brandAlt,
    ]);

    return response()->json(['message' => 'Brand created successfully!']);
}




    public function ByBrandPage()
    {
        return view('pages.product-by-brand');
    }


  public function index()
    {
        // This serves the brand list page
        return view('admin.products.brand-list');
    }

    public function BrandList(): JsonResponse
    {
        $data = Brand::all();
        return ResponseHelper::Out('success', $data, 200);
    }

    public function destroy($id): JsonResponse
    {
        $brand = Brand::find($id);

        if (!$brand) {
            return response()->json(['message' => 'Brand not found'], 404);
        }

        $brand->delete();
        return response()->json(['message' => 'Brand deleted successfully']);
    }

    public function edit($id)
    {
        $brand = Brand::findOrFail($id);
        return view('admin.products.brand-edit', compact('brand'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'brandName' => 'required|string|max:255',
        ]);

        $brand = Brand::findOrFail($id);
        $brand->brandName = $request->brandName;
        $brand->brandAlt = $request->brandAlt;

        if ($request->hasFile('brandFile')) {
            $path = $request->file('brandFile')->store('brands', 'public');
            $brand->brandImg = '/storage/' . $path;
        }

        $brand->save();

        return response()->json(['message' => 'Brand updated successfully!']);
    }
}
