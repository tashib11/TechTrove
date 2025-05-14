<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceProduct;
use App\Models\ProductCart;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Helper\ResponseHelper;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

    class OrderController extends Controller
    {

public function TrackOrderPage() {
    return view('pages.track-order');
}

public function UserOrders(Request $request): JsonResponse
{
    $user_id = $request->header('id');

    $orders = Invoice::with(['products.product']) // Eager load nested relation
        ->where('user_id', $user_id)
        ->orderByDesc('created_at')
        ->get();

    return ResponseHelper::Out('success', $orders, 200);
}



    }
