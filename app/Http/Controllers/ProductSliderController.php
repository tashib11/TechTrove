<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\ProductSlider;
use App\Models\Product;

class ProductSliderController extends Controller
{
    public function index()
    {
        return view('admin.product-slider.index');
    }

    public function all()
    {
        return ProductSlider::with('product')->get();
    }

public function store(Request $request)
{
    $request->validate([
        'title' => 'required',
        'short_des' => 'required',
        'price' => 'required|numeric',
        'product_id' => 'required|unique:product_sliders,product_id',
        'image' => 'required|file|image|max:2048',
    ]);

    $path = $request->file('image')->store('sliders', 'public');
    $imageUrl = '/storage/' . $path;

    // Create the slider
    $slider = ProductSlider::create([
        'title' => $request->title,
        'short_des' => $request->short_des,
        'price' => $request->price,
        'product_id' => $request->product_id,
        'image' => $imageUrl,
    ]);

    // Update the product's discount info
    $product = Product::find($request->product_id);
      if ($product && $product->price > $request->price) {
        $product->discount_price = $request->price;
        $product->discount = 1;
        $product->save();
    }

    return $slider;
}
public function update(Request $request, $id)
{
    $slider = ProductSlider::findOrFail($id);

    $request->validate([
        'title' => 'required',
        'short_des' => 'required',
        'price' => 'required|numeric',
        'product_id' => "required|unique:product_sliders,product_id,$id",
        'image' => 'nullable|file|image|max:2048',
    ]);

    $slider->title = $request->title;
    $slider->short_des = $request->short_des;
    $slider->price = $request->price;
    $slider->product_id = $request->product_id;

    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('sliders', 'public');
        $slider->image = '/storage/' . $path;
    }

    $slider->save();

    // Update the product's discount info
    $product = Product::find($request->product_id);
      if ($product && $product->price > $request->price) {
        $product->discount_price = $request->price;
        $product->discount = 1;
        $product->save();
    }

    return $slider;
}

    public function destroy($id)
    {
        return ProductSlider::destroy($id);
    }

}
