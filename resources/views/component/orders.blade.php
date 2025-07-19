<!-- START SECTION BREADCRUMB -->
<div class="breadcrumb_section bg_gray page-title-mini py-2">
    <div class="container">
        <div class="row align-items-center justify-content-center" style="min-height: 40px;">
            <div class="col-md-6 text-center">
                <ol class="breadcrumb m-0 p-0 justify-content-center">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li class="mx-2">&gt;</li>
                    <li>Order History</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!-- Order List Container -->
<div class="container my-5">
    <div id="order-list" class="row g-4">
     <div class="col-12 text-center text-muted"  style="min-height:600px">Orders Loading...</div>
    </div>
</div>

<!-- Order Details Modal -->
<div class="modal fade" id="orderDetailsModal" tabindex="-1" aria-labelledby="orderDetailsLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable custom-modal-width">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Order Details - <span id="modal-tran-id"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Tracking Steps -->
                <div class="mb-4 step-wizard">
                    <div class="step" id="step-pending">Pending</div>
                    <div class="step" id="step-processing">Processing</div>
                    <div class="step" id="step-shifted">Shifted</div>
                    <div class="step" id="step-delivered">Delivered</div>
                    <div class="step" id="step-cancelled">Cancelled</div>
                </div>

                <!-- Product Table -->
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Product</th>
                                <th>Qty</th>
                                <th>Size</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody id="modal-product-list"></tbody>
                    </table>
                </div>

                <div class="text-end fw-bold mt-3">
                    Total: <span id="modal-total" class="text-success"></span> Tk
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Styles (Cleaned & Merged) -->
<style>
    .order-card {
        border: 1px solid #ddd;
        border-radius: 12px;
        padding: 16px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .order-status {
        font-weight: bold;
        padding: 4px 10px;
        border-radius: 10px;
        text-transform: capitalize;
    }

    .order-status.pending {
        background: #f3f4f6;
        color: #4b5563;
    }

    .order-status.processing {
        background: #dbeafe;
        color: #1e40af;
    }

    .order-status.shifted {
        background: #fef9c3;
        color: #92400e;
    }

    .order-status.delivered {
        background: #dcfce7;
        color: #166534;
    }

    .order-status.cancelled {
        background: #fee2e2;
        color: #b91c1c;
    }

    .step-wizard {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        gap: 10px;
        margin: 40px 0;
        counter-reset: step;
    }

    .step {
        position: relative;
        flex: 1 1 18%;
        text-align: center;
        padding-top: 36px;
        font-size: 14px;
        font-weight: 500;
        color: #6b7280;
        background-color: #f3f4f6;
        border-radius: 8px;
        transition: background-color 0.3s, color 0.3s;
        height: 70px;
    }

    /* Number circle */
    .step::before {
        content: counter(step);
        counter-increment: step;
        position: absolute;
        top: 6px;
        left: 50%;
        transform: translateX(-50%);
        width: 28px;
        height: 28px;
        line-height: 28px;
        background-color: #d1d5db;
        color: #374151;
        border-radius: 50%;
        font-weight: bold;
        font-size: 13px;
        transition: all 0.3s ease;
    }

    /* ACTIVE STATE */
    .step.active {
        background-color: #ecfdf5;
        color: #047857;
    }

    .step.active::before {
        background-color: #10b981;
        color: white;
    }

    /* COMPLETED STATE */
    .step.completed {
        background-color: #d1fae5;
        color: #047857;
    }

    .step.completed::before {
        content: '✔';
        background-color: #10b981;
        color: white;
        font-size: 16px;
        font-weight: bold;
    }

    /* Responsive */
    @media (max-width: 767px) {
        .step {
            flex: 1 1 100%;
        }

        .modal-xl {
            width: 95% !important;
        }

        .custom-modal-width {
            width: 85% !important;
            max-width: none !important;
            margin: auto;
        }
    }
</style>

<!-- Native JS Logic -->
<script>
    document.addEventListener("DOMContentLoaded", () => {

        document.body.addEventListener("click", function(e) {
            if (e.target.classList.contains("view-details-btn")) {
                let btn = e.target;
                setButtonLoading(btn, true);
                const encoded = btn.getAttribute("data-order");
                const order = JSON.parse(decodeURIComponent(encoded));
                showDetails(order);
                setTimeout(() => {
                    setButtonLoading(btn, false);
                }, 100);
            }
        });
    });

    async function fetchOrders() {
        try {
            const res = await fetch("/user-orders");
            const data = await res.json();
            const orders = data.data || [];

            const orderList = document.getElementById("order-list");
            orderList.innerHTML = "";

            if (orders.length === 0) {
                orderList.innerHTML = `<div class="col-12 text-center text-muted">No orders found.</div>`;
                return;
            }
            const orderFrag = document.createDocumentFragment();
            orders.forEach(order => {
                const statusKey = (order.order_status || "Pending").toLowerCase();
                const statusClass = {
                    pending: "pending",
                    processing: "processing",
                    shifted: "shifted",
                    delivered: "delivered",
                    cancelled: "cancelled"
                } [statusKey];

                const orderData = encodeURIComponent(JSON.stringify(
                    order
                    )); // encodeURIComponent() escapes special characters like ", :, { → making it safe for html

                const div = document.createElement('div');
                div.className = 'col-md-6 col-lg-4';
                div.innerHTML = `
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
          </div>`;
                orderFrag.appendChild(div);
            });
            document.querySelector('#order-list').appendChild(orderFrag);
        } catch (err) {
            console.error("Failed to load orders", err);
        }
    }

    function showDetails(order) {
        document.getElementById("modal-tran-id").textContent = order.tran_id;
        document.getElementById("modal-total").textContent = order.total;

        const steps = ["pending", "processing", "shifted", "delivered", "cancelled"];
        steps.forEach(step => {
            const stepEl = document.getElementById("step-" + step);
            stepEl.classList.remove("active", "completed");
        });

        const currentIndex = steps.indexOf((order.order_status || "Pending").toLowerCase());
        steps.forEach((step, i) => {
            const el = document.getElementById("step-" + step);
            if (i < currentIndex) el.classList.add("completed");
            if (i === currentIndex) el.classList.add("active");
        });

        const tbody = document.getElementById("modal-product-list");
        tbody.innerHTML = "";

        order.products.forEach(p => {
            const product = p.product || {};
            tbody.insertAdjacentHTML("beforeend", `
        <tr>
          <td>
            <a href="/details?id=${product.id || ''}">
              <img src="${product.image || '#'}" alt="${product.img_alt || product.title}" width="70">
            </a>
          </td>
          <td>
            <a href="/details?id=${product.id || ''}">${product.title || 'N/A'}</a>
          </td>
          <td>${p.qty}</td>
          <td>${p.size}</td>
          <td>${p.price} Tk</td>
        </tr>`);
        });

        const modal = bootstrap.Modal.getOrCreateInstance(document.getElementById("orderDetailsModal"));
        modal.show();


    }

    function setButtonLoading(button, isLoading) {
        if (isLoading) {
            const spinner = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`;
            button.setAttribute("data-original-text", button.innerHTML);
            button.innerHTML += spinner;
            button.disabled = true;
        } else {
            button.innerHTML = button.getAttribute("data-original-text");
            button.disabled = false;
        }
    }
</script>
