<style>
.categories_box {
    width: 100%;
    height: 220px;
    background: #ffffff;
    border: 1px solid #e0e0e0;
    border-radius: 12px;
    padding: 15px 10px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;
    box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.categories_box:hover {
    transform: translateY(-4px);
    box-shadow: 0 6px 12px rgba(0,0,0,0.1);
}

.categories_box img {
    width: 100%;
    height: 130px;
    object-fit: contain;
    margin-bottom: 10px;
    transition: transform 0.3s ease;
}

.categories_box:hover img {
    transform: scale(1.05);
}

.categories_box span {
    font-size: 15px;
    font-weight: 600;
    color: #333;
    line-height: 1.2;
    text-wrap: wrap;
    text-align: center;
}
.category-img-box {
    width: 100%;
    height: 130px;
    display: flex;
    justify-content: center;
    align-items: center;
    background: #f9f9f9;
    border-radius: 8px;
    overflow: hidden;
}
.category-img-box img {
    max-width: 90%;
    max-height: 90%;
    object-fit: contain;
    transition: transform 0.3s ease;
}
.categories_box span {
    font-size: 15px;
    font-weight: 600;
    color: #333;
    line-height: 1.2;
    text-wrap: wrap;
    text-align: center;
    transition: color 0.3s ease;
}

/* Change color only when hovering over the link (the name or image) */
.categories_box a:hover span {
    color: #007bff; /* your desired hover color */
}

</style>

<div class="section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="heading_s4 text-center">
                    <h2>Top Categories</h2>
                </div>
                <p class="text-center leads">Explore the Categories</p>
            </div>
        </div>
        <div id="TopCategoryItem" class="row align-items-center">


        </div>
    </div>
</div>

<script>
    TopCategory();
    async function TopCategory(){
        let res = await axios.get("/CategoryList");
        $("#TopCategoryItem").empty()
        res.data['data'].forEach((item, i) => {
            let EachItem = `
            <div class="p-2 col-6 col-sm-4 col-md-3 col-lg-2">
                <div class="item">
                    <div class="categories_box">
                        <a href="/by-category?id=${item['id']}">
                            <img src="${item['categoryImg']}" alt="${item['categoryName']}"/>
                            <span>${item['categoryName']}</span>
                        </a>
                    </div>
                </div>
            </div>`;
            $("#TopCategoryItem").append(EachItem);
        });
    }
</script>
