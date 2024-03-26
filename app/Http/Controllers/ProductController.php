<?php

namespace App\Http\Controllers;

use App\Helper\ResponseHelper;
use App\Models\CustomerProfile;
use App\Models\Product;
use App\Models\ProductDetails;
use App\Models\ProductReview;
use App\Models\ProductWish;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
     public function ListProductByCategory(Request $request):JsonResponse{
        $data=Product::where('category_id',$request->id)->with('brand','category')->get();//wth('relation-name=function name that defined into the Product model)
        return ResponseHelper::Out('success',$data,200);
     }
     public function ListProductByBrand(Request $request):JsonResponse{
        $data=Product::where('brand_id',$request->id)->with('brand','category')->get();
        return ResponseHelper::Out('success',$data,200);
     }
     public function ListProductByremark(Request $request):JsonResponse{
        $data=Product::where('remark',$request->remark)->with('brand','category')->get();
        return ResponseHelper::Out('success',$data,200);
     }
     public function ListProductSlider():JsonResponse{
        $data= Product::all();
        return ResponseHelper::Out('success',$data,200);

     }
     public function ProductDetailsById(Request $request):JsonResponse{ //product ar moddhe abar brand category ase so use dot(.)
        $data=ProductDetails::where('product_id',$request->id)->with('product','product.brand','product.category')->get();
        return ResponseHelper::Out('success',$data,200);
     }

     public function ListReviewByProduct(Request $request):JsonResponse{
        $data=ProductReview::where('product_id',$request->product_id)
        ->with(['profile'=>function($query){
                  $query->select('id','cus_name');//customer ar profile ar shob amar dorkar nai , i just need the id and name
        }])->get();

        return ResponseHelper::Out('success',$data,200);

     }

        public function CreateProductReview(Request $request):JsonResponse{
          $user_id=$request->header('id');
          $profile=CustomerProfile::where('user_id',$user_id)->first();
        //   return ResponseHelper::Out('success',$user_id,200);
          if($profile){
            $request->merge(['customer_id'=>$profile->id]);
            $data=ProductReview::updateOrCreate(['customer_id'=>$profile->id,'product_id'=>$request->input('product_id')],$request->input());
            return ResponseHelper::Out('success',$data,200);

          }
          else{
            return ResponseHelper::Out('fail','Profile not found',401);
          }

        }

        public function ProductWishList(Request $request):JsonResponse{

        $user_id=$request->header('id');
        $data=ProductWish::where('user_id',$user_id)->with('product')->get();
        return ResponseHelper::Out('success',$data,200);
        }

        public function CreateWishList(Request $request):JsonResponse{
            $user_id=$request->header('id');
            $data=ProductWish::updateOrCreate(['user_id'=>$user_id,'product_id'=>$request->product_id],['user_id'=>$user_id,'product_id'=>$request->product_id]);
         return ResponseHelper::Out('success',$data,200);
        }

        public function RemoveWishList(Request $request):JsonResponse{
         $user_id=$request->header('id');
         $data=ProductWish::where(['user_id'=>$user_id,'product_id'=>$request->product_id])->delete();
         return responseHelper::Out('success',$data,200);
        }
}
