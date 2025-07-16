<!-- START SECTION BREADCRUMB -->
<div class="breadcrumb_section bg_gray page-title-mini py-2">
    <div class="container">
        <div class="row align-items-center justify-content-center" style="min-height: 40px;">
            <div class="col-md-6 text-center">
                <ol class="breadcrumb m-0 p-0 justify-content-center">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li class="mx-2">&gt;</li>
                    <li>Wishlist</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="mt-5">
    <div class="container my-5">
        <div id="byList" class="row">
            @for ($i = 1; $i < 5; $i++)
                <div class="p-2 col-12 col-sm-6 col-md-4 col-lg-3 mb-4 d-flex">
                    <div class="product w-100">
                        <div class="product_img placeholder-glow">
                            <div class="placeholder col-12" style="height: 100%; background: #e0e0e0;"></div>
                        </div>
                        <div class="product_info">
                            <h6 class="product_title placeholder-glow">
                                <span class="placeholder col-8"></span>
                            </h6>
                            <div class="product_price placeholder-glow">
                                <span class="placeholder col-4"></span>
                            </div>

                            <div class="rating_wrap d-flex justify-content-between align-items-center mt-2">
                                <div class="rating">
                                    <div class="star-bg">★★★★★</div>
                                    <div class="star-fill" style="width:0%">★★★★★</div>
                                </div>
                                <span class="stock-status small"></span>
                            </div>
                        </div>
                    </div>
                </div>
            @endfor

        </div>
    </div>
</div>

