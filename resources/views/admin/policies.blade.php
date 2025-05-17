@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-3">Manage Policies</h4>

    <div class="mb-3">
        <label for="type" class="form-label">Policy Type</label>
        <select class="form-select" id="type">
            <option value="" disabled selected>Select policy type</option>
            <option value="about">About</option>
            <option value="refund">Refund</option>
            <option value="terms">Terms</option>
            <option value="how to buy">How to Buy</option>
            <option value="contact">Contact</option>
            <option value="complain">Complain</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="des" class="form-label">Description</label>
        <textarea id="des" class="form-control summernote" rows="6"></textarea>
    </div>

    <button class="btn btn-primary" id="savePolicy">Save Policy</button>

    <!-- Confirmation Modal -->
    <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-3 shadow">
          <div class="modal-header bg-warning">
            <h5 class="modal-title" id="confirmModalLabel">Confirm Policy Save</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            Are you sure you want to save this policy?
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary" id="confirmSave">Yes, Save</button>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function () {
        // Set CSRF token header for axios
        axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Initialize summernote editor with height
        $('.summernote').summernote({ height: 250 });

        // Load policy description when type changes
        $('#type').change(function () {
            const type = $(this).val();
            axios.get(`/admin/policies/${type}`)
                .then(res => {
                    $('#des').summernote('code', res.data?.des || '');
                })
                .catch(() => {
                    $('#des').summernote('code', '');
                });
        });

        let typeToSave = '';
        let desToSave = '';

        // Show confirm modal on save button click
        $('#savePolicy').click(function () {
            typeToSave = $('#type').val();
            desToSave = $('#des').summernote('code');

            if (!typeToSave) {
                alert("Please select a policy type.");
                return;
            }

            const confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'));
            confirmModal.show();
        });

        // Confirm save action
        $('#confirmSave').click(function () {
            axios.post('/admin/policies', { type: typeToSave, des: desToSave })
                .then(() => {
                    bootstrap.Modal.getInstance(document.getElementById('confirmModal')).hide();
                    // No alert on success, just hide modal
                })
                .catch(err => {
                    console.error("Error saving policy:", err);
                    bootstrap.Modal.getInstance(document.getElementById('confirmModal')).hide();
                });
        });
    });
</script>
@endsection
