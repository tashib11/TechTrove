<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceProduct;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function dashboardPage()
    {

        return view('admin.dashboard');
    }


public function statistics(Request $request)
{
    try {
        $totalRevenue = Invoice::sum('total');
        $totalOrders = Invoice::count();
        $totalProducts = Product::count();
        $totalBrands = Brand::count();
        $totalCategories = Category::count();

        $bestSelling = InvoiceProduct::select('product_id', DB::raw('SUM(qty) as total_qty'))
            ->whereNotNull('product_id')
            ->groupBy('product_id')
            ->orderByDesc('total_qty')
            ->with('product')
            ->take(25)
            ->get();

        // Date filter param, default to 7 days
        $filterDays = $request->query('days', 7);

        $dateLimit = now()->subDays($filterDays);//now() returns the current date and time.

        $recentOrders = Invoice::where('created_at', '>=', $dateLimit)
            ->orderByDesc('total') // most expensive first
            ->take(25)
            ->with('user')
            ->get();

        return response()->json([
            'totalRevenue' => $totalRevenue,
            'totalOrders' => $totalOrders,
            'totalProducts' => $totalProducts,
            'totalBrands' => $totalBrands,
            'totalCategories' => $totalCategories,
            'bestSelling' => $bestSelling,
            'recentOrders' => $recentOrders,
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'error' => $e->getMessage()
        ], 500);
    }
}


    public function showChart()
    {

        return view('admin.chart');
    }


public function weeklyStats(Request $request)
{
    $daysCount = (int) $request->input('days', 7);
    $days = collect();

    for ($i = $daysCount - 1; $i >= 0; $i--) {
        $date = Carbon::now()->subDays($i)->format('Y-m-d');
        $revenue = Invoice::whereDate('created_at', $date)->sum('total');
        $orders = Invoice::whereDate('created_at', $date)->count();

        $days->push([
            'date' => $date,
            'revenue' => $revenue,
            'orders' => $orders,
        ]);
    }

    return response()->json($days);
}
// public function getInvoicesByDate($date)
// {
//     $invs = Invoice::with('user')
//         ->whereDate('created_at', $date)
//         ->latest()
//         ->get();

//     $html = view('admin.products.invoice-partial-table', compact('invs'))->render();

//     return response()->json(['html' => $html]);
// }
public function getInvoicesByDate($date)
{
    $invs = Invoice::with('user')
        ->whereDate('created_at', $date)
        ->latest()
        ->paginate(10); // Use paginate instead of get()

    $html = view('admin.products.invoice-partial-table', compact('invs'))->render();

    return response()->json(['html' => $html]);
}

public function updateOrderStatus(Request $request)
{
    $request->validate([
        'id' => 'required|exists:invoices,id',
        'value' => 'required|string'
    ]);

    Invoice::where('id', $request->id)->update(['order_status' => $request->value]);

    return response()->json(['success' => true]);
}

public function updatePaymentStatus(Request $request)
{
    $request->validate([
        'id' => 'required|exists:invoices,id',
        'value' => 'required|string'
    ]);

    Invoice::where('id', $request->id)->update(['payment_status' => $request->value]);

    return response()->json(['success' => true]);
}


}






