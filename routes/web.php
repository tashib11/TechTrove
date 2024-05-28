<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PolicyController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Middleware\TokenAuthenticate;
use App\Models\Category;

// Home Page
Route::get('/', [HomeController::class, 'HomePage']);
Route::get('/by-category', [CategoryController::class, 'ByCategoryPage']);
Route::get('/by-brand', [BrandController::class, 'ByBrandPage']);
Route::get('/policy', [PolicyController::class, 'PolicyPage']);
Route::get('/details', [ProductController::class, 'Details']);
Route::get('/login', [UserController::class, 'LoginPage']);
Route::get('/verify', [UserController::class, 'VerifyPage']);
Route::get('/wish', [ProductController::class, 'WishList']);
Route::get('/cart', [ProductController::class, 'CartListPage']);
Route::get('/profile', [ProfileController::class, 'ProfilePage']);




// Brand List
Route::get('/BrandList', [BrandController::class, 'BrandList']);
// Category List
Route::get('/CategoryList', [CategoryController::class, 'CategoryList']);
// Product List
Route::get('/ListProductByCategory/{id}', [ProductController::class, 'ListProductByCategory']);
Route::get('/ListProductByBrand/{id}', [ProductController::class, 'ListProductByBrand']);
Route::get('/ListProductByRemark/{remark}', [ProductController::class, 'ListProductByRemark']);
// Slider
Route::get('/ListProductSlider', [ProductController::class, 'ListProductSlider']);
// Product Details
Route::get('/ProductDetailsById/{id}', [ProductController::class, 'ProductDetailsById']);
Route::get('/ListReviewByProduct/{product_id}', [ProductController::class, 'ListReviewByProduct']);
//policy
Route::get("/PolicyByType/{type}",[PolicyController::class,'PolicyByType']);



// User Auth
Route::get('/UserLogin/{UserEmail}', [UserController::class, 'UserLogin']);
Route::get('/VerifyLogin/{UserEmail}/{OTP}', [UserController::class, 'VerifyLogin']);
Route::get('/logout',[UserController::class,'UserLogout']);


// User Profile
Route::post('/CreateProfile', [ProfileController::class, 'CreateProfile'])->middleware([TokenAuthenticate::class]);
Route::get('/ReadProfile', [ProfileController::class, 'ReadProfile'])->middleware([TokenAuthenticate::class]);
Route::get('/CheckProfile', [ProfileController::class, 'CheckProfile'])->middleware([TokenAuthenticate::class]);


// Product Review
Route::post('/CreateProductReview', [ProductController::class, 'CreateProductReview'])->middleware([TokenAuthenticate::class]);



// Product Wish
Route::get('/ProductWishList', [ProductController::class, 'ProductWishList'])->middleware([TokenAuthenticate::class]);
Route::get('/CreateWishList/{product_id}', [ProductController::class, 'CreateWishList'])->middleware([TokenAuthenticate::class]);
Route::get('/RemoveWishList/{product_id}', [ProductController::class, 'RemoveWishList'])->middleware([TokenAuthenticate::class]);



// Product Cart
Route::post('/CreateCartList', [ProductController::class, 'CreateCartList'])->middleware([TokenAuthenticate::class]);
Route::get('/CartList', [ProductController::class, 'CartList'])->middleware([TokenAuthenticate::class]);
Route::get('/DeleteCartList/{product_id}', [ProductController::class, 'DeleteCartList'])->middleware([TokenAuthenticate::class]);




// Invoice and payment
Route::get("/InvoiceCreate",[InvoiceController::class,'InvoiceCreate'])->middleware([TokenAuthenticate::class]);
Route::get("/InvoiceList",[InvoiceController::class,'InvoiceList'])->middleware([TokenAuthenticate::class]);
Route::get("/InvoiceProductList/{invoice_id}",[InvoiceController::class,'InvoiceProductList'])->middleware([TokenAuthenticate::class]);


//payment
Route::post("/PaymentSuccess",[InvoiceController::class,'PaymentSuccess']);
Route::post("/PaymentCancel",[InvoiceController::class,'PaymentCancel']);
Route::post("/PaymentFail",[InvoiceController::class,'PaymentFail']);

//dashboard

Route::get("/Dashboard",[DashboardController::class,'dashboardPage']);
Route::get("/Dashboard/ProductCreate",[ProductController::class,'create'])->name('product.create');
Route::post("/ProductStore",[ProductController::class,'store'])->name('product.store');
Route::get("/Dashboard/DetailsCreate",[ProductController::class,'detailCreate'])->name('product.detail.create');
Route::post("/ProductDetailStore",[ProductController::class,'detailstore'])->name('product.detail.store');

Route::get("/Dashboard/ProductList",[ProductController::class,'index'])->name('product.list');

Route::get("/Dashboard/ProductEdit/{product}",[ProductController::class,'edit'])->name('product.edit');
Route::post("/Dashboard/ProductUpdate/{product}",[ProductController::class,'update'])->name('product.update');
Route::get('/Dashboard/ProductDelete/{id}', [ProductController::class, 'destroy'])->name('product.delete');

Route::get("/Dashboard/DetailsSelect",[ProductController::class,'detailSelect'])->name('product.detail.select');
Route::get("/Dashboard/DetailsEdit/{product}",[ProductController::class,'detailEdit'])->name('product.detail.edit');
Route::post("/Dashboard/DetailsUpdate/{product}",[ProductController::class,'detailUpdate'])->name('product.detail.update');

Route::get("/Dashboard/brand",[BrandController::class,'create'])->name('brand.create');
Route::post("/BrandStore",[BrandController::class,'store'])->name('brand.store');

Route::get("/Dashboard/category",[CategoryController::class,'create'])->name('category.create');
Route::post("/CategoryStore",[CategoryController::class,'store'])->name('category.store');

Route::get("/Dashboard/InvoiceList",[InvoiceController::class,'index'])->name('invoice.list');

Route::get("/Dashboard/UserList",[UserController::class,'index'])->name('user.list');







