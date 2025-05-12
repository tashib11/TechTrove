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

    public function store(Request $request) {
        $category = Category::create($request->all() );
       // return $request->all();
       if($category) {
           return redirect()->route('category.create')->with('success', 'category created successfully');
       }else {
           return redirect()->route('category.create')->with('error', 'category creation failed');
       }
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
