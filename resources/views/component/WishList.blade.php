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


<style>
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

</style>

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

        let stockStatus = product['stock'] == 1 ?
            '<div class="stock-status">In Stock</div>' :
            '<div class="out-of-stock">Out of Stock</div>';

        let EachItem = `<div class="col-lg-3 col-md-4 col-6">
                            <div class="product">
                                <div class="product_img">
                                    <a href="#">
                                        <img src="${product['image']}" alt="product_img9">
                                    </a>
                                    <div class="product_action_box">
                                        <ul class="list_none pr_action_btn">
                                            <li><a href="/details?id=${product['id']}" class="popup-ajax"><i class="icon-magnifier-add"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="product_info">
                                    <h6 class="product_title"><a href="/details?id=${product['id']}">${product['title']}</a></h6>
                                    ${discountSection}
                                    <div class="rating_wrap">
                                        <div class="rating">
                                            <div class="product_rate" style="width:${product['star']}%"></div>
                                        </div>
                                        ${stockStatus}
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
