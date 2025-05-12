<?php
namespace App\Http\Controllers;
use App\Helper\ResponseHelper;
use App\Models\Brand;
use App\Models\Category;
use App\Models\CustomerProfile;
use App\Models\InvoiceProduct;
use App\Models\Product;
use App\Models\ProductCart;
use App\Models\ProductDetails;
use App\Models\ProductReview;
use App\Models\ProductSlider;
use App\Models\ProductWish;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{


public function index(Request $request)
{
    $products = Product::query();

    // Filters
    if ($request->category_id) {
        $products->where('category_id', $request->category_id);
    }
    if ($request->brand_id) {
        $products->where('brand_id', $request->brand_id);
    }
    if ($request->remark) {
        $products->where('remark', $request->remark);
    }
    if ($request->min_price) {
        $products->where('price', '>=', $request->min_price);
    }
    if ($request->max_price) {
        $products->where('price', '<=', $request->max_price);
    }
    if ($request->stock) {
        if ($request->stock === 'in') {
            $products->where('stock', '>', 0);
        } elseif ($request->stock === 'out') {
            $products->where('stock', '=', 0);
        }
    }
    if ($request->star) {
        $products->where('star', $request->star);
    }
if ($request->has('title') && !empty($request->title)) {
    $products->where('title', 'like', '%' . $request->title . '%');
}

    $products = $products->latest('id')->get();
    $categories = Category::orderBy('categoryName', 'ASC')->get();
    $brands = Brand::orderBy('brandName', 'ASC')->get();

    // Return partial view for AJAX
    if ($request->ajax()) {
        return view('admin.products.product-partial', compact('products'))->render();
    }


    // Return full view on first load
    return view('admin.products.Product-list', compact('products', 'categories', 'brands'));
}



    public function create() {
        $data = [];
        $categories= Category::orderBy('categoryName','ASC')->get();
        $brands= Brand::orderBy('brandName','ASC')->get();
        $data['categories']=$categories;
        $data['brands']=$brands;
        return view('admin.products.create', $data);
    }

    public function store(Request $request) {
         $product = Product::create($request->all());
        // return $request->all();
        if($product) {
            return redirect()->route('product.list')->with('success', 'Product created successfully');
        }else {
            return redirect()->route('product.create')->with('error', 'Product creation failed');
        }
    }

    public function detailCreate(){

        $data = [];
        $products= Product::orderBy('title','ASC')->get();

        $data['products']=$products;

        return view('admin.products.createdetail', $data);
    }


    public function detailstore(Request $request) {
        $product = ProductDetails::create($request->all());
        // return $request->all();
        if($product) {
            return redirect()->route('product.detail.create')->with('success', 'Product Details created successfully');
        }else {
            return redirect()->route('product.detail.create')->with('error', 'Product Details creation failed');
        }
    }

    public function WishList()
    {
        return view('pages.wish-list-page');
    }


    public function CartListPage()
    {

        return view('pages.cart-list-page');
    }


    public function Details()
    {
        return view('pages.details-page');
    }


    public function ListProductByCategory(Request $request):JsonResponse{
        $data=Product::where('category_id',$request->id)->with('brand','category')->get();
        return ResponseHelper::Out('success',$data,200);
    }

    public function ListProductByRemark(Request $request):JsonResponse{
        $data=Product::where('remark',$request->remark)->with('brand','category')->get();
        return ResponseHelper::Out('success',$data,200);
    }

public function ProductPage()
{
    $products = Product::with(['brand', 'category'])
        ->whereRaw("TRIM(LOWER(remark)) = 'popular'")
        ->latest('id')
        ->take(12)
        ->get();

    return view('pages.product', compact('products'));
}

public function ProductFilter(Request $request)
{
    $query = Product::with(['brand', 'category']);

    // Filter by remark (popular, new, top, trending)
  if ($request->filled('remark')) {
  $query->whereRaw("TRIM(LOWER(remark)) = ?", [trim(strtolower($request->remark))]);
}


    // Search by title
    if ($request->filled('search')) {
        $query->where('title', 'like', '%' . $request->search . '%');
    }

    // Filter by brand
    if ($request->filled('brand')) {
        $query->where('brand_id', $request->brand);
    }

    // Filter by star (optional)
if ($request->filled('star')) {
    $query->where('star', '>=', $request->star); // star is % out of 100
}

// Dynamic category
if ($request->filled('dynamic_category')) {
    $query->where('category_id', $request->dynamic_category);
}

    // Dynamic price filtering based on each product's discount flag
    if ($request->filled('price_min') || $request->filled('price_max')) {
    $query->where(function ($q) use ($request) {
        if ($request->filled('price_min')) {
            $q->where(function ($q2) use ($request) {
                $q2->where(function ($q3) use ($request) {
                    $q3->where('discount', 0)->where('price', '>=', $request->price_min);
                })->orWhere(function ($q4) use ($request) {
                    $q4->where('discount', 1)->where('discount_price', '>=', $request->price_min);
                });
            });
        }

        if ($request->filled('price_max')) {
            $q->where(function ($q2) use ($request) {
                $q2->where(function ($q3) use ($request) {
                    $q3->where('discount', 0)->where('price', '<=', $request->price_max);
                })->orWhere(function ($q4) use ($request) {
                    $q4->where('discount', 1)->where('discount_price', '<=', $request->price_max);
                });
            });
        }
    });
}
// Sort by price (considering discount)
if ($request->filled('sort')) {
    switch ($request->sort) {
        case 'asc':
            $query->orderByRaw("IF(discount = '1', COALESCE(discount_price, price), price) ASC");
            break;
        case 'desc':
            $query->orderByRaw("IF(discount = '1', COALESCE(discount_price, price), price) DESC");
            break;
        case 'latest':
            $query->latest('id');
            break;
    }
} else {
    $query->latest('id'); // default fallback
}

    $products = $query->get();

    return view('component.product-list', compact('products'))->render();
}

    public function ListProductByBrand(Request $request):JsonResponse{
        $data=Product::where('brand_id',$request->id)->with('brand','category')->get();
        return ResponseHelper::Out('success',$data,200);
    }

    public function ListProductSlider():JsonResponse{
        $data=ProductSlider::all();
        return ResponseHelper::Out('success',$data,200);
    }

    public function ProductDetailsById(Request $request):JsonResponse{

        $data=ProductDetails::where('product_id',$request->id)->with('product','product.brand','product.category')->get();

        return ResponseHelper::Out('success',$data,200);
    }

    public function ListReviewByProduct(Request $request):JsonResponse{
        $data=ProductReview::where('product_id',$request->product_id)
            ->with(['profile'=>function($query){
                $query->select('id','cus_name');
            }])->get();
        return ResponseHelper::Out('success',$data,200);
    }



    public function CreateProductReview(Request $request):JsonResponse{
        $user_id=$request->header('id');
        $profile=CustomerProfile::where('user_id',$user_id)->first();

        if($profile){
            $request->merge(['customer_id' =>$profile->id]);
            $data=ProductReview::updateOrCreate(
                ['customer_id' => $profile->id,'product_id'=>$request->input('product_id')],
                $request->input()
            );
            return ResponseHelper::Out('success',$data,200);
        }
        else{
            return ResponseHelper::Out('fail','Customer profile not exists',200);
        }

    }



    public function ProductWishList(Request $request):JsonResponse{
        $user_id=$request->header('id');
        $data=ProductWish::where('user_id',$user_id)->with('product')->get();
        return ResponseHelper::Out('success',$data,200);
    }

    public function CreateWishList(Request $request):JsonResponse{
        $user_id=$request->header('id');
        $data=ProductWish::updateOrCreate(
            ['user_id' => $user_id,'product_id'=>$request->product_id],
            ['user_id' => $user_id,'product_id'=>$request->product_id],
        );
        return ResponseHelper::Out('success',$data,200);
    }


    public function RemoveWishList(Request $request):JsonResponse{
        $user_id=$request->header('id');
        $data=ProductWish::where(['user_id' => $user_id,'product_id'=>$request->product_id])->delete();
        return ResponseHelper::Out('success',$data,200);
    }


    public function edit($id, Request $request){
        $data = [];
        $product= Product::find($id);
        $data['product']=$product;
        $categories= Category::orderBy('categoryName','ASC')->get();
        $brands= Brand::orderBy('brandName','ASC')->get();
        $data['categories']=$categories;
        $data['brands']=$brands;
        return view('admin.products.edit', $data);
    }

     public function update($id, Request $request){
        $product = Product::find($id);
        $product->update($request->all());
        if($product) {
            return redirect()->route('product.list')->with('success', 'Product updated successfully');
        }else {
            return redirect()->route('product.edit')->with('error', 'Product update failed');
        }
     }

     public function destroy($id)
    {
        $product = Product::findOrFail($id);

        $productInInvoice = InvoiceProduct::where('product_id', $product->id)->exists();

        if ($productInInvoice) {
            return response()->json(['status' => false, 'message' => 'This product cannot be deleted as it is in an invoice'], 400);
        }

        ProductDetails::where('product_id', $product->id)->delete();
        ProductCart::where('product_id', $product->id)->delete();
        ProductSlider::where('product_id', $product->id)->delete();
        ProductReview::where('product_id', $product->id)->delete();
        ProductWish::where('product_id', $product->id)->delete();

        $product->delete();
        if($product) {
         return response()->json(['status' => true, 'message' => 'Product deleted successfully']);
        }else {
           return response()->json(['status' => false, 'message' => 'Product delete failed'], 500);
        }
    }


    public function detailSelect(){
        $data = [];
        $products= Product::orderBy('title','ASC')->get();

        $data['products']=$products;

        return view('admin.products.detailselect', $data);
    }


   public function detailEdit($product, Request $request) {
    $data = [];
    // Find the ProductDetails record by product_id
    $products = ProductDetails::where('product_id', $product)->first();
    $pods= Product::orderBy('title','ASC')->get();

        $data['products'] = $products;
        $data['pods'] = $pods;
        return view('admin.products.detailedit', $data);

}

public function detailUpdate($id, Request $request){
    $product = ProductDetails::find($id);
    $product->update($request->all());
    if($product) {
        return redirect()->route('product.detail.select')->with('success', 'Product updated successfully');
    }else {
        return redirect()->route('product.detail.edit')->with('error', 'Product details update failed');
    }
}


    public function CreateCartList(Request $request):JsonResponse{
        $user_id=$request->header('id');
        $product_id =$request->input('product_id');
        $color=$request->input('color');
        $size=$request->input('size');
        $qty=$request->input('qty');

        $UnitPrice=0;

        $productDetails=Product::where('id','=',$product_id)->first();
        if($productDetails->discount==1){
            $UnitPrice=$productDetails->discount_price;
        }
        else{
            $UnitPrice=$productDetails->price;
        }
        $totalPrice=$qty*$UnitPrice;


        $data=ProductCart::updateOrCreate(
            ['user_id' => $user_id,'product_id'=>$product_id],
            [
                'user_id' => $user_id,
                'product_id'=>$product_id,
                'color'=>$color,
                'size'=>$size,
                'qty'=>$qty,
                'price'=>$totalPrice
            ]
        );

        return ResponseHelper::Out('success',$data,200);
    }



    public function CartList(Request $request):JsonResponse{
        $user_id=$request->header('id');
        $data=ProductCart::where('user_id',$user_id)->with('product')->get();
        return ResponseHelper::Out('success',$data,200);
    }



    public function DeleteCartList(Request $request):JsonResponse{
        $user_id=$request->header('id');
        $data=ProductCart::where('user_id','=',$user_id)->where('product_id','=',$request->product_id)->delete();
        return ResponseHelper::Out('success',$data,200);
    }

public function UserCart(Request $request): JsonResponse
{
    $user_id = $request->header('id');
    $cartItems = ProductCart::where('user_id', $user_id)->with('product')->get();

    return ResponseHelper::Out('success', $cartItems, 200);
}


}
