<style>
    .categories_box {
        width: 100%;
        height: 220px;
        background: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 12px;
        padding: 12px 10px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .categories_box:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
    }

    .category-img-box {
        width: 100%;
        height: 120px; /* Fixed to prevent layout shift */
        background: #f5f5f5;
        border-radius: 10px;
        overflow: hidden;
        display: flex;
        justify-content: center;
        align-items: center;
        margin-bottom: 8px;
    }

    .category-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 0.3s ease;
    }

    .categories_box:hover .category-img {
        transform: scale(1.05);
    }

    .categories_box span {
        font-size: 15px;
        font-weight: 600;
        color: #333;
        line-height: 1.3;
        text-align: center;
        min-height: 40px;
        display: block;
    }



    @media (max-width: 575.98px) {
        .categories_box {
            height: 180px;
        }

        .category-img-box {
            height: 80px;
        }

        .categories_box span {
            font-size: 13px;
        }
    }
</style>

<div class="section">
    <div class="container">
        <div class="row justify-content-center text-center mb-3">
            <div class="col-md-6">
                <h2>Top Categories</h2>
                <p class="text-muted">Explore the Categories</p>
            </div>
        </div>
        <div id="TopCategoryItem" class="row g-2 align-items-stretch">
            @for ($i = 0; $i < 6; $i++)
                <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                    <div class="categories_box placeholder-glow">
                        <div class="category-img-box">
                            <div class="placeholder col-12" style="height: 100%; background: #e0e0e0;"></div>
                        </div>
                        <span class="placeholder col-6" style="height: 18px; background: #ccc;"></span>
                    </div>
                </div>
            @endfor
        </div>
    </div>
</div>

<script>
    async function TopCategory() {
        const section = document.querySelector("#TopCategoryItem");

        const cacheTimeKey = "category_cache_time";
        const expiryLimit = 30 * 60 * 1000;
        const now = Date.now();
        const cacheTime = localStorage.getItem(cacheTimeKey);
        const cachedData = await getFromDB("category");

        if (cachedData.length > 0 && cacheTime && (now - parseInt(cacheTime)) < expiryLimit) {
            renderTopCategories(cachedData.slice(0, 6), section, true);
            requestIdleCallback(() => renderTopCategories(cachedData.slice(6), section));
        } else {
            try {
                let response = await fetch("/CategoryList");
                let res = await response.json();
                const categories = res.data;
                renderTopCategories(categories.slice(0, 6), section, true);
                requestIdleCallback(() => renderTopCategories(categories.slice(6), section));
                saveToDB("category", categories);
                localStorage.setItem(cacheTimeKey, now.toString());
            } catch (err) {
                console.error("Category API failed", err);
            }
        }
    }

    function renderTopCategories(data, section, isAboveFold = false) {
        const frag = document.createDocumentFragment();
        data.forEach(item => {
            const col = document.createElement("div");
            col.className = "col-4 col-sm-4 col-md-3 col-lg-2";
            col.innerHTML = `
            <div class="categories_box">
                <a href="/by-category?id=${item.id}" class="text-decoration-none" aria-label="View ${item.categoryName}">
                    <div class="category-img-box">
                        <img class="category-img"
                             src="data:image/webp;base64,UklGRiQAAABXRUJQVlA4IBgAAAAwAQCdASoKAAoAAUAmJaQAA3AA/vshgAA="
                             data-src="${item.categoryImg}"
                             alt="${item.categoryAlt || item.categoryName}"
                             loading="lazy"
                             decoding="async"
                             fetchpriority="${isAboveFold ? 'high' : 'low'}"
                             width="130"
                             height="160" />
                    </div>
                    <span>${item.categoryName}</span>
                </a>
            </div>`;
            frag.appendChild(col);
        });
        if (isAboveFold) section.innerHTML = "";
        section.appendChild(frag);
        lazyLoadCategoryImages();
    }

    function lazyLoadCategoryImages() {
        const images = document.querySelectorAll("img.category-img");
        if ("IntersectionObserver" in window) {
            const observer = new IntersectionObserver((entries, obs) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        const src = img.dataset.src;
                        const temp = new Image();
                        temp.src = src;
                        temp.onload = () => {
                            img.src = src;
                            img.classList.add("loaded");
                            obs.unobserve(img);
                        };
                    }
                });
            }, {
                rootMargin: "100px",
                threshold: 0.01
            });
            images.forEach(img => observer.observe(img));
        } else {
            // Fallback for older browsers
            images.forEach(img => {
                const src = img.dataset.src;
                const real = new Image();
                real.src = src;
                real.onload = () => {
                    img.src = src;
                    img.classList.add("loaded");
                };
            });
        }
    }
</script>
