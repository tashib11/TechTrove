@extends('admin.layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Create Category</h2>
<form id="catForm" enctype="multipart/form-data">
    <div class="form-group">
        <label for="catName">Category Name</label>
        <input type="text" class="form-control" id="catName" required>
    </div>

    <div class="form-group">
        <label for="catFile">Upload Category Image</label>
        <input type="file" class="form-control" id="catFile" accept="image/*" required>
    </div>

    <!-- Image Preview Card -->
    <div id="imagePreviewCard" class="card mt-3 d-none">
        <img id="catPreview" class="card-img-top" style="max-height: 200px; object-fit: contain;">
        <div class="card-body">
            <div class="form-group">
                <label for="catAlt">Image Alt Text</label>
                <input type="text" class="form-control" id="catAlt" placeholder="Describe the image">
            </div>
            <div class="form-group">
                <label for="catWidth">Set Width (px)</label>
                <input type="number" class="form-control" id="catWidth" placeholder="e.g., 300">
            </div>
            <div class="form-group">
                <label for="catHeight">Set Height (px)</label>
                <input type="number" class="form-control" id="catHeight" placeholder="e.g., 200">
            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-primary mt-3">Create Category</button>
    <div id="catMsg" class="mt-2"></div>
</form>





    <div id="catAlert" class="alert mt-3 d-none"></div>
</div>
@endsection


@section('script')
<script>

setupImagePreview('catFile', 'imagePreviewCard', 'catPreview');
document.getElementById('catForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const catName = document.getElementById('catName').value;
    const catFile = document.getElementById('catFile').files[0];
    const catAlt = document.getElementById('catAlt').value;
    const catWidth = document.getElementById('catWidth').value;
    const catHeight = document.getElementById('catHeight').value;

    const formData = new FormData();
    formData.append('catName', catName);
    formData.append('catFile', catFile);
    formData.append('catAlt', catAlt);
    formData.append('catWidth', catWidth);
    formData.append('catHeight', catHeight);

    axios.post('/Dashboard/category', formData, {
        headers: {
            'Content-Type': 'multipart/form-data'
        }
    })
    .then(function (response) {
        document.getElementById('catMsg').innerHTML =
            '<div class="alert alert-success">' + response.data.message + '</div>';
        document.getElementById('catForm').reset();
        document.getElementById('imagePreviewCard').classList.add('d-none');
    })
    .catch(function (error) {
        document.getElementById('catMsg').innerHTML =
            '<div class="alert alert-danger">Error creating category.</div>';
    });
});
</script>
@endsection





