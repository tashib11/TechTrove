<div class="p-2 col-12 col-sm-6 col-md-4 col-lg-3 mb-4 d-flex">
    <a href="/details?id={{ $product->id }}" class="product-link w-100">
        <div class="product w-100">
            <div class="product_img">
                    <img class="prod-img loaded"
                         src="{{ $product->image }}"
                         alt="{{ $product->img_alt }}">
            </div>
            <div class="product_info">
                <h6 class="product_title">{{ $product->title }}</h6>
                <div class="product_price">
                    @if($product->discount)
                        <span class="discount_price text-primary fw-bold">{{ $product->discount_price }}</span>
                        <del class="ms-2">{{ $product->price }}</del>
                    @else
                        <span class="price">{{ $product->price }}</span>
                    @endif
                </div>
                <div class="rating_wrap d-flex justify-content-between align-items-center mt-2">
                    <div class="rating">
                        <div class="star-bg">★★★★★</div>
                        <div class="star-fill" style="width:{{ $product->star }}%">★★★★★</div>
                    </div>
                    <span class="stock-status small {{ $product->stock == '0' ? 'out' : '' }}">
                        {{ $product->stock == '0' ? 'Out of Stock' : $product->stock . ' In Stock' }}
                    </span>
                </div>
            </div>
        </div>
    </a>
</div>
