<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <img src="{{ secure_asset ('admin-assets/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">TechTrove</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                    with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{ secure_asset('/Dashboard') }}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ secure_asset('/Dashboard/Piechart') }}" class="nav-link">
                        <i class="nav-icon fas fa-chart-pie"></i>
                        <p>Statistics</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ secure_asset('/Dashboard/category') }}" class="nav-link">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>Category</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ secure_asset('/Dashboard/brand') }}" class="nav-link">
                        <svg class="h-6 nav-icon w-6 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 4v12l-4-2-4 2V4M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                          </svg>
                        <p>Brands</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ secure_asset('/Dashboard/ProductCreate') }}" class="nav-link">
                        <i class="nav-icon fas fa-tag"></i>
                        <p>Products</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ secure_asset('/Dashboard/DetailsCreate') }}" class="nav-link">
                        <i class="nav-icon fas fa-tag"></i>
                        <p>Products details</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ secure_asset('/Dashboard/ProductList') }}" class="nav-link">
                        <i class="nav-icon fas fa-tag"></i>
                        <p>Products list</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ secure_asset('/Dashboard/DetailsSelect') }}" class="nav-link">
                        <i class="nav-icon fas fa-tag"></i>
                        <p>Update Product-Details</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ secure_asset('/Dashboard/InvoiceList') }}" class="nav-link">
                        <i class="nav-icon fas fa-shopping-bag"></i>
                        <p>Invoices</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ secure_asset('/Dashboard/UserList') }}" class="nav-link">
                        <i class="nav-icon  fas fa-users"></i>
                        <p>Users</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ secure_asset('/') }}" class="nav-link">
                        <i class="nav-icon  fas fa-home"></i>
                        <p>Home</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
 </aside>
