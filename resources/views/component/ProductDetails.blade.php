@push('p_details')
    <link rel="preload" as="image" href="{{ $product->img1 }}" fetchpriority="high">
@endpush
<style>
    .is-invalid {
        border-color: #dc3545 !important;
        box-shadow: 0 0 0 0.1rem rgba(220, 53, 69, 0.25);
    }

    .quantity-wrapper {
        display: flex;
        align-items: center;
        gap: 1px;
    }

    .qty-input {
        width: 50px;
        text-align: center;
    }

    .price {
        font-size: 1.5rem;
    }

    .price-discount {
        text-decoration: line-through;
        color: gray;
        text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5);
    }

    .price-discount+.price {
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

    #starRating i {
        font-size: 24px;
        cursor: pointer;
        transition: color 0.2s;
        margin-right: 4px;
    }

    .spinner-border-sm {
        width: 1rem;
        height: 1rem;
        border-width: 0.15em;
        margin-left: 6px;
        vertical-align: middle;
        color: #51e0fc;
    }
</style>

<div class="section" id="productDetailsSection">
    {{-- <div class="section"> --}} {{-- IGNORE --}}
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 mb-4 mb-md-0"> {{-- mb-md-0 means fro medium and large screen margin bottom =0  --}}
                <div class="product-image">
                    <div class="product_img_box">
                        <img id="product_img1" class="w-100" src="{{ $product->img1 }}" decoding="async"
                            fetchpriority="high" />
                    </div>
                    <div class="row p-2">
                        <a href="#" class="col-3 product_img_box p-1">
                            <img id="img1" src="{{ $product->img1 }}" loading="lazy" />
                        </a>
                        <a href="#" class="col-3 product_img_box p-1">
                            <img id="img2" src="assets/images/product_small_img3.jpg" loading="lazy" />
                        </a>
                        <a href="#" class="col-3 product_img_box p-1">
                            <img id="img3" src="assets/images/product_small_img3.jpg" alt="product_small_img3"
                                loading="lazy" />
                        </a>
                        <a href="#" class="col-3 product_img_box p-1">
                            <img id="img4" src="assets/images/product_small_img3.jpg" alt="product_small_img3"
                                loading="lazy" />
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="pr_detail">
                    <div class="product_description">
                        <h4 id="p_title" class="product_title">XYZ</h4>
                        <h1 id="p_price" class="price">1254</h1>
                        <h2 id="p_discount_price" class="price text-danger">455</h2>
                        <p id="p_stock" class="stock-status">1 In Stock</p>
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
                        <div class="quantity-wrapper">
                            <button type="button" class="qty-minus">-</button>
                            <input type="text" id="p_qty" class="qty-input" value="1">
                            <button type="button" class="qty-plus">+</button>
                        </div>


                    </div>
                    <div class="cart_btn">
                        <button id="AddToCart" class="btn btn-fill-out btn-addtocart" type="button"><i
                                class="icon-basket-loaded"></i> Add to Cart</button>
                        <a class="add_wishlist" id="AddToWishList" href="#"><i class="bi bi-heart"></i></a>
                    </div>
                </div>
                <hr />
            </div>
        </div>
        {{-- </div>
    </div> --}}

        {{-- Description, review, add review tabs (Initially hidden) --}}
        <div class="container mt-4" id="productTabsContent">
            <div class="row">
                <div class="col-md-12">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="Detail-tab" data-bs-toggle="tab"
                                data-bs-target="#Detail-tab-pane" type="button" role="tab" {{-- without type=buuton, it behaves as defaul submit button --}}
                                aria-controls="Detail-tab-pane" aria-selected="true">Detail</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="review-tab" data-bs-toggle="tab"
                                data-bs-target="#review-tab-pane" type="button" role="tab"
                                aria-controls="review-tab-pane" aria-selected="false">Reviews</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="review_create-tab" data-bs-toggle="tab"
                                data-bs-target="#review_create-tab-pane" type="button" role="tab"
                                aria-controls="review_create-tab-pane" aria-selected="false">Add Review</button>
                        </li>
                    </ul>

                    <div class="tab-content pt-3" id="myTabContent">
                        {{-- Product Full Description --}}
                        <div class="tab-pane fade show active" id="Detail-tab-pane"
                            role="tabpanel"{{-- Fade animation toggle --}} aria-labelledby="Detail-tab" tabindex="0">
                            <div id="p_details"></div>
                        </div>

                        {{-- Product Reviews --}}
                        <div class="tab-pane fade" id="review-tab-pane" role="tabpanel" aria-labelledby="review-tab"
                            tabindex="0">
                            <ul id="reviewList" class="list-group"></ul>
                        </div>

                        {{-- Add Review --}}
                        <div class="tab-pane fade" id="review_create-tab-pane" role="tabpanel"
                            aria-labelledby="review_create-tab" tabindex="0">
                            <div class="mb-3">
                                <label class="form-label">Rating</label>
                                <div id="starRating">
                                    <i class="bi bi-star" data-value="20"></i>
                                    <i class="bi bi-star" data-value="40"></i>
                                    <i class="bi bi-star" data-value="60"></i>
                                    <i class="bi bi-star" data-value="80"></i>
                                    <i class="bi bi-star" data-value="100"></i>
                                </div>
                                <input type="hidden" id="reviewScore" value="">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Review</label>
                                <textarea id="reviewTextID" class="form-control" rows="4" placeholder="Write your review..."></textarea>
                            </div>
                            <p id="revToast" class="d-none" style="color: #0cda1a">Review added</p>
                            <button id="AddReview" class="btn btn-success">Submit Review</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="toast-container" style="position: fixed; top: 20px; left: 20px; z-index: 9999;"></div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const qtyInput = document.getElementById('p_qty');
        const plusBtn = document.querySelector('.qty-plus');
        const minusBtn = document.querySelector('.qty-minus');

        plusBtn.addEventListener('click', function(e) {
            e.preventDefault();
            let val = parseInt(qtyInput.value) || 1;
            qtyInput.value = val + 1;
        });

        minusBtn.addEventListener('click', function(e) {
            e.preventDefault();
            let val = parseInt(qtyInput.value) || 1;
            if (val > 1) {
                qtyInput.value = val - 1;
            }
        });
    });

    // Get the product ID from the URL
    let searchParams = new URLSearchParams(window.location.search);
    let id = searchParams.get('id');

    async function productDetails() {
        let response = await fetch("/ProductDetailsById/" + id);
        let res = await response.json();
        let Detail = await res.data;
        // document.getElementById('product_img1').src = Detail['img1'];
        // document.getElementById('img1').src = Detail['img1'];
        document.getElementById('img2').src = Detail['img2'];
        document.getElementById('img3').src = Detail['img3'];
        document.getElementById('img4').src = Detail['img4'];
        document.getElementById('p_title').innerText = Detail['product']['title'];
        if (Detail['product']['discount']) {
            document.getElementById('p_price').innerText = Detail['product']['price'];
            document.getElementById('p_price').classList.add('price-discount');
            document.getElementById('p_discount_price').innerText = "Discount Price: " + Detail['product'][
                'discount_price'
            ];
        } else {
            document.getElementById('p_price').innerText = Detail['product']['price'];
            document.getElementById('p_discount_price').innerText = "No Discount Available";
            document.getElementById('p_discount_price').classList.add('no-discount');
        }
        document.getElementById('p_des').innerHTML = Detail['product']['short_des'];
        document.getElementById('p_details').innerHTML = Detail['des'];
        if (Detail['product']['stock']) {
            document.getElementById('p_stock').innerText = "In Stock";
            document.getElementById('p_stock').classList.add('in-stock');
        } else {
            document.getElementById('p_stock').innerText = "Out of Stock";
            document.getElementById('p_stock').classList.add('out-of-stock');
        }

        // 1. Get the <select> elements for size and color
        const p_size = document.querySelector("#p_size");
        const p_color = document.querySelector("#p_color");

        // 2. Clear old options
        p_size.innerHTML = '';
        p_color.innerHTML = '';

        // 3. Split incoming string values into arrays
        const sizes = Detail['size'].split(',');
        const colors = Detail['color'].split(',');

        // 4. Add default <option> first
        const defaultSizeOption = document.createElement("option");
        defaultSizeOption.value = "";
        defaultSizeOption.textContent = "Choose Size";
        p_size.appendChild(defaultSizeOption);

        // 5. Append each size option using a loop
        sizes.forEach(size => {
            const opt = document.createElement("option");
            opt.value = size;
            opt.textContent = size;
            p_size.appendChild(opt);
        });

        // 6. Add default <option> for color
        const defaultColorOption = document.createElement("option");
        defaultColorOption.value = "";
        defaultColorOption.textContent = "Choose Color";
        p_color.appendChild(defaultColorOption);

        // 7. Append each color option
        colors.forEach(color => {
            const opt = document.createElement("option");
            opt.value = color;
            opt.textContent = color;
            p_color.appendChild(opt);
        });


        document.querySelector('#img1').addEventListener('click', function() {
            document.getElementById('product_img1').src = Detail['img1'];
        });

        document.querySelector('#img2').addEventListener('click', function() {
            document.getElementById('product_img1').src = Detail['img2'];
        });

        document.querySelector('#img3').addEventListener('click', function() {
            document.getElementById('product_img1').src = Detail['img3'];
        });

        document.querySelector('#img4').addEventListener('click', function() {
            document.getElementById('product_img1').src = Detail['img4'];
        });

    }



    async function productReview() {
        let response = await fetch("/ListReviewByProduct/" + id);
        let res = await response.json();
        let Detail = await res.data;

        let reviewList = document.querySelector("#reviewList");
        reviewList.innerHTML = ''; // Clear previous reviews

        Detail.forEach((item, i) => {
            let reviewDate = new Date(item['created_at']);
            let formattedDate = reviewDate.toLocaleDateString('en-GB', {
                year: 'numeric',
                month: 'short',
                day: 'numeric'
            });
            // Example output: 02 Jul 2025

            let starCount = Math.round(parseFloat(item['rating']) / 20);
            let starsHTML = '';
            for (let i = 1; i <= 5; i++) {
                starsHTML +=
                    `<i class="bi ${i <= starCount ? 'bi-star-fill text-warning' : 'bi-star'}"></i>`;
            }

            let each = document.createElement('li');
            each.className = "list-group-item";
            each.innerHTML = `<div class="mb-1">

        <strong>${item['profile']['cus_name']}</strong>
        <span class="text-muted">${formattedDate}</span>
    </div>
    <div class="mb-1">${starsHTML}</div>
    <p class="m-0 p-0">${item['description']}</p>
`;

            reviewList.append(each);
        })
    }

    document.querySelector('#AddToCart').addEventListener('click', async (e) => {
        e.preventDefault();
        const btn = e.currentTarget;
        setButtonLoading(btn, true);

        const sizeSelect = document.getElementById('p_size');
        const colorSelect = document.getElementById('p_color');
        const qty = document.getElementById('p_qty').value;

        let valid = true;

        // Reset invalid styles
        sizeSelect.classList.remove('is-invalid');
        colorSelect.classList.remove('is-invalid');

        if (!sizeSelect.value) {
            sizeSelect.classList.add('is-invalid');
            sizeSelect.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });
            valid = false;
        }

        if (!colorSelect.value) {
            colorSelect.classList.add('is-invalid');
            if (valid) colorSelect.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            }); // only scroll if size was valid
            valid = false;
        }

        if (qty === "0" || parseInt(qty) <= 0) {
            showToast("Quantity must be greater than 0", "error");
            valid = false;
        }

        if (!valid) {
            setButtonLoading(btn, false);
            return;
        }

        // Proceed with cart submission
        let res = await fetch("/CreateCartList", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                product_id: id,
                color: colorSelect.value,
                size: sizeSelect.value,
                qty: qty
            })
        });

        if (res.status === 200) {
            //  Reset dropdowns
            document.getElementById('p_size').value = "";
            document.getElementById('p_color').value = "";
            showToast("Product added to cart", "success");
        } else if (res.status === 401) {
            sessionStorage.setItem("last_location", window.location.href);
            window.location.href = "/login";
            return;
        }

        setButtonLoading(btn, false);
    });

    document.getElementById('p_size').addEventListener('change', function() {
        if (this.value) this.classList.remove('is-invalid');
    });
    document.getElementById('p_color').addEventListener('change', function() {
        if (this.value) this.classList.remove('is-invalid');
    });



    document.getElementById('AddToWishList').addEventListener('click', async (e) => {
        e.preventDefault(); // Prevent default anchor behavior

        const heartIcon = document.querySelector('#AddToWishList i');
        setIconLoading(heartIcon, true);
        let res = await fetch("/CreateWishList/" + id);
        if (res.status === 200) {
            showToast("added to Wishlist", "success");
        } else if (res.status === 401) {
            sessionStorage.setItem("last_location", window.location.href)
            window.location.href = "/login"
        }
        setIconLoading(heartIcon, false);
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

    function setIconLoading(iconWrapper, isLoading) {
        if (isLoading) {
            iconWrapper.setAttribute("data-original-icon", iconWrapper.innerHTML);
            iconWrapper.innerHTML =
                `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`;
        } else {
            iconWrapper.innerHTML = iconWrapper.getAttribute("data-original-icon");
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const stars = document.querySelectorAll('#starRating i');
        const reviewScoreInput = document.getElementById('reviewScore');

        stars.forEach((star, index) => {
            star.addEventListener('click', () => {
                const value = star.getAttribute('data-value');

                // Highlight all stars up to the clicked one
                stars.forEach((s, i) => {
                    if (i <= index) {
                        s.classList.remove('bi-star');
                        s.classList.add('bi-star-fill', 'text-warning');
                    } else {
                        s.classList.remove('bi-star-fill', 'text-warning');
                        s.classList.add('bi-star');
                    }
                });

                // Set the hidden input
                reviewScoreInput.value = value;
            });
        });
    });

    document.querySelector('#AddReview').addEventListener('click', async (e) => {
        e.preventDefault();
        const btn = e.currentTarget;
        setButtonLoading(btn, true);

        let reviewText = document.getElementById('reviewTextID').value;
        let reviewScore = document.getElementById('reviewScore').value;

        if (reviewScore.length === 0) {
            showToast("Star score Required !","error");
            setButtonLoading(btn, false);
        } else if (reviewText.length === 0) {
            showToast("Review Required !","error");
            setButtonLoading(btn, false);
        } else {
            let postBody = {
                description: reviewText,
                rating: reviewScore,
                product_id: id
            }
            let res = await fetch("/CreateProductReview", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(postBody)
            });
            if (res.status === 200) {
                document.getElementById('revToast').classList.remove('d-none');
                setTimeout(() => {
                    document.getElementById('revToast').classList.add('d-none')
                }, 1000);
                setButtonLoading(btn, false);
                await productReview();
            } else if (res.status === 500) {
                sessionStorage.setItem("last_location", window.location.href)
                window.location.href = "/profile";
            } else if (res.status === 401) {
                sessionStorage.setItem("last_location", window.location.href)
                window.location.href = "/login";
            } else if (res.status === 403) {
                showToast("You can only review this product after received.", "error");
            }
            setButtonLoading(btn, false);
        }

    });

    // let reviewLoaded = false;
    document.querySelector('#review-tab').addEventListener('click', async () => {

        await productReview();
        // reviewLoaded = true;

    });
</script>
