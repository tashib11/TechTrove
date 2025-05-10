<!-- START SECTION BREADCRUMB -->
<div class="breadcrumb_section bg_gray page-title-mini">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="page-title">
                    <h3>Order Page</h3>
                </div>
            </div>
            <div class="col-md-6">
                <ol class="breadcrumb justify-content-md-end">
                    <li class="breadcrumb-item"><a href="{{ url('/cart') }}">Cart</a></li>
                    <li class="breadcrumb-item"><a href="#">This Page</a></li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- Blade Content -->
<div class="container py-4">
    <div class="row g-4">
        <!-- Shipping Address Card -->
        <div class="col-md-6">
            <div class="card shadow rounded-4 p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0 text-primary"><i class="fas fa-map-marker-alt me-2"></i>Shipping Address</h5>
                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editAddressModal">
                        <i class="fas fa-pen"></i>
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
                <h5 class="text-success mb-3"><i class="fas fa-gift me-2"></i>Add Gift Wrap</h5>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="giftWrap">
                    <label class="form-check-label" for="giftWrap">
                        Add gift wrap for <strong>30 Tk</strong>
                    </label>
                </div>
            </div>
        </div>

        <!-- Checkout Summary -->
        <div class="col-md-12">
            <div class="card shadow rounded-4 p-4 bg-light">
                <h5 class="mb-3"><i class="fas fa-receipt me-2"></i>Checkout Summary</h5>
                <div class="mt-3 mb-3">
                    <h6 class="text-secondary">Cart Items</h6>
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
                        <i class="fas fa-info-circle text-muted" data-bs-toggle="tooltip" data-bs-placement="top" title="60 Tk for Dhaka, 150 Tk for others"></i>
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
                    <button class="btn btn-lg btn-primary px-4" id="place-order-btn">Proceed to Order</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Address Modal -->
<div class="modal fade" id="editAddressModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4">
            <div class="modal-header border-0">
                <h5 class="modal-title">Edit Shipping Address</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input class="form-control mb-2" placeholder="Full Name" id="ship-name">
                <input class="form-control mb-2" placeholder="Phone Number" id="ship-phone">
                <input class="form-control mb-2" placeholder="Alt Phone (optional)" id="ship-alt-phone">
                <input class="form-control mb-2" placeholder="City" id="ship-city">
                <input class="form-control mb-2" placeholder="Division" id="ship-division">
                <textarea class="form-control mb-2" placeholder="Full Address" id="ship-address"></textarea>
            </div>
            <div class="modal-footer border-0">
                <button class="btn btn-success" id="save-shipping">Save Address</button>
            </div>
        </div>
    </div>
</div>

<!-- Missing Shipping Info Modal -->
<div class="modal fade" id="missingShippingModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 text-center">
            <div class="modal-header border-0">
                <h5 class="modal-title text-danger"><i class="fas fa-exclamation-circle me-2"></i>Missing Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Please fill up required fields of the <strong>shipping address</strong> </p>
            </div>
            <div class="modal-footer border-0 justify-content-center">
                <button class="btn btn-primary" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>

<script>
    let subtotal = 0;
    let cartItems = [];
    const token = localStorage.getItem('token');
    const user_id = localStorage.getItem('id');

    $('#place-order-btn').prop('disabled', true); // Disable until cart is loaded

    // Fetch cart items from DB
    axios.get('/user-cart', {
    headers: {
        Authorization: `Bearer ${token}`,
        id: user_id
    }
}).then(res => {
    cartItems = res.data.data;

    subtotal = 0;
    $('#cart-preview').empty();

    cartItems.forEach(item => {
        subtotal += parseFloat(item.price);

        $('#cart-preview').append(`
            <li class="list-group-item d-flex justify-content-between align-items-start">
                <div class="me-auto">
                    <div class="fw-semibold">${item['product']['title']}</div>
                    <small>${item.qty} pcs</small>
                </div>
                <span class="text-end">Tk ${item.price}</span>
            </li>
        `);
    });

    $('#subtotal').text(`Tk ${subtotal}`);
    updatePayable();
    $('#place-order-btn').prop('disabled', false);
}).catch(err => {
    console.error('Cart fetch failed:', err);
    alert('Failed to load cart. Please try again.');
});


    function updatePayable() {
        const city = ($('#ship-city').val() || '').toLowerCase().trim();
        const shipping = city === 'dhaka' ? 60 : 150;

        const giftwrap = $('#giftWrap').is(':checked') ? 30 : 0;
        const payable = subtotal + shipping + giftwrap;

        $('#shipping').text(`Tk ${shipping}`);
        $('#giftwrap-cost').text(`Tk ${giftwrap}`);
        $('#payable').text(`Tk ${payable}`);
    }

    // Recalculate on user actions
    $('#giftWrap').on('change', updatePayable);
    $('#ship-city').on('input', updatePayable);

    // Save shipping address and update display
    $('#save-shipping').on('click', () => {
        const name = $('#ship-name').val();
        const phone = $('#ship-phone').val();
        const alt_phone = $('#ship-alt-phone').val();
        const city = $('#ship-city').val();
        const division = $('#ship-division').val();
        const address = $('#ship-address').val();

        $('#shipping-display').html(`
            <p><strong>Name:</strong> ${name}</p>
            <p><strong>Phone:</strong> ${phone}</p>
            <p><strong>Address:</strong> ${address}, ${city}, ${division}</p>
        `);

        $('#editAddressModal').modal('hide');
        updatePayable();
    });
</script>

<script>
    // Bootstrap tooltip init
    $(document).ready(function () {
    // Tooltip initialization
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Place Order click handler
   $('#place-order-btn').on('click', function () {
    const name = $('#ship-name').val()?.trim();
    const phone = $('#ship-phone').val()?.trim();
    const city = $('#ship-city').val()?.trim();
    const division = $('#ship-division').val()?.trim();
    const address = $('#ship-address').val()?.trim();

    if (!name || !phone || !city || !division || !address) {
        $('#missingShippingModal').modal('show');
        return;
    }

    const orderData = {
        shipping_name: name,
        shipping_phone: phone,
        shipping_alt_phone: $('#ship-alt-phone').val()?.trim(),
        shipping_city: city,
        shipping_division: division,
        shipping_address: address,
        gift_wrap: $('#giftWrap').is(':checked') ? 1 : 0,
        payable: parseInt($('#payable').text().replace('Tk ', ''))
    };

    axios.post('/place-order', orderData, {
        headers: {
            Authorization: `Bearer ${token}`,
            id: user_id
        }
    })
    .then(res => {
        window.location.href = `/track-order`;
    })
    .catch(err => {
        alert("Order Failed");
        console.error(err);
    });
});

});

</script>
