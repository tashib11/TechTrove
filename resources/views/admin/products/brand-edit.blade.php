@extends('admin.layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Edit Brand</h2>
    <form id="brandEditForm" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="brandName" class="form-label">Brand Name</label>
            <input type="text" class="form-control" id="brandName" name="brandName" value="{{ $brand->brandName }}">
        </div>

                          @php
                            $imgUrl = $brand->brandImg;
                        @endphp
                        <div class="card mb-3">
                            <div class="card-body">
                                <label for="brandFile">Update Image</label>
                                <input type="file" name="brandFile" id="brandFile" class="form-control">
                                <p class="error"></p>

                                <div id="imagePreviewCard" class="card mt-3 {{ $imgUrl ? '' : 'd-none' }}">
                                    <img id="imagePreview" src="{{ $imgUrl }}" class="card-img-top" style="max-height: 200px; object-fit: contain;">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="brandAlt">Image Alt Text</label>
                                            <input type="text" class="form-control" name="brandAlt"  value="{{ $brand->brandAlt }}" placeholder="Describe the image">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


        <button type="submit" class="btn btn-primary">Update Brand</button>
        <a href="/Dashboard/BrandList" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection

@section('script')
<script>
    setupImagePreview('brandFile', 'imagePreviewCard', 'imagePreview');

    const form = document.getElementById('brandEditForm');
    form.addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(form);

        axios.post(`/Dashboard/BrandUpdate/{{ $brand->id }}`, formData)
            .then(res => {
                alert(res.data.message);
                window.location.href = "/Dashboard/BrandList";
            })
            .catch(err => {
                alert('Update failed!');
                console.error(err);
            });
    });
</script>
@endsection
