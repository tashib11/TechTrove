@extends('admin.layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Create Brand</h2>
<form id="brandForm" enctype="multipart/form-data">
    <div class="form-group">
        <label for="brandName">Brand Name</label>
        <input type="text" class="form-control" id="brandName" required>
    </div>

    <div class="form-group">
        <label for="brandFile">Upload Brand Image</label>
        <input type="file" class="form-control" id="brandFile" accept="image/*" required>
    </div>

    <!-- Image Preview Card -->
    <div id="brandPreviewCard" class="card mt-3 d-none">
        <img id="brandPreview" class="card-img-top" style="max-height: 200px; object-fit: contain;">
        <div class="card-body">
            <div class="form-group">
                <label for="brandAlt">Image Alt Text</label>
                <input type="text" class="form-control" id="brandAlt" placeholder="Describe the image">
            </div>


        </div>
    </div>

    <button type="submit" class="btn btn-primary mt-3">Create Brand</button>
    <div id="brandMsg" class="mt-2"></div>
</form>





    <div id="brandAlert" class="alert mt-3 d-none"></div>
</div>
@endsection

@section('script')
<script>
setupImagePreview('brandFile', 'brandPreviewCard', 'brandPreview');

// Form submit stays the same
document.getElementById('brandForm').addEventListener('submit', function (e) {
    e.preventDefault();
    const brandName = document.getElementById('brandName').value;
    const brandFile = document.getElementById('brandFile').files[0];
    const brandAlt = document.getElementById('brandAlt').value;

    const formData = new FormData();
    formData.append('brandName', brandName);
    formData.append('brandFile', brandFile);
    formData.append('brandAlt', brandAlt);

    axios.post('/Dashboard/brandStore', formData)
        .then(response => {
            document.getElementById('brandMsg').innerHTML =
                `<div class="alert alert-success">${response.data.data.message}</div>`;
            document.getElementById('brandForm').reset();
            document.getElementById('brandPreviewCard').classList.add('d-none');
        })
        .catch(() => {
            document.getElementById('brandMsg').innerHTML =
                `<div class="alert alert-danger">Error creating brand.</div>`;
        });
});
</script>
@endsection
