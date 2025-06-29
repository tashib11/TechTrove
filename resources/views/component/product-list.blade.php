@if ($products->isEmpty())
    <div class="col-12 text-center my-4">
        <h5>No products found.</h5>
        <p>Look into other <strong>Sections</strong>.</p>
    </div>
@else
    @foreach($products as $item)
<div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4 d-flex">

    <div class="product w-100">
                <div class="product_img">
                    <a href="/details?id={{ $item->id }}">
                        <img loading="lazy"  src="{{ $item->image }}" alt="{{ $item->img_alt }}">
                    </a>
                    <div class="product_action_box">
                        <ul class="list_none pr_action_btn">
                            <li><a href="/details?id={{ $item->id }}"><i class="icon-magnifier-add"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="product_info">
                    <h6 class="product_title"><a href="/details?id={{ $item->id }}">{{ $item->title }}</a></h6>
                    <div class="product_price">
                        @if($item->discount)
                            <span class="discount_price text-primary fw-bold">${{ $item->discount_price }}</span>
                            <del class="ms-2">${{ $item->price }}</del>
                        @else
                            <span class="price">${{ $item->price }}</span>
                        @endif
                    </div>
                    <div class="rating_wrap d-flex justify-content-between align-items-center mt-2">
                        <div class="rating">
                            <div class="product_rate" style="width:{{ $item->star }}%"></div>
                        </div>
                      <span class="stock-status small {{ $item->stock == '0' ? 'out' : '' }}">
    {{ $item->stock == '0' ? 'Out of Stock' : $item->stock . ' In Stock' }}
</span>

                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endif
