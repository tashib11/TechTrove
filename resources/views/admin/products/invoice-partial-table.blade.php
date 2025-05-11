    <div class="table-responsive">
        <table class="table table-bordered align-middle text-center">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Transaction ID</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>City / Division</th>
                    <th>Shipping Address</th>
                    <th>Gift Wrap</th>
                    <th>Total</th>
                    <th>Order Status</th>
                    <th>Payment Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invs as $key => $inv)
              <tr>

                        <td  style="cursor:pointer" onclick="fetchInvoiceDetails({{ $inv->id }})">{{ $key + 1 }}</td>
                        <td class="text-break small"  style="cursor:pointer" onclick="fetchInvoiceDetails({{ $inv->id }})">{{ $inv->tran_id }}</td>
                        <td class="small">{{ $inv->shipping_name }}</td>
                        <td class="small">{{ $inv->shipping_phone }}</td>
                        <td class="small">{{ $inv->shipping_city }} / {{ $inv->shipping_division }}</td>
                        <td class="small">
                            @php $address = $inv->shipping_address; @endphp
                            @if (strlen($address) > 30)
                                {{ substr($address, 0, 30) }}...
                                <a href="#" data-bs-toggle="modal" data-bs-target="#addressModal{{ $inv->id }}">View More</a>

                                <!-- Address Modal -->
                                <div class="modal fade" id="addressModal{{ $inv->id }}" tabindex="-1" aria-labelledby="addressModalLabel{{ $inv->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header bg-info text-white">
                                                <h5 class="modal-title" id="addressModalLabel{{ $inv->id }}">Full Shipping Address</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                {{ $address }}
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                {{ $address }}
                            @endif
                        </td>

                        <td>
                            @if($inv->gift_wrap)
                                <span class="badge bg-info">Yes</span>
                            @else
                                <span class="badge bg-secondary">No</span>
                            @endif
                        </td>

                        <td>{{ $inv->total }} ৳</td>

                        <!-- Order Status -->
                        <td>
                            <div class="d-flex align-items-center justify-content-center gap-2">
                                <span id="orderStatusBadge{{ $inv->id }}" class="badge bg-{{ getOrderStatusColor($inv->order_status) }}">
                                    {{ $inv->order_status }}
                                </span>
                                <select class="form-select form-select-sm w-auto" onchange="onStatusDropdownChange(event, {{ $inv->id }}, 'order')">
                                    @foreach (['Pending','Processing','Shifted','Delivered','Cancelled'] as $status)
                                        <option value="{{ $status }}" @selected($inv->order_status == $status)>
                                            {{ $status }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </td>

                        <!-- Payment Status -->
                        <td>
                            <div class="d-flex align-items-center justify-content-center gap-2">
                                <span id="paymentStatusBadge{{ $inv->id }}" class="badge bg-{{ getPaymentStatusColor($inv->payment_status) }}">
                                    {{ $inv->payment_status }}
                                </span>
                                <select class="form-select form-select-sm w-auto" onchange="onStatusDropdownChange(event, {{ $inv->id }}, 'payment')">
                                    @foreach (['Pending','Paid','Delivered'] as $status)
                                        <option value="{{ $status }}" @selected($inv->payment_status == $status)>
                                            {{ $status }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </td>

                        <td class="small">{{ $inv->created_at->format('d M Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $invs->links() }}
    </div>
