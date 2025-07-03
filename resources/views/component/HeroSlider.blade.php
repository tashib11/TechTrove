@push('hero')
<link rel="preload" as="image" href="{{ $first->image }}" fetchpriority="high">
@endpush

<style>
.background_bg {
    background-size: cover;
    background-position: center center;
    background-repeat: no-repeat;
}

@media (min-width: 993px) {
    .carousel-item {
        background-size: contain !important;
        background-repeat: no-repeat;
        background-position: center center;
        background-color: #000;
    }

    .carousel-item::before {
        background: rgba(0, 0, 0, 0.55);
    }
}


.carousel-item {
   min-height: 300px;
    height: auto;
    aspect-ratio: 3 / 1;
      width: 100%;
    /* height: auto; */
    display: block;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    position: relative;
}

.carousel-item::before {
    content: "";
    position: absolute;
    inset: 0;
    background: rgba(0, 0, 0, 0.45);
    z-index: 1;
}

.banner_slide_content {
    position: relative;
    z-index: 2;
    color: #fff;
    display: flex;
    align-items: center;
    height: 100%;
}

.banner_content {
    text-shadow: 0 1px 3px rgba(0, 0, 0, 0.6);
     min-height: 180px;
}

.banner_content h2 {
    font-size: 46px;
    font-weight: 700;
    margin-bottom: 10px;
    line-height: 1.2;
    color: #ffffff;
    /* animation: fadeInUp 1s ease-out; */
}

.banner_content h5 {
    font-size: 22px;
    font-weight: 300;
    margin-bottom: 15px;
    color: #f8f9fa;
    /* animation: fadeInDown 1s ease-out; */
}

.banner_content a.btn {
    padding: 12px 30px;
    font-size: 16px;
    font-weight: 500;
    letter-spacing: 1px;
    background-color: #ff6f61;
    border: none;
    color: #fff;
    margin-top: 20px;
    border-radius: 4px;
    box-shadow: 0 4px 12px rgba(255, 111, 97, 0.4);
    transition: all 0.3s ease;
    text-decoration: none;
    /* animation: fadeIn 1.2s ease-in; */
}

.banner_content a.btn:hover {
    background-color: #e95b50;
    color: #fff;
    box-shadow: 0 6px 18px rgba(255, 111, 97, 0.5);
}

/* Responsive adjustments */
@media (max-width: 992px) {
    .carousel-item {
        height: 350px;
    }

    .banner_content h2 {
        font-size: 32px;
    }

    .banner_content h5 {
        font-size: 18px;
    }
}

@media (max-width: 576px) {
    .carousel-item {
        height: 290px;
    }

    .banner_content h2 {
        font-size: 18px;
    }

    .banner_content h5 {
        font-size: 14px;
    }

    .banner_content a.btn {
        padding: 6px 14px;
        font-size: 13px;
        margin-bottom: 50px;
    }
}

