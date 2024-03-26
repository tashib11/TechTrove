<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PolicyController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\TokenAuthenticate;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/BrandList',[BrandController::class,'BrandList']);
Route::get('/Category',[CategoryController::class,'CategoryList']);
Route::get('/ProductCategory/{id}',[ProductController::class,'ListProductByCategory']);
Route::get('/ProductBrand/{id}',[ProductController::class,'ListProductByBrand']);
Route::get('/ProductRemark/{remark}',[ProductController::class,'ListProductByremark']);
Route::get('/ProductSlider',[ProductController::class,'ListProductSlider']);
Route::get('/ProductDetails/{id}',[ProductController::class,'ProductDetailsById']);
Route::get('/ProductReview/{product_id}',[ProductController::class,'ListReviewByProduct']);
Route::get('/ProductPolicy/{type}',[PolicyController::class,'PolicyByType']);

// User Auth
Route::get('/userLogin/{UserEmail}',[UserController::class,'UserLogin']);
Route::get('/verifyLogin/{UserEmail}/{OTP}',[UserController::class,'VerifyLogin']);
Route::get('/logout',[UserController::class,'UserLogout']);


//user Profile
Route::post('/createProfile',[ProfileController::class,'CreateProfile'])->middleware([TokenAuthenticate::class]);
Route::get('/readProfile',[ProfileController::class,'ReadProfile'])->middleware([TokenAuthenticate::class]);
