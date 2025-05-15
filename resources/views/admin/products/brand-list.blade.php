@extends('admin.layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Brand List</h2>
    <div class="table-responsive">
        <table class="table table-bordered" id="brandTable">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Brand Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="brandListBody"></tbody>
        </table>
    </div>
</div>

<!-- Confirmation Modal -->
<div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-danger">
      <div class="modal-header">
        <h5 class="modal-title text-danger">Confirm Deletion</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete this brand?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button id="confirmDeleteBtn" type="button" class="btn btn-danger">Yes, Delete</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('script')
<script>
    let deleteBrandId = null;

    function loadBrands() {
        axios.get('/Dashboard/BrandListData')
            .then(res => {
                const brands = res.data['data'];
                const tableBody = document.getElementById('brandListBody');
                tableBody.innerHTML = '';

                brands.forEach(brand => {
                    tableBody.innerHTML += `
                        <tr>
                            <td><img src="${brand.brandImg}" width="80" /></td>
                            <td>${brand.brandName}</td>
                            <td>
                                <a href="/Dashboard/BrandEdit/${brand.id}" class="btn btn-sm btn-primary">Edit</a>
                                <button onclick="showDeleteModal(${brand.id})" class="btn btn-sm btn-danger">Delete</button>
                            </td>
                        </tr>
                    `;
                });
            })
            .catch(err => console.error(err));
    }

    function showDeleteModal(id) {
        deleteBrandId = id;
        const modal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
        modal.show();
    }

    document.getElementById('confirmDeleteBtn').addEventListener('click', () => {
        axios.get(`/Dashboard/BrandDelete/${deleteBrandId}`)
            .then(res => {
                const modal = bootstrap.Modal.getInstance(document.getElementById('deleteConfirmModal'));
                modal.hide();
                loadBrands(); // reload brand list
            })
            .catch(err => {
                alert('Failed to delete brand');
                console.error(err);
            });
    });

    document.addEventListener('DOMContentLoaded', loadBrands);
</script>
@endsection
