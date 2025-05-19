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
        'catFile' => 'required|image|max:2048',
    ]);

    // Store image in storage/app/public/category
    $path = $request->file('catFile')->store('categories', 'public');

    // Get public URL: e.g., https://yourdomain.com/storage/category/filename.jpg
    $imageUrl = asset('storage/' . $path);

    Category::create([
        'categoryName' => $request->catName,
        'categoryImg' => $imageUrl,
          'categoryAlt' => $request->catAlt,
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
            $path = $request->file('categoryFile')->store('categories', 'public');
            $category->categoryImg = asset('storage/' . $path);
        }

        $category->save();

        return response()->json(['message' => 'Category updated successfully!']);
    }

}
