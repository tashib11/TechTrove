<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboardPage()
    {
        $data = [];
        $totalInvoices = Invoice::count();
        $successfulPayments = Invoice::where('payment_status', 'Success')->sum('payable');
        $totalUsers = User::count();
        $totalProducts = Product::count();
        $data['totalInvoices'] = $totalInvoices;
        $data['successfulPayments'] = $successfulPayments;
        $data['totalUsers'] = $totalUsers;
        $data['totalProducts'] = $totalProducts;
        return view('admin.dashboard', $data);
    }

}




