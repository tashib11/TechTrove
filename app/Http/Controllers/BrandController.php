<?php
namespace App\Http\Controllers;
use App\Helper\ResponseHelper;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use Illuminate\Support\Facades\Storage;
// Use the new Intervention Image v3 classes
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver; // Make sure you have GD extension enabled in PHP
use Exception; // For better exception handling


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

        if ($request->hasFile('brandFile')) {
        $uploadedImageFile = $request->file('brandFile');

        // Force webp extension regardless of upload format
        $filename = time() . '.webp'; // <-- Critical change
        $path = 'brands/' . $filename;

        try {
            $manager = new ImageManager(new Driver());
            $img = $manager->read($uploadedImageFile);

            // Maintain aspect ratio with 250px width
            $img->resize(124, 124);


            // Convert to WebP with 80% quality
            Storage::disk('public')->put($path, (string) $img->toWebp(80));

            // Store webp path in database
            Brand::create([
                'brandName' => $request->brandName,
                'brandImg' => '/storage/' . $path, // webp URL
                'brandAlt' => $request->brandAlt,
            ]);

            return ResponseHelper::Out('success', ['message' => 'Brand created successfully!'], 200);

        } catch (Exception $e) {
            return ResponseHelper::Out('error', ['message' => 'Image processing failed: ' . $e->getMessage()], 500);
        }
    }



    return ResponseHelper::Out('error', ['message' => 'No image uploaded'], 400);

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
        $uploadedImageFile = $request->file('brandFile');

        $filename = time() . '.webp'; // Force webp extension;
        $path = 'brands/' . $filename;

        try {
            $manager = new ImageManager(new Driver());
            $img = $manager->read($uploadedImageFile);

            // Resize to match frontend box (130x150) or your requirement
            $img->resize(124, 124);

            // Save as WebP in public disk
            Storage::disk('public')->put($path, (string) $img->toWebp(80));

            // Update image path
            $brand->brandImg = '/storage/' . $path;

        } catch (Exception $e) {
            return ResponseHelper::Out('error', ['message' => 'Error processing image: ' . $e->getMessage()], 500);
        }
    }

    $brand->save();

    return response()->json(['message' => 'Category updated successfully!']);
}
}

