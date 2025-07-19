<style>
    .is-invalid {
        border-color: #dc3545 !important;
        box-shadow: 0 0 0 0.1rem rgba(220, 53, 69, 0.25);
    }
</style>

<!-- START SECTION BREADCRUMB -->
<div class="breadcrumb_section bg_gray page-title-mini py-2">
    <div class="container">
        <div class="row align-items-center justify-content-center" style="min-height: 40px;">
            <div class="col-md-6 text-center">
                <ol class="breadcrumb m-0 p-0 justify-content-center">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li class="mx-2">&gt;</li>
                    <li>Order</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- Blade Content -->
<div class="container py-4">{{--  y means top & bottom --}}
    <div class="row g-4">{{-- g stands for gap between grid items --}}
        <!-- Shipping Address Card -->
        <div class="col-md-6">
            <div class="card shadow rounded-4 p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0 text-primary"><i class="fas fa-map-marker-alt me-2"></i>Shipping Address</h5>
                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editAddressModal">{{-- You must also have a corresponding modal with class= "modal" --}}
                        <i class="bi bi-pencil"></i>
                    </button>
                </div>
                <div id="shipping-display">
                    <p><strong>Name:</strong> Set Name</p>
                    <p><strong>Phone:</strong> Set Number</p>
                    <p><strong>Address:</strong> Set Address</p>
                </div>
            </div>
        </div>

        <!-- Gift Wrap Option -->
        <div class="col-md-6">
            <div class="card shadow rounded-4 p-4">
                <h5 class="text-success mb-3"><i class="bi bi-gift me-2"></i>Add Gift Wrap</h5>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="giftWrap">
                    <label class="form-check-label" for="giftWrap">{{-- The for="giftWrap" attribute binds the <label> to the <input> whose id="giftWrap". With for, users can click on the text too  --}}
                        Add gift wrap for <strong>30 Tk</strong>
                    </label>
                </div>
            </div>
        </div>

        <!-- Checkout Summary -->
        <div class="col-md-12">
            <div class="card shadow rounded-4 p-4 bg-light">
                <h5 class="mb-3"><i class="bi bi-receipt me-2"></i>Checkout Summary</h5>
                <div class="mt-3 mb-3">
                    <h5 class="text-secondary">Cart Items</h5>
                    <ul class="list-group list-group-flush" id="cart-preview">
                        <!-- Items will be injected by JavaScript -->
                    </ul>
                </div>

                <div class="d-flex justify-content-between border-bottom pb-2">
                    <span>Subtotal</span>
                    <span id="subtotal">Tk 0</span>
                </div>
                <div class="d-flex justify-content-between border-bottom py-2">
                    <span>
                        Shipping
                        <i class="bi bi-info-circle text-muted" data-bs-toggle="tooltip" data-bs-placement="top" title="60 Tk for Dhaka, 150 Tk for others"></i>
                    </span>
                    <span id="shipping">Tk 0</span>
                </div>
                <div class="d-flex justify-content-between border-bottom py-2">
                    <span>Giftwrap</span>
                    <span id="giftwrap-cost">Tk 0</span>
                </div>
                <div class="d-flex justify-content-between border-top pt-3 fw-bold">
                    <span>Total Payable</span>
                    <span id="payable">Tk 0</span>
                </div>
                <div class="text-end mt-4">
                    <button class="btn btn-lg btn-fill-out btn-primary px-4" id="place-order-btn">Proceed to Order</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Address Modal -->
<div class="modal fade" id="editAddressModal" tabindex="-1">{{-- tabindex="-1": Makes modal accessible (lets you focus with keyboard, improves a11y). --}}
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded">{{-- modal-content: Contains all modal elements (header, body, footer). --}}

      <div class="modal-header">
        <h5 class="modal-title">Edit Shipping Address</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <input class="form-control mb-2" placeholder="Full Name" id="ship-name">{{-- form-control: Bootstrap class that styles inputs uniformly. --}}
        <input class="form-control mb-2" placeholder="Phone Number" id="ship-phone">
        <input class="form-control mb-2" placeholder="Alt Phone (optional)" id="ship-alt-phone">
        <input class="form-control mb-2" placeholder="City" id="ship-city">
        <input class="form-control mb-2" placeholder="Division" id="ship-division">
        <textarea class="form-control mb-2" placeholder="Full Address" id="ship-address"></textarea>
      </div>

      <div class="modal-footer justify-content-end">
        <button class="btn btn-fill-out btn-fill-outbtn-success" id="save-shipping">Save Address</button>
      </div>
    </div>
  </div>
</div>


<script>
let subtotal = 0;
let cartItems = [];

