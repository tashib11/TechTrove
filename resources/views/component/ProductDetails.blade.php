<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 mb-4 mb-md-0">
       <div class="product-image">
    <!-- Main image container -->
  <div class="product_main_img mb-3 position-relative">
    <img id="product_img1" class="w-100 zoom-image" src='assets/images/product_img1.jpg' data-zoom-image="assets/images/product_img1.jpg" />
</div>


    <!-- Thumbnails row -->
    <div class="row g-2">
        <div class="col-3">
            <img id="img1" class="img-thumbnail thumb-img" src="assets/images/product_small_img3.jpg"/>
        </div>
        <div class="col-3">
            <img id="img2" class="img-thumbnail thumb-img" src="assets/images/product_small_img3.jpg"/>
        </div>
        <div class="col-3">
            <img id="img3" class="img-thumbnail thumb-img" src="assets/images/product_small_img3.jpg"/>
        </div>
        <div class="col-3">
            <img id="img4" class="img-thumbnail thumb-img" src="assets/images/product_small_img3.jpg"/>
        </div>
    </div>
</div>

            </div>
            <div class="col-lg-6 col-md-6">
                <div class="pr_detail">
                    <div class="product_description">
                        <h4 id="p_title" class="product_title"></h4>
                        <h1 id="p_price" class="price"></h1>
                        <h2 id="p_discount_price" class="price text-danger"></h2>
                        <p id="p_stock" class="stock-status"></p>
                    </div>
                    <div>
                        <p id="p_des"></p>
                    </div>
                </div>

                <label class="form-label">Size</label>
                <select id="p_size" class="form-select"></select>

                <label class="form-label">Color</label>
                <select id="p_color" class="form-select"></select>

                <hr />
                <div class="cart_extra">
                    <div class="cart-product-quantity">
                        <div class="quantity">
                            <input type="button" value="-" class="minus">
                            <input id="p_qty" type="text" name="quantity" value="1" title="Qty" class="qty" size="4">
                            <input type="button" value="+" class="plus">
                        </div>
                    </div>
                    <div class="cart_btn">
                        <button onclick="AddToCart()" class="btn btn-fill-out btn-addtocart" type="button"><i class="icon-basket-loaded"></i> Add to cart</button>
                        <a class="add_wishlist" onclick="AddToWishList()" href="#"> <i id="wishIcon" class="icon-heart"></i></a>
                    </div>
                </div>
                <hr />
            </div>
        </div>
    </div>
    <div id="toast-container" style="position: fixed; top: 20px; right: 20px; z-index: 9999;"></div>

</div>

<style>
    .price {
        font-size: 1.5rem;
    }
    .price-discount {
        text-decoration: line-through;
        color: gray;
        text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5);
    }
    .price-discount + .price {
        color: red;
    }
    .no-discount {
        text-decoration: line-through;
        color: gray;
        text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5);
    }
    .stock-status {
        font-size: 1.2rem;
        font-weight: bold;
    }
    .stock-status.in-stock {
        color: green;
    }
    .stock-status.out-of-stock {
        color: red;
    }

     .product_main_img img {
        width: 100%;
        height: auto;
        border-radius: 8px;
        object-fit: contain;
    }

    .thumb-img {
        width: 100%;
        height: 80px;
        object-fit: cover;
        cursor: pointer;
        border-radius: 5px;
        transition: 0.2s ease-in-out;
    }

    .thumb-img:hover {
        transform: scale(1.05);
        border: 2px solid #007bff;
    }

</style>

<script>
    $(document).ready(function() {
        productDetails();
        productReview();
  checkWishlistStatus();
        $('.plus').on('click', function() {
            if ($(this).prev().val()) {
                $(this).prev().val(+$(this).prev().val() + 1);
            }
        });

        $('.minus').on('click', function() {
            if ($(this).next().val() > 1) {
                $(this).next().val(+$(this).next().val() - 1);
            }
        });
    });

    let searchParams = new URLSearchParams(window.location.search);
    let id = searchParams.get('id');

    async function productDetails() {
        let res = await axios.get("/ProductDetailsById/" + id);
        let Details = await res.data['data'];

// Update product images with alt text
$('#product_img1')
    .attr('src', Details[0]['img1'])
    .attr('alt', Details[0]['img1_alt'])
    .attr('data-zoom-image', Details[0]['img1']);

$('#img1').attr('src', Details[0]['img1']).attr('alt', Details[0]['img1_alt']);
$('#img2').attr('src', Details[0]['img2']).attr('alt', Details[0]['img2_alt']);
$('#img3').attr('src', Details[0]['img3']).attr('alt', Details[0]['img3_alt']);
$('#img4').attr('src', Details[0]['img4']).attr('alt', Details[0]['img4_alt']);

        // Product title and price
        $('#p_title').text(Details[0]['product']['title']);
        if (Details[0]['product']['discount']) {
            $('#p_price').text(Details[0]['product']['price']).addClass('price-discount');
            $('#p_discount_price').text("Discount Price: " + Details[0]['product']['discount_price']);
        } else {
            $('#p_price').text(Details[0]['product']['price']);
            $('#p_discount_price').text("No Discount Available").addClass('no-discount');
        }
        document.getElementById('p_des').innerHTML = Details[0]['product']['short_des'];
        document.getElementById('p_details').innerHTML = Details[0]['des'];
        if (Details[0]['product']['stock']) {
            $('#p_stock').text("In Stock").addClass('in-stock');
        } else {
            $('#p_stock').text("Out of Stock").addClass('out-of-stock');
        }

        // Populate sizes and colors
        $("#p_size").empty().append(`<option value=''>Choose Size</option>`);
        Details[0]['size'].split(',').forEach(item => {
            $("#p_size").append(`<option value='${item}'>${item}</option>`);
        });

        $("#p_color").empty().append(`<option value=''>Choose Color</option>`);
        Details[0]['color'].split(',').forEach(item => {
            $("#p_color").append(`<option value='${item}'>${item}</option>`);
        });

        // Reinitialize zoom after image loads
        setTimeout(() => {
            reinitZoom();
        }, 100);

        // Thumbnail click events
        $('#img1').off('click').on('click', function () {
            changeMainImage(Details[0]['img1']);
        });
        $('#img2').off('click').on('click', function () {
            changeMainImage(Details[0]['img2']);
        });
        $('#img3').off('click').on('click', function () {
            changeMainImage(Details[0]['img3']);
        });
        $('#img4').off('click').on('click', function () {
            changeMainImage(Details[0]['img4']);
        });
    }
