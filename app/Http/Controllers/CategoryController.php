<?php
namespace App\Http\Controllers;
use App\Helper\ResponseHelper;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;


class CategoryController extends Controller
{

    public function create(){
        return view('admin.products.category');
    }


public function store(Request $request)
{
    $request->validate([
        'catName' => 'required|string|max:255',
        'catFile' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Store image in storage/app/public/brands
    $path = $request->file('catFile')->store('categories', 'public');

    // Get public URL: e.g., https://yourdomain.com/storage/brands/filename.jpg
    $imageUrl = asset('storage/' . $path);

    Category::create([
        'categoryName' => $request->catName,
        'categoryImg' => $imageUrl,
    ]);

    return response()->json(['message' => 'Category created successfully!']);
}

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

    public function CategoryList():JsonResponse
    {
        $data= Category::all();
        return  ResponseHelper::Out('success',$data,200);
    }


}
