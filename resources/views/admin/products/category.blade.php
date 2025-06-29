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
                <label for="categoryAlt">Image Alt Text</label>
                <input type="text" class="form-control" id="categoryAlt" placeholder="Describe the image">
            </div>

        </div>
    </div>

    <button type="submit" id="submitBtn" class="btn btn-primary">
    Create
    <span id="spinner" class="spinner-border spinner-border-sm d-none ml-2" role="status" aria-hidden="true"></span>
</button>
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
    const catAlt = document.getElementById('categoryAlt').value;

    const formData = new FormData();
    formData.append('catName', catName);
    formData.append('catFile', catFile);
    formData.append('catAlt', catAlt);

     const submitBtn = $('#submitBtn');
        const spinner = $('#spinner');

        // Disable button and show spinner
        submitBtn.prop('disabled', true);
        spinner.removeClass('d-none');

    axios.post('/Dashboard/category', formData, {
        headers: {
            'Content-Type': 'multipart/form-data'
        }
    })
    .then(function (response) {
        submitBtn.prop('disabled', false);
                    spinner.addClass('d-none');
        document.getElementById('catMsg').innerHTML =
            '<div class="alert alert-success">' + response.data.data.message + '</div>';
        document.getElementById('catForm').reset();
        document.getElementById('imagePreviewCard').classList.add('d-none');
    })
    .catch(function (error) {
        submitBtn.prop('disabled', false);
                    spinner.addClass('d-none');
        document.getElementById('catMsg').innerHTML =
            '<div class="alert alert-danger">Error creating category.</div>';
    });
});
</script>
@endsection





