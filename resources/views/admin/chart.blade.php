@extends('admin.layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">📈 Performance Overview</h2>

    <div class="mb-3">
        <label for="timeRange" class="form-label">Select Time Range:</label>
        <select id="timeRange" class="form-select" style="max-width: 200px;">
            <option value="7" selected>Last 7 Days</option>
            <option value="30">Last 30 Days</option>
            <option value="90">Last 90 Days</option>
        </select>
    </div>
<!-- Chart Invoices Modal -->
<div class="modal fade" id="orderStatsModal" tabindex="-1" aria-labelledby="orderStatsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header bg-dark text-white">
        <h5 class="modal-title" id="orderStatsModalLabel">Invoices by Status</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="orderStatsModalBody">
        Loading...
      </div>
    </div>
  </div>
</div>

    <canvas id="weeklyChart" height="100"></canvas>
    <!-- Confirmation Modal -->
<div class="modal fade" id="statusConfirmModal" tabindex="-1" aria-labelledby="statusConfirmModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content border-0 shadow">
      <div class="modal-header bg-warning text-dark">
        <h5 class="modal-title" id="statusConfirmModalLabel">Confirm Status Change</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p id="statusConfirmMessage">Are you sure you want to update the status?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button id="confirmStatusChangeBtn" type="button" class="btn btn-primary">Yes, Update</button>
      </div>
    </div>
  </div>
</div>

</div>
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
let chart;

function renderChart(labels, revenueData, orderData) {
    const ctx = document.getElementById('weeklyChart').getContext('2d');
    if (chart) chart.destroy();

    chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Revenue (৳)',
                    data: revenueData,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    tension: 0.3,
                    fill: true
                },
                {
                    label: 'Orders',
                    data: orderData,
                    borderColor: 'rgba(153, 102, 255, 1)',
                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                    tension: 0.3,
                    fill: true
                }
            ]
        },
      options: {
  onClick: function (e, elements) {
    if (elements.length > 0) {
      const index = elements[0].index;
      const label = this.data.labels[index];

      const modal = new bootstrap.Modal(document.getElementById('orderStatsModal'));
      modal.show();

document.getElementById('orderStatsModalLabel').innerText = `Invoices for ${label}`;

      document.getElementById('orderStatsModalBody').innerHTML = `<div class="text-center py-4">
        <div class="spinner-border text-primary" role="status"></div>
        <p class="mt-2">Loading invoices...</p>
      </div>`;

     axios.get(`/dashboard/stats/invoices-by-date/${label}`)
        .then(response => {
          document.getElementById('orderStatsModalBody').innerHTML = response.data.html;
        })
        .catch(() => {
          document.getElementById('orderStatsModalBody').innerHTML = `<div class="text-danger">Failed to load invoices.</div>`;
        });
    }
  }
}

    });
}

function fetchAndRender(days) {
    axios.get('/admin/weekly-stats', { params: { days } })
        .then(res => {
            const labels = res.data.map(d => d.date);
            const revenueData = res.data.map(d => d.revenue);
            const orderData = res.data.map(d => d.orders);
            renderChart(labels, revenueData, orderData);
        })
        .catch(err => console.error(err));
}

document.addEventListener('DOMContentLoaded', () => {
    const select = document.getElementById('timeRange');
    fetchAndRender(select.value);

    select.addEventListener('change', () => {
        fetchAndRender(select.value);
    });
});
</script>
<script>
let pendingStatusChange = {
  invoiceId: null,
  newValue: null,
  type: null,
  dropdown: null
};

function onStatusDropdownChange(event, invoiceId, type) {
  const newValue = event.target.value;
  const statusType = type === 'order' ? 'Order Status' : 'Payment Status';

  // Save pending change
  pendingStatusChange = {
    invoiceId,
    newValue,
    type,
    dropdown: event.target
  };

  // Show message in modal
  document.getElementById('statusConfirmMessage').innerText =
    `Are you sure you want to change the ${statusType} to "${newValue}"?`;

  // Show modal
  const modal = new bootstrap.Modal(document.getElementById('statusConfirmModal'));
  modal.show();
}

// Confirm button logic
document.getElementById('confirmStatusChangeBtn').addEventListener('click', () => {
  const { invoiceId, newValue, type, dropdown } = pendingStatusChange;
  const endpoint = type === 'order' ? 'order-status' : 'payment-status';
  const badgeId = type === 'order' ? `orderStatusBadge${invoiceId}` : `paymentStatusBadge${invoiceId}`;

  axios.post(`/admin/invoices/update-${endpoint}`, {
    id: invoiceId,
    value: newValue
  }).then(res => {
    const badge = document.getElementById(badgeId);
    badge.textContent = newValue;

    const colorMap = {
      'Pending': 'secondary',
      'Processing': 'warning',
      'Shifted': 'info',
      'Delivered': 'success',
      'Cancelled': 'danger',
      'Paid': 'info'
    };

    badge.className = `badge bg-${colorMap[newValue] || 'secondary'}`;

    // Hide modal
    bootstrap.Modal.getInstance(document.getElementById('statusConfirmModal')).hide();
  }).catch(() => {
    alert('Update failed');
  });
});
</script>


@endsection
