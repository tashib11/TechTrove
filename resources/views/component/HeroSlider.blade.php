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
    height: 500px;
    position: relative;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
}

.carousel-item::before {
    content: "";
    position: absolute;
    inset: 0;
    background: rgba(0, 0, 0, 0.45);
    z-index: 1;
    transition: background 0.3s ease-in-out;
}

.banner_slide_content {
    position: relative;
    z-index: 2;
    color: #f2f2f2;
    display: flex;
    align-items: center;
    height: 100%;
}

.banner_content {
    text-shadow: 0 1px 3px rgba(0, 0, 0, 0.6);
}

.banner_content h2 {
    font-size: 46px;
    font-weight: 700;
    margin-bottom: 10px;
    line-height: 1.2;
    color: #ffffff;
    animation: fadeInUp 1s ease-out;
}

.banner_content h5 {
    font-size: 22px;
    font-weight: 300;
    margin-bottom: 15px;
    color: #f8f9fa;
    animation: fadeInDown 1s ease-out;
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
    animation: fadeIn 1.2s ease-in;
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
    animation: pulse 1.5s infinite;
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
    <div id="carouselSection" class="carousel-inner">{{--  under this class u have to write carousel items(the slides)--}}
        @if($firstSlider)
        <div class="carousel-item background_bg active" style="background-image: url('{{ $firstSlider->image }}')" data-bg="{{ $firstSlider->image }}">
            <img src="{{ $firstSlider->image }}" alt=" {{ $firstSlider->title }}" style="display:none;">
            <div class="banner_slide_content">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-7 col-10">
                            <div class="banner_content text-start">
                                <h3 class="mb-3 offer-price">{{ $firstSlider->price }}Tk</h3>
                                <h2 class="mb-3 offer-price">{{ $firstSlider->short_des }}</h2>
                                <h2 class="mb-3">{{ $firstSlider->title }}</h2>
                                <a class="btn text-uppercase" href="/details?id={{ $firstSlider->product_id }}">Shop Now</a>
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
 async  function Hero() {
    const section = document.querySelector("#carouselSection");
    const indicators = document.querySelector("#carouselIndicators");

    //to prevent hero() calling before dom loaded into browser
   if (!section) {
        console.warn("carouselSection not ready yet");
        return;
    }
    const cacheKey = "slider_data";
    const cacheTimeKey = "slider_cache_time";
    const expiryLimit = 30 * 60 * 1000; // 30 minutes

    const now = Date.now();
    let cachedData = localStorage.getItem(cacheKey);
    let cacheTime = localStorage.getItem(cacheTimeKey);

    if (cachedData && cacheTime && (now - parseInt(cacheTime)) < expiryLimit) {
        renderSliders(JSON.parse(cachedData));
    } else {
        try {
            let res = await axios.get("/ListProductSlider");
            let sliders = res.data.data;
            localStorage.setItem(cacheKey, JSON.stringify(sliders));
            localStorage.setItem(cacheTimeKey, now.toString());
            renderSliders(sliders);
        } catch (err) {
            console.error("Slider API failed", err);
        }
    }
 }

    function renderSliders(sliders) {
        /*
        virtual Dom (document.createDocumentFragment()) is used to improve performance
         as it is a temporary container and stored in Ram not in browser.
         and finally only one time it is appended to the real DOM.
         This is useful when you have to append multiple elements to the DOM.
        */
        const slideFrag = document.createDocumentFragment();
        const indicatorFrag=document.createDocumentFragment();

        sliders.forEach((item, i) => {
            if (i === 0) return; // 1st slide already loaded in blade

            const slide=document.createElement('div');
            slide.className='carousel-item background_bg';
            slide.setAttribute('data-bg', item.image);
            //data-name is the temporary storing memory system

           slide.innerHTML=`
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
            </div>`;

            slideFrag.appendChild(slide);

            const indicator= document.createElement('button');
            indicator.setAttribute('type', 'button');
            indicator.setAttribute('data-bs-target', '#carouselExampleControls');
            indicator.setAttribute('data-bs-slide-to', i.toString());
            indicator.setAttribute('aria-label', `Slide ${i + 1}`);

            indicatorFrag.appendChild(indicator);

        });
        //only once the main dom is touched
            section.appendChild(slideFrag);
            indicators.appendChild(indicatorFrag);

        // Initialize carousel
        const carouselElement = document.querySelector('#carouselExampleControls');
        const carousel = new bootstrap.Carousel(carouselElement, {
            interval: 5000,
            pause: 'hover',
            ride: 'carousel',//  starts with page laod
            wrap: true// cycling the slides
        });

        // Lazy-load backgrounds (slid.bs.carousel means on change slide)
        carouselElement.addEventListener('slid.bs.carousel', function (event) {
            const items = carouselElement.querySelectorAll('.carousel-item');
            const activeItem = items[event.to];
            if (activeItem.style.backgroundImage === '' && activeItem.dataset.bg) {// element.dataset.name
                activeItem.style.backgroundImage = `url('${activeItem.dataset.bg}')`;
            }
        });
    }

</script>

