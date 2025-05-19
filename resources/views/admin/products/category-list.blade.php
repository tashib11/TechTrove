@extends('admin.layouts.app')
<style>
    #pageLoader {
        position: fixed;
        z-index: 9999;
        background: rgba(255,255,255,0.9);
        top: 0;
        left: 0;
        height: 100vh;
        width: 100vw;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    #mainContent {
    display: none;
    opacity: 0;
    transition: opacity 0.3s ease-in-out;
}
#mainContent.visible {
    display: block;
    opacity: 1;
}

</style>

<div id="pageLoader">
    <div class="spinner-border text-primary" role="status" style="width: 4rem; height: 4rem;">
        <span class="visually-hidden">Loading...</span>
    </div>
</div>
@section('content')
<div id="mainContent">
    <div class="container mt-5">
        <h2 class="mb-4">Category List</h2>
        <div class="table-responsive">
            <table class="table table-bordered" id="categoryTable">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Category Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="categoryListBody"></tbody>
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
            Are you sure you want to delete this category?
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button id="confirmDeleteBtn" type="button" class="btn btn-danger">Yes, Delete</button>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection

@section('script')
<script>
    let deleteCategoryId = null;

    function loadCategories() {
        axios.get('/Dashboard/CategoryListData')
           .then(res => {
    const categories = res.data['data'];
    const tableBody = document.getElementById('categoryListBody');
    tableBody.innerHTML = '';

    categories.forEach(category => {
        tableBody.innerHTML += `
            <tr>
                <td><img src="${category.categoryImg}" width="80" /></td>
                <td>${category.categoryName}</td>
                <td>
                    <a href="/Dashboard/CategoryEdit/${category.id}" class="btn btn-sm btn-primary">Edit</a>
                    <button onclick="showDeleteModal(${category.id})" class="btn btn-sm btn-danger">Delete</button>
                </td>
            </tr>
        `;
    });

    // Give browser time to render table, then show content
   setTimeout(() => {
    document.getElementById('pageLoader').style.display = 'none';
    const mainContent = document.getElementById('mainContent');
    mainContent.classList.add('visible');
}, 100);
 // 100ms is usually enough, adjust if needed
})

            .catch(err => {
                console.error(err);
                alert('Failed to load categories');
            });
    }

    function showDeleteModal(id) {
        deleteCategoryId = id;
        const modal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
        modal.show();
    }

    document.getElementById('confirmDeleteBtn').addEventListener('click', () => {
        axios.get(`/Dashboard/CategoryDelete/${deleteCategoryId}`)
            .then(res => {
                const modal = bootstrap.Modal.getInstance(document.getElementById('deleteConfirmModal'));
                modal.hide();
                loadCategories(); // reload brand list
            })
            .catch(err => {
                alert('You have products of this category');
                console.error(err);
            });
    });

    document.addEventListener('DOMContentLoaded', loadCategories);
</script>
@endsection