{{-- <style>
    /* Offcanvas adjustments for mobile */
    @media (max-width: 576px) {
        #filterOffcanvas {
            width: 60% !important;
        }

        #filterOffcanvas .offcanvas-body {
            max-height: calc(100vh - 120px);
            overflow-y: auto;
            padding-bottom: 80px;
        }

        #filterOffcanvas .btn {
            position: sticky;
            bottom: 10px;
            z-index: 5;
        }

        .product_img {
            padding-top: 120%;
            /* Better aspect on mobile */
        }
    }

    /* Unified top bar layout */
    .top-bar {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    @media (min-width: 576px) {
        .top-bar {
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
        }
    }

    .rating {
        position: relative;
        display: inline-block;
        line-height: 1;
        color: #e0e0e0;
        font-family: Arial, sans-serif;
    }

    .rating .star-bg,
    .rating .star-fill {
        font-size: 20px;

        display: inline;
        padding: 0;
        margin: 0;
        border: none;
        background: none;
        box-shadow: none;
        line-height: 1;
        vertical-align: middle;
        outline: none;
    }

    .rating .star-fill {
        color: #F6BC3E;
        overflow: hidden;
        position: absolute;
        top: 0;
        left: 0;
        white-space: nowrap;
        width: 0;
        pointer-events: none;
        outline: none;
    }



    /* Offcanvas iOS fix */
    .offcanvas-body {
        -webkit-overflow-scrolling: touch;
    }

    /* Product Card Layout */
    .product {
        height: 100%;
        border: 1px solid #e0e0e0;
        border-radius: 10px;
        overflow: hidden;
        transition: box-shadow 0.3s ease;
        display: flex;
        flex-direction: column;
        background: #fff;
    }

    .product:hover {
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .product_img {
        width: 100%;
        aspect-ratio: 1 / 1;
        padding-top: 100%;
        position: relative;
        overflow: hidden;
        background: #f9f9f9;
    }

    .product_img img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .prod-img {
        width: 100%;
        height: 130px;
        object-fit: cover;
        filter: blur(10px);
        transition: filter 0.4s ease, transform 0.3s ease, opacity 0.3s ease;
        opacity: 0.7;
    }

    .prod-img.loaded {
        filter: blur(0);
        opacity: 1;

    }

    /* Product content section */
    .product_info {
        padding: 10px 15px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    /* Product title */
    .product_title {
        font-size: 1rem;
        /* Default size */
        font-weight: 600;
        line-height: 1.3;
        min-height: 2.6em;
        /* enough space for 2 lines */
        overflow: hidden;
    }

    /* Price styling */
    .product_price {
        font-size: 1.1rem;
        margin-top: 0;
        font-weight: bold;
    }

    .discount_price {
        color: #007bff;
        font-weight: bold;
    }

    del {
        color: #888;
        font-size: 0.9rem;
    }



    /* Stock status */
    .stock-status {
        font-size: 0.8rem;
        color: #28a745;
        font-weight: bold;
    }

    .stock-status.out {
        color: #28a745;
    }
.remove {
  margin-top: auto;
  padding: 6px 12px;
  background: red;
  color: white;
  border: none;
  border-radius: 5px;
  font-size: 0.875rem;
  cursor: pointer;
}
    @media (max-width: 576px) {


        .rating_wrap {
            flex-direction: row;
            flex-wrap: wrap;
            gap: 4px;
            align-items: center;
        }

        .product_img {
            /* padding-top: 100%; */
            aspect-ratio: 1 / 1;
            /* Make image area much taller */
        }

        .product_info {
            padding: 8px 10px;
        }

        .product_title {
            font-size: 1.1rem;
            min-height: 2.1em;
        }

        .product_price {
            font-size: 1.5rem;
        }

        .stock-status {
            font-size: 1rem;
        }
    }


    /* Remove up/down arrows for number inputs in all browsers */
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type=number] {
        -moz-appearance: textfield;
        /* Firefox */
    }

    a.product-link {
        text-decoration: none;
        /* color: inherit; */
        display: block; //By default, <a> is inline, so display: block ensures the link stretches over the entire card
    }
</style> --}}
<style>
    .clickable-card {
        cursor: pointer;
    }

    @media (max-width: 576px) {
        .product_img {
            padding-top: 120%;
            /* Better aspect on mobile */
        }

        .rating_wrap {
            flex-direction: row;
            flex-wrap: wrap;
            gap: 4px;
            align-items: center;
        }

        .product_info {
            padding: 8px 10px;
        }

        .product_title {
            font-size: 1.1rem;
            min-height: 2.1em;
        }

        .product_price {
            font-size: 1.5rem;
        }

        .stock-status {
            font-size: 1rem;
        }
    }

    .rating {
        position: relative;
        display: inline-block;
        line-height: 1;
        color: #e0e0e0;
        font-family: Arial, sans-serif;
    }

    .rating .star-bg,
    .rating .star-fill {
        font-size: 20px;
        display: inline;
        padding: 0;
        margin: 0;
        border: none;
        background: none;
        box-shadow: none;
        line-height: 1;
        vertical-align: middle;
    }

    .rating .star-fill {
        color: #F6BC3E;
        overflow: hidden;
        position: absolute;
        top: 0;
        left: 0;
        white-space: nowrap;
        width: 0;
        pointer-events: none;
    }

    .product {
        height: 100%;
        border: 1px solid #e0e0e0;
        border-radius: 10px;
        overflow: hidden;
        transition: box-shadow 0.3s ease;
        display: flex;
        flex-direction: column;
        background: #fff;
    }

    .product:hover {
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .product_img {
        width: 100%;
        aspect-ratio: 1 / 1;
        padding-top: 100%;
        position: relative;
        overflow: hidden;
        background: #f9f9f9;
    }

    .product_img img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .prod-img {
        width: 100%;
        height: 130px;
        object-fit: cover;
        filter: blur(10px);
        transition: filter 0.4s ease, transform 0.3s ease, opacity 0.3s ease;
        opacity: 0.7;
    }

    .prod-img.loaded {
        filter: blur(0);
        opacity: 1;
    }

    .product_info {
        padding: 10px 15px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .product_title {
        font-size: 1rem;
        font-weight: 600;
        line-height: 1.3;
        min-height: 2.6em;
        overflow: hidden;
    }

    .product_price {
        font-size: 1.1rem;
        font-weight: bold;
    }

    .discount_price {
        color: #007bff;
        font-weight: bold;
    }

    del {
        color: #888;
        font-size: 0.9rem;
    }

    .stock-status {
        font-size: 0.8rem;
        color: #28a745;
        font-weight: bold;
    }

    .stock-status.out {
        color: #28a745;
    }

    .remove {
        margin-top: auto;
        padding: 6px 12px;
        background: red;
        color: white;
        border: none;
        border-radius: 5px;
        font-size: 0.875rem;
        cursor: pointer;
    }

    a.product-link {
        text-decoration: none;
        display: block;
    }
</style>


<script>
    // Wishlist function to render products
    async function WishList() {
        let response = await fetch(`/ProductWishList`);
        let res = await response.json();
        let productDom = document.querySelector('#byList');
        productDom.innerHTML = '';
        let data = res.data;
        const productFragment = document.createDocumentFragment();
        if (data.length == 0) {
            const EachItem = document.createElement('div');
            EachItem.className = 'col-12 text-center my-10';
            EachItem.innerHTML = `   <h4 style="color: #007bff">No Product found, Look into other section</h4>`;
            productFragment.appendChild(EachItem);
        } else {
            data.forEach(item => {
                let product = item['product'];
                const EachItem = document.createElement('div');
                EachItem.className = 'p-2 col-12 col-sm-6 col-md-4 col-lg-3 mb-4 d-flex';
                EachItem.innerHTML = `
  <div class="product w-100 clickable-card" data-link="/details?id=${product.id}">
    <div class="product_img">
      <img class="prod-img"
        width="250" height="250"
        src="data:image/webp;base64,UklGRiQAAABXRUJQVlA4IBgAAAAwAQCdASoKAAoAAUAmJaQAA3AA/vshgAA="
        loading="lazy"
        data-src="${product.image}"
        alt="${product.img_alt}">
      <div class="product_action_box">
        <ul class="list_none pr_action_btn">
          <li><i class="bi-eye"></i></li>
        </ul>
      </div>
    </div>
    <div class="product_info">
      <h6 class="product_title">${product.title}</h6>
      <div class="product_price">
        ${product.discount ? `
              <span class="discount_price text-primary fw-bold">${product.discount_price}</span>
              <del class="ms-2">${product.price}</del>
            ` : `
              <span class="price">${product.price}</span>
            `}
      </div>
      <div class="rating_wrap d-flex justify-content-between align-items-center mt-2">
        <div class="rating">
          <div class="star-bg">★★★★★</div>
          <div class="star-fill" style="width:${product.star}%">★★★★★</div>
        </div>
        <span class="stock-status small ${product.stock == '0' ? 'out' : ''}">
          ${product.stock == '0' ? 'Out of Stock' : `${product.stock} In Stock`}
        </span>
      </div>
      <button class="btn remove btn-sm my-2 btn-fill-out" data-id="${product['id']}">Remove</button>
    </div>
  </div>
`;


                productFragment.appendChild(EachItem);
            });
        }
        productDom.appendChild(productFragment);
        if (data.length > 0) lazyLoadImages();
        // Attach remove event to each remove button
        document.querySelectorAll('.remove').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                RemoveWishList(id);
            });
        });
        document.querySelectorAll('.clickable-card').forEach(card => {
            card.addEventListener('click', function(e) {
                // Prevent clicking if it's the remove button
                if (!e.target.closest('.remove')) {
                    window.location.href = this.dataset.link;
                }
            });
        });
    }



    function lazyLoadImages() {
        const images = document.querySelectorAll('img.prod-img');
        if ('IntersectionObserver' in window) {
            const observer = new IntersectionObserver((entries, obs) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        const src = img.dataset.src;
                        const realImg = new Image();
                        realImg.src = src;
                        realImg.onload = () => {
                            img.src = src;
                            img.classList.add('loaded');
                            obs.unobserve(img);
                        };
                    }
                });
            }, {
                threshold: 0.1
            });
            images.forEach(img => observer.observe(img));
        } else {
            images.forEach((img) => {
                const src = img.dataset.src;
                const realImg = new Image();
                realImg.src = src;
                realImg.onload = () => {
                    img.src = src;
                    img.classList.add('loaded');
                };
            });
        }
    }
    // Remove wishlist item
    async function RemoveWishList(id) {
        let res = await fetch("/RemoveWishList/" + id);
        if (res.status === 200) {
            await WishList(); // Refresh list
        } else {
            showToast("Try again later","error");
        }
    }
</script>
