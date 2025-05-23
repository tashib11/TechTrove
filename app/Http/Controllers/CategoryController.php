<?php
namespace App\Http\Controllers;
use App\Helper\ResponseHelper;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
// use Intervention\Image\Facades\Image;

use Intervention\Image\ImageManagerStatic as Image; // Add this line
use Illuminate\Support\Facades\Storage;
// Use the new Intervention Image v3 classes
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver; // Make sure you have GD extension enabled in PHP
// If you prefer Imagick and have it installed, use: use Intervention\Image\Drivers\Imagick\Driver;
use Exception; // For better exception handling


class CategoryController extends Controller
{

    public function create(){
        return view('admin.products.category');
    }

 public function store(Request $request)
{
    $request->validate([
        'catName' => 'required|string|max:255',
        'catFile' => 'required|image|max:5000', // Accepts all image types
        'catAlt' => 'nullable|string|max:255',
    ]);

    if ($request->hasFile('catFile')) {
        $uploadedImageFile = $request->file('catFile');

        // Force webp extension regardless of upload format
        $filename = time() . '.webp'; // <-- Critical change
        $path = 'categories/' . $filename;

        try {
            $manager = new ImageManager(new Driver());
            $img = $manager->read($uploadedImageFile);

            // Maintain aspect ratio with 250px width
            $img->resize(130, 150);


            // Convert to WebP with 80% quality
            Storage::disk('public')->put($path, (string) $img->toWebp(80));

            // Store webp path in database
            Category::create([
                'categoryName' => $request->catName,
                'categoryImg' => '/storage/' . $path, // webp URL
                'categoryAlt' => $request->catAlt,
            ]);

            return ResponseHelper::Out('success', ['message' => 'Category created successfully!'], 200);

        } catch (Exception $e) {
            return ResponseHelper::Out('error', ['message' => 'Image processing failed: ' . $e->getMessage()], 500);
        }
    }

    return ResponseHelper::Out('error', ['message' => 'No image uploaded'], 400);
}








// public function store(Request $request)
// {
//     $request->validate([
//         'catName' => 'required|string|max:255',
//         'catFile' => 'required|image|max:2048',
//     ]);

//     // Store image in storage/app/public/category
//     $path = $request->file('catFile')->store('categories', 'public');

//     // Get public URL: e.g., https://yourdomain.com/storage/category/filename.jpg
//     $imageUrl = '/storage/' . $path;

//     Category::create([
//         'categoryName' => $request->catName,
//         'categoryImg' => $imageUrl,
//           'categoryAlt' => $request->catAlt,
//     ]);

//     return response()->json(['message' => 'Category created successfully!']);
// }

    public function ByCategoryPage(Request $request)
  {
    $categoryId = $request->query('id');

    $query = Product::with(['brand', 'category']);

    if ($categoryId) {
        $query->where('category_id', $categoryId);
    }

    $products = $query->latest('id')->get();
    $categories = Category::select('id', 'categoryName')->get();
    $brands = Brand::select('id', 'brandName')->get();

    return view('pages.product-by-category', compact('products', 'categories', 'brands', 'categoryId'));
}




  public function index()
    {
        // This serves the category list page
        return view('admin.products.category-list');
    }

    public function CategoryList(): JsonResponse
    {
        $data = Category::all();
        return ResponseHelper::Out('success', $data, 200);
    }

    public function destroy($id): JsonResponse
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        $category->delete();
        return response()->json(['message' => 'Category deleted successfully']);
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.products.category-edit', compact('category'));
    }


public function update(Request $request, $id)
{
    $request->validate([
        'categoryName' => 'required|string|max:255',
    ]);

    $category = Category::findOrFail($id);
    $category->categoryName = $request->categoryName;
    $category->categoryAlt = $request->categoryAlt;

    if ($request->hasFile('categoryFile')) {
        $uploadedImageFile = $request->file('categoryFile');

        $filename = time() . '.webp'; // Force webp extension;
        $path = 'categories/' . $filename;

        try {
            $manager = new ImageManager(new Driver());
            $img = $manager->read($uploadedImageFile);

            // Resize to match frontend box (130x150) or your requirement
            $img->resize(130, 150);

            // Save as WebP in public disk
            Storage::disk('public')->put($path, (string) $img->toWebp(80));

            // Update image path
            $category->categoryImg = '/storage/' . $path;

        } catch (Exception $e) {
            return ResponseHelper::Out('error', ['message' => 'Error processing image: ' . $e->getMessage()], 500);
        }
    }

    $category->save();

    return response()->json(['message' => 'Category updated successfully!']);
}
}
