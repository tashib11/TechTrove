<style>
/* General improvements */
.qty-control {
    max-width: 130px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.qty-control .btn {
    min-width: 30px;
    padding: 0.25rem 0.5rem;
}

.qty-input {
    width: 50px !important;
    height: 34px;
    padding: 0 5px;
}

/* Replace ti-close icon with button */
.remove-btn {
    border: none;
    background-color: #ff4d4d;
    color: white;
    padding: 6px 12px;
    font-size: 0.875rem;
    border-radius: 4px;
    cursor: pointer;
    transition: background 0.2s ease;
}

.remove-btn:hover {
    background-color: #e60000;
}

/* Mobile Responsive Stack Layout */
@media (max-width: 767.98px) {
    #byList tr {
        display: block;
        margin-bottom: 1.5rem;
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 10px;
    }

    #byList tr td {
        display: flex;
        justify-content: space-between;
        align-items: center;
        text-align: left;
        font-size: 0.9rem;
        padding: 6px 10px;
        border: none;
    }

    #byList tr td::before {
        content: attr(data-label);
        font-weight: bold;
        text-transform: capitalize;
    }

    .qty-control {
        justify-content: flex-end;
    }

    .remove-btn {
        width: 100%;
        text-align: center;
    }
}
</style>


<!-- START SECTION BREADCRUMB -->
<div class="breadcrumb_section bg_gray page-title-mini">
    <div class="container">
        <div class="row align-items-center text-center text-md-start">
            <div class="col-12 col-md-6 mb-2 mb-md-0">
                <div class="page-title">
                    <h1>Cart List</h1>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <ol class="breadcrumb justify-content-center justify-content-md-end">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">This Page</a></li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- END SECTION BREADCRUMB -->

<!-- CART TABLE SECTION -->
<div class="mt-4 mb-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <!-- Responsive Table Wrapper -->
                <div class="table-responsive shop_cart_table">
                    <table class="table align-middle text-center">
                        <thead class="table-light d-none d-md-table-header-group">
                            <tr>
                                <th>#</th>
                                <th class="product-thumbnail">&nbsp;</th>
                                <th class="product-name">Product</th>
                                <th class="product-quantity">Quantity</th>
                                <th class="product-subtotal">Total</th>
                                <th class="product-remove">Remove</th>
                            </tr>
                        </thead>
                        <tbody id="byList"></tbody>
                        <tfoot>
                            <tr>
                                <td colspan="6" class="p-0">
                                    <div class="row g-3 align-items-center px-2 py-3">
                                        <div class="col-12 col-md-4 text-start">
                                            <strong>Total:</strong> $<span id="total"></span>
                                        </div>
                                        <div class="col-12 col-md-4 text-md-center text-success" id="savings-text" style="font-weight: 600;"></div>
                                        <div class="col-12 col-md-4 text-end">
                                            <!-- Change class on the button -->
<button onclick="CheckOut()" class="btn btn-success btn-lg w-100 w-md-auto rounded-pill shadow">🛒 Check Out</button>

                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
