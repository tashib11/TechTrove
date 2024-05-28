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
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{


    public function index() {
        $data = [];
        $products = Product::latest('id')->paginate();
    $data['products'] = $products;
        return view('admin.products.list', $data);
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
            return redirect()->route('product.list')->with('success', 'Product deleted successfully');
        }else {
            return redirect()->route('product.list')->with('error', 'Product delete failed');
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

}
