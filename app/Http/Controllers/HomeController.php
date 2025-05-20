<?php

namespace App\Http\Controllers;
use App\Models\ProductSlider;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function HomePage()
    {
          $sliders = ProductSlider::all(); // or ->latest()->get()
    return view('pages.home-page', compact('sliders'));
    }
}
