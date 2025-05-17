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
                        <a onclick="AddToCart()" class="btn btn-fill-out btn-addtocart" type="button"><i class="icon-basket-loaded"></i> Add to cart</a>
                        <a class="add_wishlist" onclick="AddToWishList()" href="#"> <i id="wishIcon" class="icon-heart"></i></a>
                    </div>
                </div>
                <hr />
            </div>
        </div>

        <!-- Description, review,add review tabs -->
<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="details-tab" data-bs-toggle="tab" data-bs-target="#details-tab-pane" type="button" role="tab" aria-controls="details-tab-pane" aria-selected="true">Details</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="review-tab" data-bs-toggle="tab" data-bs-target="#review-tab-pane" type="button" role="tab" aria-controls="review-tab-pane" aria-selected="false">Reviews</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="review_create-tab" data-bs-toggle="tab" data-bs-target="#review_create-tab-pane" type="button" role="tab" aria-controls="review_create-tab-pane" aria-selected="false">Add Review</button>
                </li>
            </ul>

            <div class="tab-content pt-3" id="myTabContent">
                <!-- Product Full Description -->
                <div class="tab-pane fade show active" id="details-tab-pane" role="tabpanel" aria-labelledby="details-tab" tabindex="0">
                    <div id="p_details"></div>
                </div>

                <!-- Product Reviews -->
                <div class="tab-pane fade" id="review-tab-pane" role="tabpanel" aria-labelledby="review-tab" tabindex="0">
                    <ul id="reviewList" class="list-group"></ul>
                </div>

                <!-- Add Review -->
                <div class="tab-pane fade" id="review_create-tab-pane" role="tabpanel" aria-labelledby="review_create-tab" tabindex="0">
                  <div class="mb-3">
    <label class="form-label">Rating</label>
    <div id="starRating">
        <i class="fa fa-star star" data-value="20"></i>
        <i class="fa fa-star star" data-value="40"></i>
        <i class="fa fa-star star" data-value="60"></i>
        <i class="fa fa-star star" data-value="80"></i>
        <i class="fa fa-star star" data-value="100"></i>
    </div>
    <input type="hidden" id="reviewScore" value="">
</div>

                    <div class="mb-3">
                        <label class="form-label">Review</label>
                        <textarea id="reviewTextID" class="form-control" rows="4" placeholder="Write your review..."></textarea>
                    </div>
                    <button onclick="AddReview()" class="btn btn-success">Submit Review</button>
                </div>
            </div>
        </div>
    </div>
</div>

    </div>
   <div id="toast-container" style="position: fixed; top: 20px; left: 20px; z-index: 9999;"></div>


</div>

<style>
#toast-container {
    position: fixed;
    top: 20px;
    left: 20px;
    z-index: 9999;
    max-width: 300px;
}

.toast-message {
    padding: 10px 16px;
    margin-bottom: 10px;
    border-radius: 5px;
    font-weight: bold;
    color: white;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    transition: opacity 0.4s ease, transform 0.4s ease;
}

/* Toast types */
.toast-message.success {
    background-color: #28a745;
}

.toast-message.error {
    background-color: #dc3545;
}

/* Fade out animation */
.toast-message.fade-out {
    opacity: 0;
    transform: translateX(-20px);
}
</style>

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

#starRating .star {
    font-size: 24px;
    color: #ccc;
    cursor: pointer;
    transition: color 0.3s ease;
}

#starRating .star.hover,
#starRating .star.selected {
    color: #f1c40f;
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

          $('#starRating .star').on('mouseenter', function () {
        const value = parseInt($(this).data('value'));
        highlightStars(value);
    });

    $('#starRating .star').on('mouseleave', function () {
        const selectedValue = parseInt($('#reviewScore').val());
        highlightStars(selectedValue);
    });

    $('#starRating .star').on('click', function () {
        const value = parseInt($(this).data('value'));
        $('#reviewScore').val(value);
        highlightStars(value);
    });

    function highlightStars(value) {
        $('#starRating .star').each(function () {
            const starVal = parseInt($(this).data('value'));
            if (starVal <= value) {
                $(this).addClass('selected');
            } else {
                $(this).removeClass('selected');
            }
        });
    }

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
       let stock = parseInt(Details[0]['product']['stock'] || '0');

if (stock > 0) {
    $('#p_stock')
        .text(`In Stock (${stock} available)`)
        .removeClass('out-of-stock')
        .addClass('in-stock');
} else {
    $('#p_stock')
        .text("Out of Stock")
        .removeClass('in-stock')
        .addClass('out-of-stock');
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
let altText = $(`.thumb-img[src="${src}"]`).attr('alt') || '';

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
        if (e.response?.status === 401) {
            sessionStorage.setItem("last_location", window.location.href);
            window.location.href = "/login";
        } else {
            showToast("Something went wrong!", "error");
        }
    }
}


 function showToast(message, type = "success") {
    const toastContainer = document.getElementById("toast-container");

    const toast = document.createElement("div");
    toast.className = `toast-message ${type}`;
    toast.innerHTML = message;

    toastContainer.appendChild(toast);

    // Automatically remove after 2 seconds
    setTimeout(() => {
        toast.classList.add("fade-out");
        toast.addEventListener('transitionend', () => toast.remove());
    }, 2000);
}




async function AddReview() {
      try {
        let profileCheck = await axios.get('/CheckProfile');
        let hasProfile = profileCheck.data.data.hasProfile;

        if (!hasProfile) {
            // showToast('warning', 'You must create a profile before adding a review.');
            sessionStorage.setItem("last_location", window.location.href);
            window.location.href = "/profile";
            return;
        }
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
    } catch (err) {
        if (err.response?.status === 401) {
            sessionStorage.setItem("last_location", window.location.href);
            window.location.href = "/login";
        }
    }
}

</script>