/* Simple fade animations */
@keyframes fadeInUp {
    0% {
        opacity: 0;
        transform: translateY(20px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeInDown {
    0% {
        opacity: 0;
        transform: translateY(-20px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeIn {
    0% {
        opacity: 0;
        transform: scale(0.95);
    }
    100% {
        opacity: 1;
        transform: scale(1);
    }
}

.offer-price {
    font-size: 42px;
    font-weight: 700;
    color: #ffdd57;
    background-color: rgba(0, 0, 0, 0.65);
    display: inline-block;
    padding: 10px 20px;
    border-radius: 8px;
    box-shadow: 0 6px 16px rgba(255, 221, 87, 0.5);
    /* animation: pulse 1.5s infinite; */
    line-height: 1.3;
    text-transform: uppercase;
}


/* Optional animation to attract more attention */
@keyframes pulse {
    0% {
        transform: scale(1);
        opacity: 1;
    }
    50% {
        transform: scale(1.05);
        opacity: 0.9;
    }
    100% {
        transform: scale(1);
        opacity: 1;
    }
}

</style>

{{--  carousel slide is the sliding system --}}

<div id="carouselExampleControls" class="carousel slide carousel-fade">
    <div id="carouselSection" class="carousel-inner">
        @if($first)
        <div class="carousel-item background_bg active" style="background-image: url('{{ $first->image }}');">
    <img src="{{ $first->image }}" alt="{{ $first->title }}"
         style="width:100%; height:auto; position:absolute; inset:0; opacity:0;"
         fetchpriority="high" decoding="async">

            <div class="banner_slide_content">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-7 col-10">
                            <div class="banner_content text-start">
                                <h3 class="mb-3 offer-price">{{ $first->price }}Tk</h3>
                                <h2 class="mb-3 offer-price">{{ $first->short_des }}</h2>
                                <h2 class="mb-3">{{ $first->title }}</h2>
                                <a class="btn text-uppercase" href="/details?id={{ $first->product_id }}">Shop Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    <div id="carouselIndicators" class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleControls" data-bs-slide-to="0" class="active"></button>
    </div>
</div>

<script>
    const fetchSliders = async () => {
    const res = await fetch("/ListProductSlider");
    if (!res.ok) throw new Error("Network error");
    const json = await res.json();
    return json.data;
};

async function Hero() {
    const section = document.querySelector("#carouselSection");
    const indicators = document.querySelector("#carouselIndicators");

    if (!section) {
        console.warn("carouselSection not found");
        return;
    }

    const cacheTimeKey = "slider_cache_time";
    const expiryLimit = 30 * 60 * 1000; // 30 minutes
    const now = Date.now();
    const cacheTime = localStorage.getItem(cacheTimeKey);
    const cachedData = await getFromDB("hero");

    if (cachedData.length > 0 && cacheTime && now - parseInt(cacheTime) < expiryLimit) {
        renderSliders(cachedData, section, indicators);
    } else {
        try {
            const sliders = await fetchSliders();
            renderSliders(sliders, section, indicators);
            saveToDB("hero", sliders);
            localStorage.setItem(cacheTimeKey, now.toString());
        } catch (err) {
            console.error("Slider fetch failed:", err);
        }
    }
}

function renderSliders(sliders, section, indicators) {
    const slideFrag = document.createDocumentFragment();
    const indicatorFrag = document.createDocumentFragment();

    sliders.forEach((item, i) => {
        if (i === 0) return;

        const slide = document.createElement("div");
        slide.className = "carousel-item background_bg";
        slide.dataset.bg = item.image;

        slide.innerHTML = `
            <div class="banner_slide_content">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-7 col-10">
                            <div class="banner_content text-start">
                                <h3 class="mb-3 offer-price">${item.price}Tk</h3>
                                <h2 class="mb-3 offer-price">${item.short_des}</h2>
                                <h2 class="mb-3">${item.title}</h2>
                                <a class="btn text-uppercase" href="/details?id=${item.product_id}">Shop Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;

        slideFrag.appendChild(slide);

        const indicator = document.createElement("button");
        indicator.type = "button";
        indicator.dataset.bsTarget = "#carouselExampleControls";
        indicator.dataset.bsSlideTo = i.toString();
        indicator.setAttribute("aria-label", `Slide ${i + 1}`);
        indicatorFrag.appendChild(indicator);
    });

    section.appendChild(slideFrag);
    indicators.appendChild(indicatorFrag);

    const carouselElement = document.querySelector("#carouselExampleControls");
    const carousel = new bootstrap.Carousel(carouselElement, {
        interval: 5000,
        pause: 'hover',
        ride: false,
        wrap: true
    });

    setTimeout(() => carousel.cycle(), 500);

    carouselElement.addEventListener("slid.bs.carousel", function (event) {
        const items = carouselElement.querySelectorAll(".carousel-item");
        const activeItem = items[event.to];
        if (!activeItem.style.backgroundImage && activeItem.dataset.bg) {
            activeItem.style.backgroundImage = `url('${activeItem.dataset.bg}')`;
        }
    });
}
</script>
