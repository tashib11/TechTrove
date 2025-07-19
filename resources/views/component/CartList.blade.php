<div class="container my-5">
    <h2 class="text-center mb-4">Cart List</h2>
    <nav class="mb-4 text-center text-md-start">
        <a href="{{ url('/') }}">Home</a> &gt; <span>Cart List</span>
    </nav>

    <div class="table-responsive">
        <table class="table table-bordered align-middle text-center bg-white rounded shadow-sm overflow-hidden">
            {{-- . Without overflow-hiddenA child image inside the table cell sticks out beyond the rounded corners of the table. --}}
            <thead class="table-light  d-md-table-header-group">
                <tr>
                    <th>#</th>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Remove</th>
                </tr>
            </thead>
            <tbody id="byList" data-loaded="false">
                <tr>
                    <td colspan="5" class="text-center">Loading...</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="row mt-4 g-3 align-items-center">
        <div class="col-12 col-md-4 text-start fw-bold fs-5">
            Total: Tk<span id="total">0.00</span>
        </div>
        <div class="col-12 col-md-4 text-center text-success fw-semibold" id="savings-text"></div>
        <div class="col-12 col-md-4 text-end">
            <button id="checkoutBtn" class="btn btn-success btn-fill-out btn-lg w-10 w-md-auto rounded-pill px-4">✅
                Check Out</button>
        </div>
    </div>
</div>


