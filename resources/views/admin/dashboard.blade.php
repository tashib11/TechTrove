@extends('admin.layouts.app')

@section('content')
<div class="container-fluid mt-4 px-3">
    <h2 class="mb-4">📊 Dashboard Statistics</h2>

    <!-- Stats Cards -->
    <div class="row g-3" id="stats-cards"></div>

    <!-- Best Selling Products -->
    <h4 class="mt-5">Top 5 Best Selling Products</h4>
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Product</th>
                    <th>Quantity Sold</th>
                </tr>
            </thead>
            <tbody id="best-selling"></tbody>
        </table>
    </div>

    <!-- Recent Orders -->
    <div class="d-flex align-items-center justify-content-between flex-wrap mt-5">
        <h4 class="mb-2 mb-sm-0">Recent Orders</h4>
        <select id="orderFilter" class="form-select form-select-sm w-auto">{{--form-select:It styles the <select> element to have Bootstrap’s default look — padding, border, background, etc. w-auto->The width will adjust just enough to fit the content  --}}
            <option value="7" selected>Last 7 days</option>
            <option value="30">Last 30 days</option>
            <option value="90">Last 90 days</option>
        </select>
    </div>
    <div class="table-responsive mt-2">
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Order ID</th>
                    <th>Total (Tk)</th>
                    <th>User Email</th>
                     <th>Customer Phone</th>
                </tr>
            </thead>
            <tbody id="recent-orders"></tbody>
        </table>
    </div>
</div>
@endsection


@section('script')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const orderFilter = document.getElementById('orderFilter');

    function loadStats(days = 7) {
        fetch(`/admin/dashboard-stats?days=${days}`)
            .then(response => response.json())
            .then(stats => {
                const cards = `
                    <div class="col-md-4 mb-3">
                        <div class="card text-white bg-success">
                            <div class="card-body">Revenue: Tk${stats.totalRevenue}</div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card text-white bg-primary">
                            <div class="card-body">
                                <a href="/Dashboard/InvoiceList" class="nav-link"> Orders: ${stats.totalOrders}</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card text-white bg-info">
                            <div class="card-body">
                                <a href="/Dashboard/ProductList" class="nav-link">Products: ${stats.totalProducts}</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card text-white bg-dark">
                            <div class="card-body">
                                <a href="/Dashboard/BrandList" class="nav-link">Brands: ${stats.totalBrands}</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card text-white bg-secondary">
                            <div class="card-body">
                                <a href="/Dashboard/CategoryList" class="nav-link">Categories: ${stats.totalCategories}</a>
                            </div>
                        </div>
                    </div>
                `;
                document.getElementById('stats-cards').innerHTML = cards;

                const bestSellingTbody = document.getElementById('best-selling');
                bestSellingTbody.innerHTML = '';
                stats.bestSelling.forEach(item => {
                    const product = item.product.title || 'Unknown';
                    bestSellingTbody.innerHTML += `
                        <tr>
                            <td>${product}</td>
                            <td>${item.total_qty}</td>
                        </tr>`;
                });

                const recentOrdersTbody = document.getElementById('recent-orders');
                recentOrdersTbody.innerHTML = '';
                stats.recentOrders.forEach(order => {
                    recentOrdersTbody.innerHTML += `
                        <tr>
                            <td>${order.tran_id}</td>
                            <td>Tk${order.total}</td>
                            <td>${order.user.email || 'Guest'}</td>
                            <td>${order.shipping_phone || 'N/A'}</td>
                        </tr>`;
                });
            })
            .catch(err => console.error('Failed to load stats:', err));
    }

    // Initial load
    loadStats();

    // Reload on filter change
    orderFilter.addEventListener('change', () => {
        loadStats(orderFilter.value);
    });
});
</script>

@endsection
