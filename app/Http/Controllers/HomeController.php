<?php

namespace App\Http\Controllers;
use App\Models\ProductSlider;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function HomePage()
    {
          $first = ProductSlider::latest()->first(); // or ->latest()->get()
    return view('pages.home-page', compact('first'));
    }
}
