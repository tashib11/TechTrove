<style>
/* General product card styling */
.product {
  height: 100%;
  display: flex;
  flex-direction: column;
  border: 1px solid #e0e0e0;
  border-radius: 10px;
  overflow: hidden;
  background: #fff;
  transition: box-shadow 0.3s ease;
  position: relative;
}

.product:hover {
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

/* Image section */
.product_img {
  position: relative;
  width: 100%;
  padding-top: 100%; /* 1:1 ratio */
  background: #f9f9f9;
}

.product_img img {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  object-fit: contain;
}

/* Info section */
.product_info {
  flex-grow: 1;
  padding: 15px;
  display: flex;
  flex-direction: column;
  justify-content: flex-start;
  text-align: center;
}

.product_title {
  font-size: 1rem;
  font-weight: 600;
  line-height: 1.3;
  min-height: 2.6em;
  margin-bottom: 8px;
  overflow: hidden;
}

.product_price {
  font-size: 1rem;
  margin-bottom: 5px;
}

.discount-price {
  color: #007bff;
  font-weight: bold;
  display: block;
}

.price-discount {
  text-decoration: line-through;
  color: gray;
}

.no-discount {
  color: gray;
  text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);
}

/* Stock info */
.stock-status {
  color: #28a745;
  font-size: 0.85rem;
  font-weight: bold;
}

.out-of-stock {
  color: #28a745;

}

.rating_wrap {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

/* .product_rate {
  width: 80px;
  height: 10px;
  background: gold;
} */

.stock {
  font-size: 0.85rem;
  white-space: nowrap;
}


/* Remove button */
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



/* Equal card height layout fix */
#byList .col-lg-3,
#byList .col-md-4,
#byList .col-6 {
  display: flex;
  flex-direction: column;
}

#byList .product {
  flex-grow: 1;
}

/* Responsive */
@media (max-width: 576px) {
  .product_title {
    font-size: 1rem;
    min-height: auto;
  }

  .product_info {
    padding: 10px;
  }

  .remove {
    padding: 5px 10px;
  }
    .rating_wrap {
  flex-direction: row;
    flex-wrap: wrap;
    gap: 4px;
    align-items: center;
  }

  .rating {
    flex-shrink: 0;
    display: flex;
    align-items: center;
  }

  /* .product_rate {
    width: 60px;
    height: 10px;
    background: gold;
  } */

  .stock {
    font-size: 0.75rem;
    white-space: nowrap;
    text-align: right;
    flex-grow: 1;
  }
}
</style>



<!-- START SECTION BREADCRUMB -->
<div class="breadcrumb_section bg_gray page-title-mini">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="page-title">
                    <h1>Wish List</h1>
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
        <div id="byList" class="row">
        </div>
    </div>
</div>


{{-- <style>
   .price {
    font-size: 1.5rem;
}
.price-discount {
    text-decoration: line-through;
    color: gray;
    text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5);
}
.discount-price {
    color: blue;
    font-weight: bold;
    display: block;
}
.no-discount {
    color: gray;
    text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5);
}
.stock-status {
    color: green;
    font-weight: bold;
    display: block;
}
.out-of-stock {
    color: red;
    font-weight: bold;
    display: block;
}
.product_img {
    position: relative;
}
.product_img img {
    width: 100%;
}
.product_action_box {
    position: absolute;
    top: 10px;
    right: 10px;
    display: none;
}
.product:hover .product_action_box {
    display: block;
}
.product_action_box ul {
    list-style: none;
    padding: 0;
    margin: 0;
}
.product_action_box ul li {
    margin: 5px 0;
}
.product_info {
    padding: 10px;
    text-align: center;
}
.product_title {
    font-size: 1rem;
    font-weight: bold;
}
.rating_wrap {
    margin: 10px 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.product_rate {
    background: gold;
    height: 10px;
    display: inline-block;
}
.remove {
    margin-top: 10px;
    display: inline-block;
    padding: 5px 10px;
    background: red;
    color: white;
    border: none;
    cursor: pointer;
}
.product_action_box {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  display: none;
  z-index: 2;
}


</style> --}}

<script>
 async function WishList(){
    let res = await axios.get(`/ProductWishList`);
    $("#byList").empty();
    res.data['data'].forEach((item, i) => {
        let product = item['product'];
        let discountSection = '';

        if (product['discount']) {
            discountSection = `
                <div class="product_price">
                    <span class="price price-discount">$${product['price']}</span>
                    <span class="price discount-price">$${product['discount_price']}</span>
                </div>`;
        } else {
            discountSection = `
                <div class="product_price">
                    <span class="price">$${product['price']}</span>
                    <div class="no-discount">Regular</div>
                </div>`;
        }
let stock = parseInt(product['stock']);
let stockStatus = stock > 0
    ? `<span class="stock-status">In Stock (${stock})</span>`
    : `<span class="out-of-stock">Out of Stock</span>`;



       let EachItem = `<div class="col-lg-3 col-md-4 col-6">
                    <div class="product">
                        <div class="product_img">
                            <a href="#">
                                <img src="${product['image']}" alt="${product['img_alt']}">
                            </a>
                            <div class="product_action_box">
                    <ul class="list_none pr_action_btn">
                        <li><a href="/details?id=${product['id']}" class="popup-ajax"><i class="icon-magnifier-add"></i></a></li>
                    </ul>
                </div>
                        </div>
                        <div class="product_info">
                            <h6 class="product_title">
                                <a href="/details?id=${product['id']}">${product['title']}</a>
                            </h6>
                            ${discountSection}
                            <div class="rating_wrap d-flex justify-content-between align-items-center mt-2">
    <div class="rating d-flex align-items-center">
        <div class="product_rate" style="width:${product['star']}%"></div>
    </div>
    <div class="stock text-end">${stockStatus}</div>
</div>

                            <button class="btn remove btn-sm my-2 btn-danger" data-id="${product['id']}">Remove</button>
                        </div>
                    </div>
                </div>`;

        $("#byList").append(EachItem);
    });

    $(".remove").on('click', function () {
        let id = $(this).data('id');
        RemoveWishList(id);
    });
}

async function RemoveWishList(id) {
    $(".preloader").delay(90).fadeIn(100).removeClass('loaded');
    let res = await axios.get("/RemoveWishList/" + id);
    $(".preloader").delay(90).fadeOut(100).addClass('loaded');
    if (res.status === 200) {
        await WishList();
    } else {
        alert("Request Fail");
    }
}

$(document).ready(function() {
    WishList();
});

</script>
