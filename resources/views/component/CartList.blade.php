<!-- START SECTION BREADCRUMB -->
<div class="breadcrumb_section bg_gray page-title-mini">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="page-title">
                    <h1>Cart List</h1>
                </div>
            </div>
            <div class="col-md-6">
                <ol class="breadcrumb justify-content-md-end">
                    <li class="breadcrumb-item"><a href="{{url("/")}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">This Page</a></li>
                </ol>
            </div>
        </div>
    </div><!-- END CONTAINER-->
</div>

<div class="mt-5">
    <div class="container my-5">
        <div  class="row">
            <div class="col-12">
                <div class="table-responsive shop_cart_table">
                    <table class="table">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="select-all" checked></th>
                                <th class="product-thumbnail">&nbsp;</th>
                                <th class="product-name">Product</th>
                                <th class="product-quantity">Quantity</th>
                                <th class="product-subtotal">Total</th>
                                <th class="product-remove">Remove</th>
                            </tr>
                            </thead>
                        <tbody id="byList">


                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="6" class="px-0">
                                    <div class="row g-0 align-items-center">
                                        <div class="col-lg-4 col-md-6 mb-3 mb-md-0 d-flex align-items-center">
                                            <div>
                                                <strong>Total:</strong> $<span id="total"></span>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6 mb-3 mb-md-0 text-success text-end" id="savings-text" style="font-weight: 600;">
                                            <!-- Savings text will appear here -->
                                        </div>
                                        <div class="col-lg-4 col-md-6 text-start text-md-end">
                                            <button onclick="CheckOut()" class="btn btn-line-fill btn-sm" type="submit">Check Out</button>
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

        let EachItem = `<tr data-id="${productId}" data-price="${currentPrice}" data-original-price="${originalPrice}" data-discount="${discounted ? 1 : 0}" data-qty="${item['qty']}">
            <td><input class="select-item form-check-input" type="checkbox" checked></td>
            <td class="product-thumbnail">
                <a href="/details?id=${productId}">
                    <img src="${item['product']['image']}" alt="product" style="max-width: 80px;">
                </a>
            </td>
            <td class="product-name">
                <a href="/details?id=${productId}">${item['product']['title']}</a>
            </td>
            <td class="product-quantity">
                <div class="input-group" style="max-width: 120px;">
                    <button class="btn btn-outline-secondary btn-sm qty-decrease" type="button">−</button>
                    <input type="text" class="form-control text-center qty-input" value="${item['qty']}" readonly>
                    <button class="btn btn-outline-secondary btn-sm qty-increase" type="button">+</button>
                </div>
            </td>
            <td class="product-subtotal">${priceHTML}</td>
            <td class="product-remove">
                <a class="remove" data-id="${productId}"><i class="ti-close"></i></a>
            </td>
        </tr>`;

        $("#byList").append(EachItem);
    });

    UpdateTotal();

    $(".remove").on('click', function () {
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

    $("#select-all").on("change", function () {
        $(".select-item").prop("checked", $(this).is(":checked"));
        UpdateTotal();
    });

    $(".select-item").on('change', UpdateTotal);
}

function UpdateTotal() {
    let total = 0;
    let originalTotal = 0;

    $("#byList tr").each(function () {
        let checkbox = $(this).find(".select-item");
        if (checkbox.is(":checked")) {
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
        }
    });

    $("#total").text(total.toFixed(2));

    let savings = originalTotal - total;
    if (savings >0.009) {
        $("#savings-text").html(`You save ${savings.toFixed(2)} Tk`);
    } else {
        $("#savings-text").empty();
    }
}


    async function RemoveCartList(id){
        $(".preloader").delay(90).fadeIn(100).removeClass('loaded');
        let res = await axios.get("/DeleteCartList/" + id);
        $(".preloader").delay(90).fadeOut(100).addClass('loaded');
        if(res.status === 200) {
            await CartList();
        } else {
            alert("Request Fail");
        }
    }

    async function CheckOut() {
        $(".preloader").delay(90).fadeIn(100).removeClass('loaded');

        let selectedItems = [];
        $("#byList tr").each(function () {
            let checkbox = $(this).find(".select-item");
            if (checkbox.is(":checked")) {
                selectedItems.push({
                    id: $(this).data("id"),
                    qty: $(this).attr("data-qty")
                });
            }
        });

        if (selectedItems.length === 0) {
            $(".preloader").delay(90).fadeOut(100).addClass('loaded');
            alert("Please select at least one item to checkout.");
            return;
        }

        // You can store this list in session/localStorage or send via POST to backend
        localStorage.setItem("checkoutItems", JSON.stringify(selectedItems));
        window.location.href = "/payment-page";
    }

    $(document).ready(function () {
        CartList();
    });
</script>
