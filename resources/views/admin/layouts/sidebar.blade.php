<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <img src="{{ asset ('admin-assets/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">TechTrove</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <nav class="mt-2">
           <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

    {{-- Dashboard --}}
    <li class="nav-item">
        <a href="{{ asset('/Dashboard') }}" class="nav-link">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Dashboard</p>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ asset('/Dashboard/Piechart') }}" class="nav-link">
            <i class="nav-icon fas fa-chart-pie"></i>
            <p>Statistics</p>
        </a>
    </li>

    {{-- Category Section --}}
    <li class="nav-header">CATEGORIES</li>
    <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
            <i class="nav-icon fas fa-folder"></i>
            <p>
                Category Management
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview ms-3">
            <li class="nav-item">
                <a href="{{ asset('/Dashboard/category') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Add Category</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ asset('/Dashboard/CategoryList') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Category List</p>
                </a>
            </li>
        </ul>
    </li>

    {{-- Brand Section --}}
    <li class="nav-header">BRANDS</li>
    <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
            <i class="nav-icon fas fa-industry"></i>
            <p>
                Brand Management
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview ms-3">
            <li class="nav-item">
                <a href="{{ asset('/Dashboard/brand') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Add Brands</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ asset('/Dashboard/BrandList') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Brand List</p>
                </a>
            </li>
        </ul>
    </li>

    {{-- Product Section --}}
    <li class="nav-header">PRODUCTS</li>
    <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
            <i class="nav-icon fas fa-box"></i>
            <p>
                Product Management
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview ms-3">
            <li class="nav-item">
                <a href="{{ asset('/Dashboard/ProductCreate') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Add Product</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ asset('/Dashboard/ProductList') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Product List</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ asset('/Dashboard/DetailsCreate') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Add Product Details</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ asset('/Dashboard/DetailsSelect') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Update Product Details</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ asset('/admin/product-slider') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Product Sliders</p>
                </a>
            </li>
        </ul>
    </li>

    {{-- Other Sections --}}
    <li class="nav-header">ORDERS & USERS</li>
    <li class="nav-item">
        <a href="{{ asset('/Dashboard/InvoiceList') }}" class="nav-link">
            <i class="nav-icon fas fa-file-invoice-dollar"></i>
            <p>Invoices</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ asset('/Dashboard/UserList') }}" class="nav-link">
            <i class="nav-icon fas fa-users"></i>
            <p>Users</p>
        </a>
    </li>

    {{-- Home --}}
    <li class="nav-header">SITE</li>
    <li class="nav-item">
        <a href="{{ asset('/') }}" class="nav-link">
            <i class="nav-icon fas fa-home"></i>
            <p>Home</p>
        </a>
    </li>
</ul>

        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
 </aside>
