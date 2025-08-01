<style>
    .brand-card {
        width: 100%;
        height: 220px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        align-items: center;
        text-align: center;
        background: #ffffff;
        border: 1px solid #e0e0e0;
        border-radius: 12px;
        padding: 15px 10px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .brand-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
    }

    .brand-img-box {
        width: 100%;
        height: 140px;
        display: flex;
        justify-content: center;
        align-items: center;
        background: #f8f8f8;
        border-radius: 8px;
        overflow: hidden;
        position: relative;
    }

    .brand-img {
        max-width: 90%;
        max-height: 90%;
        object-fit: cover;
        transform: scale(1.1);
        transition: transform 0.3s ease;
    }

    .brand-card:hover .brand-img {
        transform: scale(1.2);
    }

    .brand-title {
        margin-top: 10px;
        font-size: 16px;
        font-weight: 600;
        color: #333;
    }

    .brand-card span {
        font-size: 15px;
        font-weight: 600;
        color: #333;
        line-height: 1.2;
        text-wrap: wrap;
        text-align: center;
        transition: color 0.3s ease;
    }

    /* Change color only when hovering over the link (the name or image) */
    .brand-card a:hover span {
        color: #007bff;
        /* your desired hover color */
    }
</style>


<div class="section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="heading_s4 text-center">
                    <h2>Top Brands</h2>
                </div>
                <p class="text-center leads">Explore the top Brands.</p>
            </div>
        </div>
        <div id="TopBrandItem" class="row align-items-center">
            @for ($i = 1; $i <= 6; $i++)
                <div class="p-2 col-4 col-sm-4 col-md-3 col-lg-2">
                    <div class="item brand-card placeholder-glow">
                        <div class="brand-img-box">
                            <div class="placeholder col-12" style="height: 100%; background: #e0e0e0;"></div>
                        </div>
                           <span class="placeholder col-6" style="height: 18px; background: #ccc;"></span>
                    </div>
                </div>
            @endfor

        </div>
    </div>


    <script>
        async function TopBrands() {
            let response = await fetch("/BrandList");
            let res = await response.json();
            let brandDiv = document.querySelector("#TopBrandItem");
            brandDiv.innerHTML = "";
            const brandFrag = document.createDocumentFragment();

            res.data.forEach((item, i) => {
                const EachItem = document.createElement('div');
                EachItem.className = 'p-2 col-4 col-sm-4 col-md-3 col-lg-2';
                EachItem.innerHTML = `
         <div class="item brand-card">
        <a href="/by-brand?id=${item['id']}">
            <div class="brand-img-box">
                <img loading="lazy" src="${item['brandImg']}" alt="${item['brandAlt'] || item['brandName']}" class="brand-img"/>
            </div>
            <span class="brand-title">${item['brandName']}</span>
        </a>
</div>`;

                brandFrag.appendChild(EachItem);
            });
            brandDiv.appendChild(brandFrag);
        }
    </script>
