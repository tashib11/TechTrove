@extends('admin.layouts.app')

@section('content')

<div class="container">
  <h2 class="mb-4">Invoice List</h2>

<div class="mb-3 row align-items-center">
    <div class="col-md-6 col-sm-8">
        <input type="text" id="searchInput" class="form-control" placeholder="Search by Transaction ID or Name">
    </div>
    <div class="col-auto">
        <div id="searchLoading" class="spinner-border spinner-border-sm text-primary d-none" role="status"></div>
    </div>
</div>


<div id="invoiceTableContainer">
   @include('admin.products.invoice-partial-table')
</div>
    <!-- Status Change Modal -->
    <div class="modal fade" id="statusConfirmModal" tabindex="-1" aria-labelledby="statusConfirmModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title" id="statusConfirmModalLabel">Confirm Status Change</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to change <strong><span id="statusTypeText"></span></strong> to:
                    <strong class="text-primary"><span id="statusValueText"></span></strong>?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button id="confirmStatusBtn" type="button" class="btn btn-success">Confirm</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Invoice Detail Modal -->
<div class="modal fade" id="invoiceDetailModal" tabindex="-1" aria-labelledby="invoiceDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="invoiceDetailModalLabel">Invoice Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="invoiceDetailContent">
                Loading...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

</div>
@endsection

@section('script')
<script>
let selectedStatus = null;
let selectedInvoiceId = null;
let statusType = null;

function onStatusDropdownChange(e, invoiceId, type) {
    selectedInvoiceId = invoiceId;
    selectedStatus = e.target.value;
    statusType = type;

    document.getElementById('statusTypeText').innerText = type === 'order' ? 'Order Status' : 'Payment Status';
    document.getElementById('statusValueText').innerText = selectedStatus;

    const modal = new bootstrap.Modal(document.getElementById('statusConfirmModal'));
    modal.show();
}

document.getElementById('confirmStatusBtn').addEventListener('click', function () {
    const payload = {
        invoice_id: selectedInvoiceId,
    };
    payload[statusType + '_status'] = selectedStatus;

    axios.post("/Dashboard/InvoiceList/UpdateStatus", payload)
        .then(res => {
            if (res.data.status === 'success') {
                const badgeId = statusType + 'StatusBadge' + selectedInvoiceId;
                const badge = document.getElementById(badgeId);
                badge.innerText = selectedStatus;

                const colorMap = {
                    order: {
                        'Pending': 'bg-secondary',
                        'Processing': 'bg-warning',
                        'Shifted': 'bg-info',
                        'Delivered': 'bg-success',
                        'Cancelled': 'bg-danger'
                    },
                    payment: {
                        'Pending': 'bg-warning',
                        'Paid': 'bg-info',
                        'Delivered': 'bg-success'
                    }
                };

                const newColor = colorMap[statusType][selectedStatus] || 'bg-secondary';
                badge.className = 'badge ' + newColor;
            } else {
                alert("Update failed");
            }
        })
        .catch(err => {
            console.error(err);
            alert("Request failed");
        });

    bootstrap.Modal.getInstance(document.getElementById('statusConfirmModal')).hide();
});
</script>
<script>
function fetchInvoiceDetails(invoiceId) {
    const modal = new bootstrap.Modal(document.getElementById('invoiceDetailModal'));
    document.getElementById('invoiceDetailContent').innerHTML = "Loading...";

    axios.get(`/Dashboard/InvoiceList/${invoiceId}/Details`)
        .then(res => {
            if (res.data.status === 'success') {
                let html = `<div class="table-responsive"><table class="table table-bordered text-center">
                    <thead class="table-light">
                        <tr>
                             <th>Id</th>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Qty</th>
                            <th>Price</th>
                            <th>Color</th>
                            <th>Size</th>
                        </tr>
                    </thead><tbody>`;

                res.data.products.forEach(p => {
                    html += `<tr>
                        <td>${p.id}</td>
                        <td><img src="${p.image}" alt="" height="50"></td>
                        <td>${p.title}</td>
                        <td>${p.qty}</td>
                        <td>${p.price} Tk</td>
                        <td>${p.color ?? '-'}</td>
                        <td>${p.size ?? '-'}</td>
                    </tr>`;
                });

                html += '</tbody></table></div>';
                document.getElementById('invoiceDetailContent').innerHTML = html;
            } else {
                document.getElementById('invoiceDetailContent').innerHTML = "No data found.";
            }

            modal.show();
        })
        .catch(err => {
            console.error(err);
            document.getElementById('invoiceDetailContent').innerHTML = "Failed to load details.";
            modal.show();
        });
}
</script>
<script>
let searchTimeout = null;
document.getElementById('searchInput').addEventListener('input', function (e) {
    clearTimeout(searchTimeout);
    document.getElementById('searchLoading').classList.remove('d-none');

    searchTimeout = setTimeout(() => {
        const search = e.target.value;

        axios.get(`/Dashboard/InvoiceList/Search?search=${encodeURIComponent(search)}`)
            .then(res => {
                document.getElementById('invoiceTableContainer').innerHTML = res.data.html;
                document.getElementById('searchLoading').classList.add('d-none');
            })
            .catch(err => {
                console.error(err);
                alert('Search failed');
                document.getElementById('searchLoading').classList.add('d-none');
            });
    }, 400);
});

</script>

@endsection
