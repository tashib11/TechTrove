<?php
namespace App\Http\Controllers;
use App\Helper\ResponseHelper;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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

    public function ByCategoryPage()
    {
        return view('pages.product-by-category');
    }

    public function CategoryList():JsonResponse
    {
        $data= Category::all();
        return  ResponseHelper::Out('success',$data,200);
    }


}
