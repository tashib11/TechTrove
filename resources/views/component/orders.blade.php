<!-- START SECTION BREADCRUMB -->
<div class="breadcrumb_section bg_gray page-title-mini">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="page-title">
               <h2 class="mb-4">Order History</h2>
                </div>
            </div>
            <div class="col-md-6">
                <ol class="breadcrumb justify-content-md-end">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">This Page</a></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="container my-5">
    <div id="order-list" class="row g-4">
        <!-- Orders will be injected here -->
    </div>
</div>

<!-- Modal for Order Details -->
<div class="modal fade" id="orderDetailsModal" tabindex="-1" aria-labelledby="orderDetailsLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Order Details - <span id="modal-tran-id"></span></h5>
                {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
            </div>
            <div class="modal-body">
                <!-- Tracking Steps -->
                <div class="mb-4">
                    <div class="step-wizard">
                        <div class="step" id="step-pending">Pending</div>
                        <div class="step" id="step-processing">Processing</div>
                        <div class="step" id="step-shifted">Shifted</div>
                        <div class="step" id="step-delivered">Delivered</div>
                        <div class="step" id="step-cancelled">Cancelled</div>
                    </div>
                </div>

                <!-- Product Table -->
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Product</th>
                                <th>Qty</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody id="modal-product-list"></tbody>
                    </table>
                </div>

                <div class="text-end fw-bold mt-3">
                    Total: <span id="modal-total" class="text-success"></span>Tk
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .order-card {
        border: 1px solid #ddd;
        border-radius: 12px;
        padding: 16px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    .order-status {
        font-weight: bold;
        padding: 4px 10px;
        border-radius: 10px;
        text-transform: capitalize;
    }

    .order-status.pending { background: #f3f4f6; color: #4b5563; }
    .order-status.processing { background: #dbeafe; color: #1e40af; }
    .order-status.shifted { background: #fef9c3; color: #92400e; }
    .order-status.delivered { background: #dcfce7; color: #166534; }
    .order-status.cancelled { background: #fee2e2; color: #b91c1c; }

    .step-wizard {
        display: flex;
        justify-content: space-between;
        position: relative;
        margin-bottom: 20px;
    }

    .step {
        width: 19%;
        text-align: center;
        padding: 10px;
        border-radius: 8px;
        background-color: #e5e7eb;
        position: relative;
        transition: background-color 0.3s;
    }

    .step.active {
        background-color: #10b981;
        color: #fff;
        font-weight: 600;
    }
</style>

<div class="container my-5">
    {{-- <h2 class="mb-4">Order History</h2> --}}
    <div id="order-list" class="row g-4">
        <!-- Orders will be injected here -->
    </div>
</div>

<!-- Modal for Order Details -->
<div class="modal fade" id="orderDetailsModal" tabindex="-1" aria-labelledby="orderDetailsLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Order Details - <span id="modal-tran-id"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Tracking Steps -->
                <div class="mb-4">
                    <div class="step-wizard">
                        <div class="step" id="step-pending">Pending</div>
                        <div class="step" id="step-processing">Processing</div>
                        <div class="step" id="step-shifted">Shifted</div>
                        <div class="step" id="step-delivered">Delivered</div>
                        <div class="step" id="step-cancelled">Cancelled</div>
                    </div>
                </div>

                <!-- Product Table -->
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Product</th>
                                <th>Qty</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody id="modal-product-list"></tbody>
                    </table>
                </div>

                <div class="text-end fw-bold mt-3">
                    Total: <span id="modal-total" class="text-success"></span>Tk
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .order-card {
        border: 1px solid #ddd;
        border-radius: 12px;
        padding: 16px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    .order-status {
        font-weight: bold;
        padding: 4px 10px;
        border-radius: 10px;
        text-transform: capitalize;
    }

    .order-status.pending { background: #f3f4f6; color: #4b5563; }
    .order-status.processing { background: #dbeafe; color: #1e40af; }
    .order-status.shifted { background: #fef9c3; color: #92400e; }
    .order-status.delivered { background: #dcfce7; color: #166534; }
    .order-status.cancelled { background: #fee2e2; color: #b91c1c; }

    .step-wizard {
        display: flex;
        justify-content: space-between;
        position: relative;
        margin-bottom: 20px;
    }

    .step {
        width: 19%;
        text-align: center;
        padding: 10px;
        border-radius: 8px;
        background-color: #e5e7eb;
        position: relative;
        transition: background-color 0.3s;
    }

    .step.active {
        background-color: #10b981;
        color: #fff;
        font-weight: 600;
    }
</style>

<script>
    async function fetchOrders() {
        let res = await axios.get("/user-orders", {
            headers: { token: localStorage.getItem('token') }
        });

        const orders = res.data.data;
        let html = "";

        orders.forEach((order, index) => {
            const statusKey = (order.order_status || 'Pending').toLowerCase();
            const statusClass = {
                pending: 'pending',
                processing: 'processing',
                shifted: 'shifted',
                delivered: 'delivered',
                cancelled: 'cancelled'
            }[statusKey];

            const orderData = encodeURIComponent(JSON.stringify(order)); // safe encoding

            html += `
            <div class="col-md-6 col-lg-4">
                <div class="order-card">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <strong>Transaction Id:</strong> ${order.tran_id}<br>
                            <small class="text-muted">${new Date(order.created_at).toLocaleString()}</small>
                        </div>
                        <span class="order-status ${statusClass}">${order.order_status}</span>
                    </div>
                    <div class="text-end mt-2">
                        <button class="btn btn-sm btn-outline-primary view-details-btn" data-order="${orderData}">View Details</button>
                    </div>
                </div>
            </div>`;
        });

        document.getElementById("order-list").innerHTML = html;
    }

    $(document).on('click', '.view-details-btn', function () {
        const encoded = $(this).data('order');
        const order = JSON.parse(decodeURIComponent(encoded));
        showDetails(order);
    });

    function showDetails(order) {
        $('#modal-tran-id').text(order.tran_id);
        $('#modal-total').text(order.total);

        const steps = ['pending', 'processing', 'shifted', 'delivered', 'cancelled'];
        steps.forEach(step => $(`#step-${step}`).removeClass('active'));

        const statusKey = (order.order_status || 'Pending').toLowerCase();
        const currentIndex = steps.indexOf(statusKey);

        steps.forEach((step, i) => {
            if (i <= currentIndex) {
                $(`#step-${step}`).addClass('active');
            }
        });

        let rows = '';
        order.products.forEach(p => {
            const product = p.product || {};
            rows += `
                <tr>
                    <td>
                        <a href="/details?id=${product.id || ''}">
                            <img src="${product.image || '#'}" alt=" ${product.img_alt || product.title}" width="70">
                        </a>
                    </td>
                    <td>
                        <a href="/details?id=${product.id || ''}">
                            ${product.title || 'N/A'}
                        </a>
                    </td>
                    <td>${p.qty}</td>
                    <td>${p.price} Tk</td>
                </tr>`;
        });

        $('#modal-product-list').html(rows);
        new bootstrap.Modal(document.getElementById('orderDetailsModal')).show();
    }

    $(document).ready(fetchOrders);
</script>