const cartPreview = document.getElementById('cart-preview');
const subtotalDisplay = document.getElementById('subtotal');
const shippingDisplay = document.getElementById('shipping');
const giftwrapCostDisplay = document.getElementById('giftwrap-cost');
const payableDisplay = document.getElementById('payable');
const giftWrapCheckbox = document.getElementById('giftWrap');
const cityInput = document.getElementById('ship-city');
const placeOrderBtn = document.getElementById('place-order-btn');

placeOrderBtn.disabled = true;

// ✅ Fetch and display cart items
async function loadCartItems() {
    try {
        let res = await fetch('/user-cart');
        let data = await res.json();

        cartItems = data.data || [];
        subtotal = 0;
        cartPreview.innerHTML = '';

        cartItems.forEach(item => {
            subtotal += parseFloat(item.price);

            const li = document.createElement('li');
            li.className = 'list-group-item d-flex justify-content-between align-items-start';
            li.innerHTML = `
                <div class="me-auto">
                    <div class="fw-semibold">${item.product.title}</div>
                    <small>${item.qty} pcs</small>
                </div>
                <span class="text-end">Tk ${item.price}</span>
            `;
            cartPreview.appendChild(li);
        });

        subtotalDisplay.textContent = `Tk ${subtotal}`;
        updatePayable();
        placeOrderBtn.disabled = false;
    } catch (err) {
        console.error('Cart fetch failed:', err);
        showToast("Failed to load cart. Please try again.","error");
    }
}

// ✅ Calculate payable amount
function updatePayable() {
    const city = cityInput.value.trim().toLowerCase();
    const shipping = city === 'dhaka' ? 60 : 150;
    const giftwrap = giftWrapCheckbox.checked ? 30 : 0;
    const payable = subtotal + shipping + giftwrap;

    shippingDisplay.textContent = `Tk ${shipping}`;
    giftwrapCostDisplay.textContent = `Tk ${giftwrap}`;
    payableDisplay.textContent = `Tk ${payable}`;
}

// ✅ Address Save & Display
document.getElementById('save-shipping').addEventListener('click', () => {
    const name = document.getElementById('ship-name').value;
    const phone = document.getElementById('ship-phone').value;
    const altPhone = document.getElementById('ship-alt-phone').value;
    const city = document.getElementById('ship-city').value;
    const division = document.getElementById('ship-division').value;
    const address = document.getElementById('ship-address').value;

    document.getElementById('shipping-display').innerHTML = `
        <p><strong>Name:</strong> ${name}</p>
        <p><strong>Phone:</strong> ${phone}</p>
        <p><strong>Address:</strong> ${address}, ${city}, ${division}</p>
    `;

    bootstrap.Modal.getInstance(document.getElementById('editAddressModal')).hide();
    updatePayable();
});

//  Form validation and order submission
document.addEventListener('DOMContentLoaded', async () => {
    document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => new bootstrap.Tooltip(el));//It activates Bootstrap tooltips on every HTML element that has this attribute:data-bs-toggle="tooltip"

    await loadCartItems();

    giftWrapCheckbox.addEventListener('change', updatePayable);
    cityInput.addEventListener('input', updatePayable);

    placeOrderBtn.addEventListener('click', async (e) => {
        const btn = e.currentTarget;
        setButtonLoading(btn, true);

        const fields = ['ship-name', 'ship-phone', 'ship-city', 'ship-division', 'ship-address'];
        let hasError = false;

        fields.forEach(id => document.getElementById(id).classList.remove('is-invalid'));

        fields.forEach(id => {
            if (!document.getElementById(id).value.trim()) {
                document.getElementById(id).classList.add('is-invalid');
                hasError = true;
            }
        });

        if (hasError) {
            new bootstrap.Modal(document.getElementById('editAddressModal')).show();
            setButtonLoading(btn, false);
            return;
        }

        const orderData = {
            shipping_name: document.getElementById('ship-name').value.trim(),
            shipping_phone: document.getElementById('ship-phone').value.trim(),
            shipping_alt_phone: document.getElementById('ship-alt-phone').value.trim(),
            shipping_city: document.getElementById('ship-city').value.trim(),
            shipping_division: document.getElementById('ship-division').value.trim(),
            shipping_address: document.getElementById('ship-address').value.trim(),
            gift_wrap: giftWrapCheckbox.checked ? 1 : 0,
            payable: parseInt(payableDisplay.textContent.replace('Tk ', '')) || 0
        };

        try {
            let res = await fetch('/place-order', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(orderData)
            });

            if (!res.ok) throw new Error('Order failed');
            // await res.json();

            window.location.href = '/track-order';
        } catch (err) {
            showToast("Order Failed. Try again","error");
            console.error(err);
        } finally {
            setButtonLoading(btn, false);
        }
    });
});

//  Button loading spinner
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
