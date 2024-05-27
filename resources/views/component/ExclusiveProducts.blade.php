<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="heading_s1 text-center">
                <h2>Exclusive Products</h2>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="tab-style1">
                <ul class="nav nav-tabs justify-content-center" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="arrival-tab" data-bs-toggle="tab" href="#Popular" role="tab" aria-controls="arrival" aria-selected="true">Popular</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="sellers-tab" data-bs-toggle="tab" href="#New" role="tab" aria-controls="sellers" aria-selected="false">New</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="featured-tab" data-bs-toggle="tab" href="#Top" role="tab" aria-controls="featured" aria-selected="false">Top</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" id="trending-tab" data-bs-toggle="tab" href="#Trending" role="tab" aria-controls="trending" aria-selected="false">Trending</a>
                    </li>
                </ul>
            </div>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="Popular" role="tabpanel" aria-labelledby="arrival-tab">
                    <div id="PopularItem" class="row shop_container"></div>
                </div>
                <div class="tab-pane fade" id="New" role="tabpanel" aria-labelledby="sellers-tab">
                    <div id="NewItem" class="row shop_container"></div>
                </div>
                <div class="tab-pane fade" id="Top" role="tabpanel" aria-labelledby="featured-tab">
                    <div id="TopItem" class="row shop_container"></div>
                </div>
           
                <div class="tab-pane fade" id="Trending" role="tabpanel" aria-labelledby="trending-tab">
                    <div id="TrendingItem" class="row shop_container"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
  async function renderProducts(containerId, endpoint) {
    let res = await axios.get(endpoint);
    $(containerId).empty();
    res.data['data'].forEach((item, i) => {
        let discountPrice = item['discount'] ? `<span class="discount_price" style="color: blue; font-weight: bold;">$ ${item['discount_price']}</span>` : '';
        let regularPrice = `<span class="price">${discountPrice ? '<del>$ ' + item['price'] + '</del>' : '$ ' + item['price']}</span>`;
        let regularLine = discountPrice ? '' : '<div class="regular">Regular</div>';
        let stockStatus = item['stock'] ? '<span class="stock-status" style="font-size: small;">In Stock</span>' : '<span class="stock-status" style="font-size: small;">Out of Stock</span>';

        let EachItem = `<div class="col-lg-3 col-md-4 col-6">
            <div class="product">
                <div class="product_img">
                    <a href="#">
                        <img src="${item['image']}" alt="product_img9">
                    </a>
                    <div class="product_action_box">
                        <ul class="list_none pr_action_btn">
                            <li><a href="/details?id=${item['id']}" class="popup-ajax"><i class="icon-magnifier-add"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="product_info">
                    <h6 class="product_title"><a  href="/details?id=${item['id']}">${item['title']}</a></h6>
                    <div class="product_price">
                        ${regularPrice}
                        ${regularLine}
                    </div>
                    ${discountPrice}
                    <div class="rating_wrap" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="rating">
                            <div class="product_rate" style="width:${item['star']}%"></div>
                        </div>
                        ${stockStatus}
                    </div>
                </div>
            </div>
        </div>`;
        $(containerId).append(EachItem);
    });
}

async function loadProducts() {
    await renderProducts("#PopularItem", "/ListProductByRemark/popular");
    await renderProducts("#NewItem", "/ListProductByRemark/new");
    await renderProducts("#TopItem", "/ListProductByRemark/top");
    // await renderProducts("#SpecialItem", "/ListProductByRemark/special");
    await renderProducts("#TrendingItem", "/ListProductByRemark/trending");
}

// Call loadProducts when the page loads
$(document).ready(function () {
    loadProducts();
});

</script>
