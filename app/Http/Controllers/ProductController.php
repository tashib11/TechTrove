<?php
namespace App\Http\Controllers;
use App\Helper\ResponseHelper;
use App\Models\Brand;
use App\Models\Category;
use App\Models\CustomerProfile;
use App\Models\Invoice;
use App\Models\InvoiceProduct;
use App\Models\Product;
use App\Models\ProductCart;
use App\Models\ProductDetails;
use App\Models\ProductReview;
use App\Models\ProductSlider;
use App\Models\ProductWish;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
// Use the new Intervention Image v3 classes
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver; // Make sure you have GD extension enabled in PHP
use Exception; // For better exception handling

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

    $products = $products->with(['brand', 'category'])->latest('id')->get();
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
    $request->validate([
        'title' => 'required|string|max:255',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        // add other validation rules

        'short_des'  => 'required',
         'price' => 'required',
        'discount' => 'required',
        'discount_price' => 'required',
        'stock' => 'required',
        'remark' => 'required',
        'category_id' => 'required|exists:categories,id',
        'brand_id' => 'required|exists:brands,id',
    ]);

 if ($request->hasFile('image')) {
        $uploadedImageFile = $request->file('image');

        // Force webp extension regardless of upload format
        $filename = time() . '.webp'; // <-- Critical change
        $path = 'product-create/' . $filename;

        try {
            $manager = new ImageManager(new Driver());
            $img = $manager->read($uploadedImageFile);

            // Maintain aspect ratio with 250px width
            $img->resize(310, 310);


            // Convert to WebP with 80% quality
            Storage::disk('public')->put($path, (string) $img->toWebp(80));
 $relativePath  = '/storage/' . $path;
            // Store webp path in database
          Product::create([
    'title' => $request->input('title'),
    'short_des' => $request->input('short_des'),
    'image' => $relativePath ,
    'img_alt' =>  $request->input('img_alt'),
    'price' => $request->input('price'),
    'discount' => $request->input('discount'),
    'discount_price' => $request->input('discount_price'),
    'stock' => $request->input('stock'),
    'remark' => $request->input('remark'),
    'category_id' => $request->input('category_id'),
    'brand_id' => $request->input('brand_id'),
    ]);

            return ResponseHelper::Out('success', ['message' => 'Product created successfully!'], 200);

        } catch (Exception $e) {
            return ResponseHelper::Out('error', ['message' => 'Image processing failed: ' . $e->getMessage()], 500);
        }
    }



    return ResponseHelper::Out('error', ['message' => 'No Product uploaded'], 400);

}


    public function detailCreate(){

        // Get only products that do NOT have a related ProductDetails record, ordered by latest
    $products = Product::whereDoesntHave('productDetails')
                ->latest()
                ->get();

    return view('admin.products.createdetail', compact('products'));
    }