<style>
    .qty-control {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 0.5rem;
    }

    .qty-control button {
        border: 1px solid #ccc;
        background: #f9f9f9;
        padding: 0.25rem 0.6rem;
        font-weight: bold;
        font-size: 1rem;
        border-radius: 6px;
        cursor: pointer;
    }

    .qty-control input {
        width: 50px;
        text-align: center;
        border: 1px solid #ccc;
        border-radius: 6px;
        padding: 0.25rem;
        height: 34px;
    }

    .remove-btn {
        background-color: #ff4d4d;
        color: white;
        padding: 6px 12px;
        font-size: 0.875rem;
        border-radius: 6px;
        border: none;
        cursor: pointer;
        transition: background-color 0.2s ease;
    }

    .remove-btn:hover {
        background-color: #e60000;
    }

    .cart-img {
        width: 70px;
        height: 70px;
        object-fit: cover;
        border-radius: 6px;
        border: 1px solid #ddd;
    }

    /* Mobile Layout */
    @media (max-width: 768px) {
        .cart-img {
            width: 150px;
            height: 150px;
        }

        .table-responsive {
            overflow-x: hidden;
            /* Prevent horizontal scroll */
        }

        table {
            width: 100%;
        }

        table thead {
            display: none;
        }

        table tbody tr {
            display: block;
            margin-bottom: 1.2rem;
            border: 1px solid #eee;
            padding: 10px 12px;
            border-radius: 8px;
            background-color: #fff;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        table tbody td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            font-size: 0.92rem;
            border: none !important;
            width: 100%;
        }

        table tbody td::before {
            content: attr(data-label);
            font-weight: 600;
            color: #555;
            flex-basis: 40%;
            text-align: left;
        }


        /* Nested content reset */
        .product-thumbnail img {
            width: 60px;
            height: auto;
        }

        .qty-control {
            justify-content: flex-end;
        }

        .remove-btn {
            width: 100%;
            text-align: center;
        }

        /* Adjust product cell for stacked content */
        .product-name-content {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .product-name-content a {
            font-weight: 500;
            text-decoration: none;
        }
    }
</style>

<script>
    async function CartList() {
        const res = await fetch(`/CartList`);
        const data = await res.json();

        const byList = document.getElementById("byList");
        byList.innerHTML = "";


        // Check if cart is empty
        if (data['data'].length === 0) {
            byList.innerHTML = `<tr><td colspan="5" class="text-center">Your cart is empty</td></tr>`;
            document.getElementById("checkoutBtn").disabled = true;
            byList.dataset.loaded = "true";
            return;
        }

        // If items found, enable button
        document.getElementById("checkoutBtn").disabled = false;
        byList.dataset.loaded = "true";

        data['data'].forEach((item, i) => {
            const product = item['product'];
            const discounted = product['discount'] == 1;
            const currentPrice = parseFloat(discounted ? product['discount_price'] : product['price'])
                .toFixed(2);
            const originalPrice = parseFloat(product['price']).toFixed(2);
            const productId = product['id'];

            const priceHTML = discounted ?
                `<div>Tk${currentPrice}</div>
               <div class="text-danger" style="text-decoration:line-through; font-size: 0.9rem;">Tk${originalPrice}</div>` :
                `<div>Tk${currentPrice}</div>`;

            const row = document.createElement("tr");
            row.dataset.id = productId;
            row.dataset.price = currentPrice;
            row.dataset.originalPrice = originalPrice;
            row.dataset.discount = discounted ? 1 : 0;
            row.dataset.qty = item['qty'];
            row.dataset.color = item['color'];
            row.dataset.size = item['size'];

            row.innerHTML = `
    <td data-label="#">${i + 1}</td>
    <td data-label="Product">
        <div class="product-name-content">
          <a href="/details?id=${productId}">
          <img src="${product['image']}" alt="${product['img_alt']}" class="cart-img">
          ${product['title']}</a>
        </div>
    </td>
    <td data-label="Quantity">
        <div class="qty-control">
            <button type="button" class="qty-decrease">−</button>
            <input type="text" value="${item['qty']}" class="qty-input">
            <button type="button" class="qty-increase">+</button>
        </div>
    </td>
    <td data-label="Total" class="product-subtotal">${priceHTML}</td>
    <td data-label="Remove">
        <button type="button" class="remove-btn" data-id="${productId}">Remove</button>
    </td>
`;


            byList.appendChild(row);
        });

        bindEvents();
        UpdateTotal();
    }

    function bindEvents() {
        document.querySelectorAll(".remove-btn").forEach(btn => {
            btn.addEventListener('click', () => {
                RemoveCartList(btn.dataset.id);
            });
        });

        document.querySelectorAll(".qty-increase, .qty-decrease").forEach(btn => {
            btn.addEventListener('click', () => {
                const row = btn.closest("tr"); //Finds the closest parent <tr> of the clicked button.
                const qtyInput = row.querySelector(".qty-input");
                const currentQty = parseInt(qtyInput.value);
                const isIncrease = btn.classList.contains("qty-increase");
                const newQty = isIncrease ? currentQty + 1 : Math.max(currentQty - 1, 1);
                qtyInput.value = newQty;
                row.dataset.qty = newQty;
                UpdateTotal();
            });
        });

    }

    function UpdateTotal() {
        let total = 0;
        let originalTotal = 0;

        document.querySelectorAll("#byList tr").forEach(row => {
            const price = parseFloat(row.dataset.price);
            const originalPrice = parseFloat(row.dataset.originalPrice);
            const discount = parseInt(row.dataset.discount) === 1;
            const qty = parseInt(row.dataset.qty);

            total += price * qty;
            originalTotal += originalPrice * qty;

            const priceHTML = discount ?
                `<div>Tk${total.toFixed(2)}</div>
               <div class="text-danger" style="text-decoration:line-through; font-size: 0.9rem;">Tk${originalTotal.toFixed(2)}</div>` :
                `<div>Tk${originalTotal.toFixed(2)}</div>`;

            row.querySelector(".product-subtotal").innerHTML = priceHTML;
        });

        document.getElementById("total").textContent = total.toFixed(2);

        const savings = originalTotal - total;
        const savingsText = document.getElementById("savings-text");
        if (savings > 0.009) {
            savingsText.innerHTML = `You save ${savings.toFixed(2)} Tk`;
        } else {
            savingsText.innerHTML = "";
        }
    }

    async function RemoveCartList(id) {
        const res = await fetch("/DeleteCartList/" + id);

        if (res.status === 200) {
            const row = document.querySelector(`#byList tr[data-id='${id}']`);
            if (row) row.remove();
            UpdateTotal();
        } else {
            showToast("Try again later","error");
        }
    }

    document.getElementById('checkoutBtn').addEventListener('click', async (e) => {
        const btn = e.currentTarget;
        setButtonLoading(btn, true);

        const cartTable = document.getElementById("byList");
        const rows = cartTable.querySelectorAll("tr[data-id]");

        if (rows.length === 0 || cartTable.dataset.loaded !== "true") {
            showToast("Your cart is empty.", "error");
            setButtonLoading(btn, false);
            return;
        }

        const selectedItems = Array.from(rows).map(row => ({
            id: row.dataset.id,
            qty: row.dataset.qty,
            color: row.dataset.color,
            size: row.dataset.size
        }));

        // proceed with fetch
        try {
            for (const item of selectedItems) {
                await fetch('/CreateCartList', {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        product_id: item.id,
                        qty: item.qty,
                        color: item.color,
                        size: item.size
                    })
                });
            }

            localStorage.setItem("checkoutItems", JSON.stringify(selectedItems));
            window.location.href = "/payment-page";
        } catch (err) {
            console.error(err);
            showToast("Checkout failed. Try again.", "error");
        }

        setButtonLoading(btn, false);
    });



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

    // to show updated cart list when the page is shown again
    //"pageshow"	Runs code whenever the page is shown
    window.addEventListener("pageshow", async function(event) {
        if (event.persisted || (window.performance && window.performance.navigation.type ===
            2)) { //window.performance.navigation.type -> means the page was opened via back/forward navigation.
            await CartList(); //Call CartList() to refresh the cart list
            //  location.reload();//location.reload()	Force a full reload of the page
        }
    });
</script>
