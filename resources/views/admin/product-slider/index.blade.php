@extends('admin.layouts.app')

@section('content')
<div class="container mt-4">
    <h3 class="mb-3">Product Sliders</h3>

    <button class="btn btn-primary mb-3" onclick="openAddModal()">Add Slider</button>

    <div id="slider-list" class="row row-cols-1 row-cols-md-2 g-4"></div>
</div>

<!-- Slider Modal -->
<div class="modal fade" id="sliderModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="sliderForm" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title">Slider</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="slider-id">

                    <input type="text" id="title" class="form-control mb-2" placeholder="Title" required>
                    <input type="text" id="short_des" class="form-control mb-2" placeholder="Short Description" required>
                    <input type="text" id="price" class="form-control mb-2" placeholder="Price" required>

                 <!-- Image Upload -->
<div class="form-group mb-2">
    <label for="sliderImage">Upload Image</label>
    <small class="text-muted d-block">Recommended: 1600×500 pixels for best display</small>
    <input type="file" class="form-control" id="sliderImage" accept="image/*">
</div>

<!-- Image Preview -->
<div id="imagePreviewCard" class="card mt-2 d-none">
    <img id="imagePreview" class="card-img-top" style="max-height: 200px; object-fit: contain;">
    <div class="card-body">
        <p class="mb-0"><strong>Image Preview</strong></p>
    </div>
</div>


                    <!-- Product Select -->
                    <select id="product_id" class="form-control mb-2">
                        @foreach(\App\Models\Product::all() as $product)
                            <option value="{{ $product->id }}">{{ $product->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Save</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Confirm Delete Modal -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this slider?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Yes, Delete</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    const sliderModal = new bootstrap.Modal(document.getElementById('sliderModal'));
    const deleteModal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));

    const imageInput = document.getElementById('sliderImage');
    const previewCard = document.getElementById('imagePreviewCard');
    const previewImg = document.getElementById('imagePreview');

    let deleteSliderId = null;

    imageInput.addEventListener('change', () => {
        const file = imageInput.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = e => {
                previewCard.classList.remove('d-none');
                previewImg.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });

    function loadSliders() {
        axios.get('/admin/product-slider/all').then(res => {
            let list = res.data.map(slider => `
                <div class="col">
                    <div class="card">
                        <img src="${slider.image}" class="card-img-top" style="height:200px;object-fit:cover">
                        <div class="card-body">
                            <h5>${slider.title}</h5>
                            <p>${slider.short_des}</p>
                            <p><strong>${slider.price}</strong></p>
                            <button class="btn btn-sm btn-warning" onclick='editSlider(${JSON.stringify(slider)})'>Edit</button>
                            <button class="btn btn-sm btn-danger" onclick='confirmDelete(${slider.id})'>Delete</button>
                        </div>
                    </div>
                </div>
            `).join('');
            document.getElementById('slider-list').innerHTML = list;
        });
    }

    function openAddModal() {
        document.getElementById('sliderForm').reset();
        document.getElementById('slider-id').value = '';
        previewCard.classList.add('d-none');
        previewImg.src = '';
        sliderModal.show();
    }

    function editSlider(slider) {
        document.getElementById('slider-id').value = slider.id;
        document.getElementById('title').value = slider.title;
        document.getElementById('short_des').value = slider.short_des;
        document.getElementById('price').value = slider.price;
        document.getElementById('product_id').value = slider.product_id;
        previewCard.classList.remove('d-none');
        previewImg.src = slider.image;
        sliderModal.show();
    }

    function confirmDelete(id) {
        deleteSliderId = id;
        deleteModal.show();
    }

    document.getElementById('confirmDeleteBtn').addEventListener('click', () => {
        if (deleteSliderId) {
            axios.delete(`/admin/product-slider/delete/${deleteSliderId}`).then(() => {
                deleteModal.hide();
                loadSliders();
            });
        }
    });

    document.getElementById('sliderForm').addEventListener('submit', function (e) {
        e.preventDefault();

        let id = document.getElementById('slider-id').value;
        let formData = new FormData();
        formData.append('title', document.getElementById('title').value);
        formData.append('short_des', document.getElementById('short_des').value);
        formData.append('price', document.getElementById('price').value);
        formData.append('product_id', document.getElementById('product_id').value);

        const image = imageInput.files[0];
        if (image) {
            formData.append('image', image);
        }

        let url = id ? `/admin/product-slider/update/${id}` : '/admin/product-slider/store';

        axios.post(url, formData, {
            headers: { 'Content-Type': 'multipart/form-data' }
        }).then(() => {
            sliderModal.hide();
            loadSliders();
        }).catch(err => {
            alert("Error: " + (err.response?.data?.message || 'Unknown Error'));
        });
    });

    loadSliders();
</script>
@endsection