public function detailstore(Request $request)
{
    $request->validate([
        'des'  => 'required',
        'img1' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        'img2' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        'img3' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        'img4' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        'color' => 'required',
        'size' => 'required',
        'product_id' => 'required|exists:products,id',
        'img1_alt' => 'nullable|string|max:255',
        'img2_alt' => 'nullable|string|max:255',
        'img3_alt' => 'nullable|string|max:255',
        'img4_alt' => 'nullable|string|max:255',
    ]);

    $manager = new ImageManager(new Driver());

    try {
        $paths = [];

        foreach (['img1', 'img2', 'img3', 'img4'] as $key) {
            if ($request->hasFile($key)) {
                $uploadedImage = $request->file($key);
                $filename = Str::uuid()->toString() . '.webp';
                $path = 'product-details/' . $filename;

                $image = $manager->read($uploadedImage)->resize(400, 400, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

                Storage::disk('public')->put($path, (string) $image->toWebp(80));
                $paths[$key] = '/storage/' . $path;
            } else {
                $paths[$key] = null;
            }
        }

        $product = ProductDetails::create([
            'img1' => $paths['img1'],
            'img2' => $paths['img2'],
            'img3' => $paths['img3'],
            'img4' => $paths['img4'],

            'img1_alt' => $request->input('img1_alt'),
            'img2_alt' => $request->input('img2_alt'),
            'img3_alt' => $request->input('img3_alt'),
            'img4_alt' => $request->input('img4_alt'),

            'img1_width' => 600,
            'img1_height' => 600,
            'img2_width' => 600,
            'img2_height' => 600,
            'img3_width' => 600,
            'img3_height' => 600,
            'img4_width' => 600,
            'img4_height' => 600,

            'des' => $request->input('des'),
            'color' => $request->input('color'),
            'size' => $request->input('size'),
            'product_id' => $request->input('product_id'),
        ]);

        return response()->json(['status' => true, 'message' => 'Product created successfully']);
    } catch (\Exception $e) {
        return response()->json(['status' => false, 'errors' => ['image' => 'Processing failed: ' . $e->getMessage()]]);
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


    public function Details(Request $request)
    {
            $productId = $request->input('id');
            $product =ProductDetails::where('product_id',$productId)->first();
        return view('pages.details-page',compact('product'));
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
    // $query = Product::with(['brand', 'category']);
    $query = Product::query();


    // Filter by remark (popular, new, top, trending)
  if ($request->filled('remark')) {
 $query->whereRaw('LOWER(remark) = ?', [strtolower(trim($request->remark))]);
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
$priceMin = is_numeric($request->price_min) ? (float)$request->price_min : null;
$priceMax = is_numeric($request->price_max) ? (float)$request->price_max : null;

if ($priceMin !== null) {
    $query->whereRaw(
        '(CASE WHEN discount = 1 THEN discount_price ELSE price END) >= ?',
        [$priceMin]
    );
}

if ($priceMax !== null) {
    $query->whereRaw(
        '(CASE WHEN discount = 1 THEN discount_price ELSE price END) <= ?',
        [$priceMax]
    );
}



// Sort by price (considering discount)
if ($request->filled('sort')) {
    switch ($request->sort) {
        case 'asc':
        case 'desc':
            $query->orderByRaw("CASE WHEN discount = 1 THEN discount_price ELSE price END " . strtoupper($request->sort));
            break;
        case 'latest':
            $query->latest('id');
            break;
    }
} else {
    $query->latest('id');
}


//     $products = $query->get();
//  return ResponseHelper::Out('success',$products,200);
      $limit = $request->input('limit', 4);// by defause limit =5 if limit is not proided in the url parameter
    $products = $query->paginate($limit);
    /* , paginate() returns a special Pagination object:

{
  "current_page": 1,
  "data":   5 product items  ,
  "last_page": 12,
  "per_page": 5,
  "total": 60
  "hasMorePages": true // boolean flag
}
  so $products is a rich object now with methods like:
    - currentPage()
    - hasMorePages() //A boolean hasMorePages flag
    - lastPage()
    - total()
    -items() // "Just give me the 'data' array (here 5 products)"

*/

    return ResponseHelper::Out('success', [
        'products' => $products->items(),
        'hasMorePages' => $products->hasMorePages() //A boolean hasMorePages flag
    ], 200);

}

   public function BrandCatFilter(){
      $brands = Brand::select('id', 'brandName')->get();
    $categories = Category::select('id', 'categoryName')->get();
    $data=['brands'=>$brands, 'categories'=> $categories];
   return ResponseHelper::Out('success',$data,200);
   }
    public function ListProductByBrand(Request $request):JsonResponse{
        $data=Product::where('brand_id',$request->id)->with('brand','category')->get();
        return ResponseHelper::Out('success',$data,200);
    }


public function GetBrandById(Request $request): JsonResponse
{
    $brand = Brand::find($request->id);

    if (!$brand) {
        return ResponseHelper::Out('Brand not found', null, 404);
    }

    return ResponseHelper::Out('success', $brand, 200);
}


    public function ListProductSlider():JsonResponse{
        $data=ProductSlider::all();
        return ResponseHelper::Out('success',$data,200);
    }

    public function ProductDetailsById(Request $request):JsonResponse{

        $data=ProductDetails::where('product_id',$request->id)->with('product')->first();//,'product.brand','product.category'

        return ResponseHelper::Out('success',$data,200);
    }

    public function ListReviewByProduct(Request $request):JsonResponse{
        $data=ProductReview::where('product_id',$request->product_id)
            ->with(['profile'=>function($query){
                $query->select('id','cus_name');
            }])->get();
        return ResponseHelper::Out('success',$data,200);
    }


// public function CreateProductReview(Request $request): JsonResponse
// {
//     $user_id = $request->header('id');
//     $profile = CustomerProfile::where('user_id', $user_id)->first();
//     $status = Invoice::where('user_id',$user_id)->where('order_status','Delivered')->first();
//     if ($profile && $status) {
//         $request->merge(['customer_id' => $profile->id]);//in request object put 'customer_id'

//         // Save or update the review
//         $data = ProductReview::updateOrCreate(
//             ['customer_id' => $profile->id, 'product_id' => $request->input('product_id')],  $request->input() );

//         // Update the 'star' column in product with the rating from the review
//         $avgRate  = ProductReview::where('product_id', $request->input('product_id'))->avg('rating');
//         $finalRate = round($avgRate);
//         Product::where('id', $request->input('product_id'))
//             ->update(['star' => $finalRate]);

//         return ResponseHelper::Out('success', $data, 200);
//     } else {
//         return ResponseHelper::Out('fail', 'Customer profile not exists',500);
//     }
// }


public function CreateProductReview(Request $request): JsonResponse
{
    $user_id = $request->header('id');
    $product_id = $request->input('product_id');

    // Step 1: Get Customer Profile
    $profile = CustomerProfile::where('user_id', $user_id)->first();
    if (!$profile) {
        return ResponseHelper::Out('fail', 'profile not exists', 500);
    }

    // Step 2: Check if user received the specific product in a delivered invoice
    $hasReceived = Invoice::where('user_id', $user_id)
        ->where('order_status', 'Delivered')
        ->whereHas('products', function ($query) use ($product_id) {
            $query->where('product_id', $product_id);
        })
        ->exists();

    if (!$hasReceived) {
        return ResponseHelper::Out('fail', 'You can only review this product after delivery.', 403);
    }

    // Step 3: Merge customer_id into the request for saving
    $request->merge(['customer_id' => $profile->id]);

    // Step 4: Save or update the review
    $data = ProductReview::updateOrCreate(
        ['customer_id' => $profile->id, 'product_id' => $product_id],
        $request->input()
    );

    // Step 5: Recalculate product average rating and update product table
    $avgRating = ProductReview::where('product_id', $product_id)->avg('rating');
    $finalRating = round($avgRating); // ceil() if you want upper round
    Product::where('id', $product_id)->update(['star' => $finalRating]);

    return ResponseHelper::Out('success', $data, 200);
}

public function CheckWishListStatus($product_id)
{
    $user_id = auth()->id();

    $exists = ProductWish::where('user_id', $user_id)
        ->where('product_id', $product_id)
        ->exists();

    return response()->json(['inWishlist' => $exists], 200);
}

    public function ProductWishList(Request $request):JsonResponse{
        $user_id=$request->header('id');
        $data=ProductWish::where('user_id',$user_id)->with('product')->get();
        return ResponseHelper::Out('success',$data,200);
    }

    public function CreateWishList(Request $request):JsonResponse{
        $user_id=$request->header('id');
        ProductWish::updateOrCreate(
            ['user_id' => $user_id,'product_id'=>$request->product_id],
            ['user_id' => $user_id,'product_id'=>$request->product_id],
        );
        return ResponseHelper::Out('success',"",200);
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



public function update($id, Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'short_des' => 'required',
        'price' => 'required',
        'discount' => 'required',
        'discount_price' => 'required',
        'img_alt' => 'required|string|max:255',
        'stock' => 'required',
        'remark' => 'required',
        'category_id' => 'required|exists:categories,id',
        'brand_id' => 'required|exists:brands,id',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // optional on update
    ]);

    $product = Product::findOrFail($id);

    $product->fill([
        'title' => $request->input('title'),
        'short_des' => $request->input('short_des'),
        'img_alt' => $request->input('img_alt'),
        'price' => $request->input('price'),
        'discount' => $request->input('discount'),
        'discount_price' => $request->input('discount_price'),
        'stock' => $request->input('stock'),
        'remark' => $request->input('remark'),
        'category_id' => $request->input('category_id'),
        'brand_id' => $request->input('brand_id'),
    ]);

    if ($request->hasFile('image')) {
        try {
            $uploadedImageFile = $request->file('image');
            $filename = time() . '.webp';
            $path = 'product-create/' . $filename;

            $manager = new ImageManager(new Driver());
            $img = $manager->read($uploadedImageFile);

            $img->resize(310, 310);

            Storage::disk('public')->put($path, (string) $img->toWebp(80));

            $product->image = '/storage/' . $path;
        } catch (Exception $e) {
            return ResponseHelper::Out('error', ['message' => 'Image processing failed: ' . $e->getMessage()], 500);
        }
    }

    $product->save();

    return ResponseHelper::Out('success', ['message' => 'Product updated successfully!'], 200);
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
              // Get only products that do NOT have a related ProductDetails record, ordered by latest
    $products = Product::whereHas('productDetails')
                ->latest()
                ->get();

    return view('admin.products.detailselect', compact('products'));
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
 public function detailUpdate(Request $request, $id)
    {
        $detail = ProductDetails::findOrFail($id);

        $request->validate([
            'des'        => 'required',
            'color'      => 'required',
            'size'       => 'required',
            'product_id' => 'required|exists:products,id',
            'img1'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'img2'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'img3'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'img4'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'img1_alt'   => 'nullable|string|max:255',
            'img2_alt'   => 'nullable|string|max:255',
            'img3_alt'   => 'nullable|string|max:255',
            'img4_alt'   => 'nullable|string|max:255',
        ]);

        $manager = new ImageManager(new Driver());

        try {
            // Fill other details first
            $detail->fill($request->only('des', 'color', 'size', 'product_id'));

            // Process and update images
            foreach (['img1', 'img2', 'img3', 'img4'] as $key) {
                if ($request->hasFile($key)) {
                    // Delete old image if it exists
                    if ($detail->{$key}) {
                        Storage::disk('public')->delete(Str::after($detail->{$key}, '/storage/'));
                    }

                    $uploadedImage = $request->file($key);
                    $filename = Str::uuid()->toString() . '.webp';
                    $path = 'product-details/' . $filename;

                    $image = $manager->read($uploadedImage)->resize(400, 400, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });

                    Storage::disk('public')->put($path, (string) $image->toWebp(80));
                    $detail->{$key} = '/storage/' . $path;

                    // Update image dimensions (assuming they are fixed at 600x600 for consistency)
                    $detail->{$key . '_width'} = 600;
                    $detail->{$key . '_height'} = 600;
                }

                // Update alt tags regardless of whether a new image was uploaded
                $altKey = $key . '_alt';
                $detail->{$altKey} = $request->input($altKey);
            }

            $detail->save();

            return response()->json(['status' => true, 'message' => 'Product details updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'errors' => ['image' => 'Processing failed: ' . $e->getMessage()]]);
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