function changeMainImage(src) {
    const $container = $('.product_main_img');

    // Clear existing zoom
    $('.zoomContainer').remove();

    // Replace image element entirely
let altText = $('#img1[src="' + src + '"]').attr('alt') || '';
$container.html(`<img id="product_img1" class="w-100 zoom-image" src="${src}" alt="${altText}" data-zoom-image="${src}" />`);


    // Reinitialize zoom after image loads
    const newImage = document.getElementById('product_img1');
    newImage.onload = function () {
        $('#product_img1').elevateZoom({
            zoomType: "lens",
            lensShape: "round",
            lensSize: 200,
            scrollZoom: true,
            responsive: true
        });
    };
}
function reinitZoom() {
    const $image = $('#product_img1');
    if ($image.length === 0) return;

    $('.zoomContainer').remove();
    $image.elevateZoom({
        zoomType: "lens",
        lensShape: "round",
        lensSize: 200,
        scrollZoom: true,
        responsive: true
    });
}


    async function productReview() {
        let res = await axios.get("/ListReviewByProduct/" + id);
        let Details = await res.data['data'];
        $("#reviewList").empty();

        Details.forEach(item => {
            let each = `<li class="list-group-item">
                <h6>${item['profile']['cus_name']}</h6>
                <p class="m-0 p-0">${item['description']}</p>
                <div class="rating_wrap">
                    <div class="rating">
                        <div class="product_rate" style="width:${parseFloat(item['rating'])}%"></div>
                    </div>
                </div>
            </li>`;
            $("#reviewList").append(each);
        });
    }

    async function AddToCart() {
        try {
            let p_size = $('#p_size').val();
            let p_color = $('#p_color').val();
            let p_qty = $('#p_qty').val();

            if (!p_size) return showToast("Product size is required!", "error");
if (!p_color) return showToast("Product color is required!", "error");
if (p_qty === "0") return showToast("Quantity must be at least 1!", "error");


            $(".preloader").delay(90).fadeIn(100).removeClass('loaded');
            let res = await axios.post("/CreateCartList", {
                "product_id": id,
                "color": p_color,
                "size": p_size,
                "qty": p_qty
            });
            $(".preloader").delay(90).fadeOut(100).addClass('loaded');
            if (res.status === 200) {
                showToast("Product added to cart successfully!", "success");
            }
        } catch (e) {
            if (e.response.status === 401) {
                sessionStorage.setItem("last_location", window.location.href)
                window.location.href = "/login"
            }
        }
    }

 async function checkWishlistStatus() {
    try {
        let res = await axios.get("/CheckWishListStatus/" + id);
        if (res.status === 200 && res.data.inWishlist) {
            document.getElementById('wishIcon').classList.add('text-success');
        }
    } catch (e) {
        // Optional: only redirect if unauthorized
        if (e.response?.status === 401) {
            // You can skip redirection or handle it silently
        }
    }
}

async function AddToWishList() {
    try {
        $(".preloader").delay(90).fadeIn(100).removeClass('loaded');
        let res = await axios.get("/CreateWishList/" + id);
        $(".preloader").delay(90).fadeOut(100).addClass('loaded');

        if (res.status === 200) {
            if (res.data?.alreadyExists) {
                showToast("Product is already in your wishlist!", "error");
            } else {
                document.getElementById('wishIcon').classList.add('text-success');
                showToast("Product added to wishlist successfully!", "success");
            }
        }
    } catch (e) {
        $(".preloader").delay(90).fadeOut(100).addClass('loaded');
        if (e.response?.status === 401) {
            sessionStorage.setItem("last_location", window.location.href);
            window.location.href = "/login";
        } else {
            showToast("Something went wrong!", "error");
        }
    }
}


  function showToast(message, type = "success") {
    let bgClass = type === 'success' ? 'bg-success text-white' : 'bg-danger text-white';
    let toastHTML = `
        <div class="toast ${bgClass}" role="alert" aria-live="assertive" aria-atomic="true" data-delay="2000">
            <div class="toast-header ${bgClass}">
                <strong class="me-auto">${type === 'success' ? 'Success' : 'Error'}</strong>
                <small class="text-white-50">Just now</small>
                <button type="button" class="btn-close btn-close-white ms-2 mb-1" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">${message}</div>
        </div>`;
    $('#toast-container').append(toastHTML);
    $('.toast').toast('show').on('hidden.bs.toast', function () {
        $(this).remove();
    });
}

    async function AddReview() {
        let reviewText = $('#reviewTextID').val();
        let reviewScore = $('#reviewScore').val();
       if (!reviewScore) return showToast("Rating score is required!", "error");
if (!reviewText) return showToast("Review description is required!", "error");


        $(".preloader").delay(90).fadeIn(100).removeClass('loaded');
        await axios.post("/CreateProductReview", {
            description: reviewText,
            rating: reviewScore,
            product_id: id
        });
        $(".preloader").delay(90).fadeOut(100).addClass('loaded');
        await productReview();
    }
</script>