async function CartList() {
    let res = await axios.get(`/CartList`);
    $("#byList").empty();

    res.data['data'].forEach((item, i) => {
        let discounted = item['product']['discount'] == 1;
        let currentPrice = discounted
            ? parseFloat(item['product']['discount_price']).toFixed(2)
            : parseFloat(item['product']['price']).toFixed(2);
        let originalPrice = parseFloat(item['product']['price']).toFixed(2);
        let productId = item['product']['id'];

        let priceHTML = discounted
            ? `<div>$${currentPrice}</div>
               <div class="text-danger" style="text-decoration:line-through; font-size: 0.9rem;">$${originalPrice}</div>`
            : `<div>$${currentPrice}</div>`;

        let EachItem = `<tr
            data-id="${productId}"
            data-price="${currentPrice}"
            data-original-price="${originalPrice}"
            data-discount="${discounted ? 1 : 0}"
            data-qty="${item['qty']}"
            data-color="${item['color']}"
            data-size="${item['size']}"
        >
            <td>${i + 1}</td>
            <td class="product-thumbnail">
                <a href="/details?id=${productId}">
                    <img src="${item['product']['image']}" alt="${item['product']['img_alt']}" style="max-width: 80px;">
                </a>
            </td>
            <td class="product-name">
                <a href="/details?id=${productId}">${item['product']['title']}</a>
            </td>
          <td class="product-quantity">
    <div class="qty-control">
        <button class="btn btn-outline-secondary btn-sm qty-decrease" type="button">−</button>
        <input type="text" class="form-control text-center qty-input" value="${item['qty']}" readonly>
        <button class="btn btn-outline-secondary btn-sm qty-increase" type="button">+</button>
    </div>
</td>

            <td class="product-subtotal">${priceHTML}</td>
<td class="product-remove">
    <button class="remove-btn" data-id="${productId}">Remove</button>
</td>

        </tr>`;

        $("#byList").append(EachItem);
    });

    UpdateTotal();

    $(".remove-btn").on('click', function () {
        let id = $(this).data('id');
        RemoveCartList(id);
    });

    $(".qty-increase, .qty-decrease").on('click', function () {
        let row = $(this).closest("tr");
        let qtyInput = row.find(".qty-input");
        let currentQty = parseInt(qtyInput.val());
        let isIncrease = $(this).hasClass("qty-increase");

        let newQty = isIncrease ? currentQty + 1 : Math.max(currentQty - 1, 1);
        qtyInput.val(newQty);
        row.attr("data-qty", newQty);
        UpdateTotal();
    });
}

function UpdateTotal() {
    let total = 0;
    let originalTotal = 0;

    $("#byList tr").each(function () {
        let price = parseFloat($(this).data("price"));
        let originalPrice = parseFloat($(this).data("original-price"));
        let discount = $(this).data("discount") == 1;
        let qty = parseInt($(this).attr("data-qty"));

        total += price * qty;
        originalTotal += originalPrice * qty;

        let priceHTML = discount
            ? `<div>$${(price * qty).toFixed(2)}</div>
               <div class="text-danger" style="text-decoration:line-through; font-size: 0.9rem;">$${(originalPrice * qty).toFixed(2)}</div>`
            : `<div>$${(originalPrice * qty).toFixed(2)}</div>`;

        $(this).find(".product-subtotal").html(priceHTML);
    });

    $("#total").text(total.toFixed(2));

    let savings = originalTotal - total;
    if (savings > 0.009) {
        $("#savings-text").html(`You save ${savings.toFixed(2)} Tk`);
    } else {
        $("#savings-text").empty();
    }
}

async function RemoveCartList(id) {
    $(".preloader").delay(90).fadeIn(100).removeClass('loaded');
    let res = await axios.get("/DeleteCartList/" + id);
    $(".preloader").delay(90).fadeOut(100).addClass('loaded');

    if (res.status === 200) {
        $(`#byList tr[data-id='${id}']`).remove();  // Remove just the row
        UpdateTotal();  // Recalculate total
    } else {
        alert("Request Fail");
    }
}


async function CheckOut() {
    $(".preloader").delay(90).fadeIn(100).removeClass('loaded');

    let selectedItems = [];
    $("#byList tr").each(function () {
        selectedItems.push({
            id: $(this).data("id"),
            qty: $(this).attr("data-qty"),
            color: $(this).data("color"),
            size: $(this).data("size")
        });
    });

    if (selectedItems.length === 0) {
        $(".preloader").delay(90).fadeOut(100).addClass('loaded');
        alert("Your cart is empty.");
        return;
    }

    try {
        for (const item of selectedItems) {
            await axios.post('/CreateCartList', {
                product_id: item.id,
                qty: item.qty,
                color: item.color,
                size: item.size
            }, {
                headers: {
                    token: localStorage.getItem('token')
                }
            });
        }

        localStorage.setItem("checkoutItems", JSON.stringify(selectedItems));
        window.location.href = "/payment-page";

    } catch (error) {
        console.error(error);
        alert("Checkout failed. Try again.");
        $(".preloader").delay(90).fadeOut(100).addClass('loaded');
    }
}

$(document).ready(function () {
    CartList();
});
    // Always reload if user comes back from back/forward navigation
    window.addEventListener("pageshow", function (event) {
        if (event.persisted || (window.performance && window.performance.navigation.type === 2)) {
            location.reload();
        }
    });
</script>
