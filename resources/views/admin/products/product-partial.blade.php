<div class="table-responsive">
    <table class="table table-striped table-bordered align-middle text-nowrap">
        <thead class="table-dark text-center">
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Price</th>
                <th>Discount</th>
                <th>Final Price</th>
                <th>Star</th>
                <th>Remark</th>
                <th>Category</th>
                <th>Brand</th>
                <th>Stock</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @if ($products->isNotEmpty())
                @foreach ($products as $product)
                    <tr>
                        <td class="text-center">{{ $product->id }}</td>
                        <td class="fw-semibold">{{ $product->title }}</td>
                        <td>
                            @php $desc = strip_tags($product->short_des); @endphp
                            @if(strlen($desc) > 30)
                                {{ Str::limit($desc, 30) }}
                                <button class="btn btn-sm btn-link text-primary view-description-btn p-0" data-description="{{ $desc }}" data-bs-toggle="modal" data-bs-target="#descriptionModal">
                                    View
                                </button>
                            @else
                                {{ $desc }}
                            @endif
                        </td>
                        <td class="text-end">Tk{{ $product->price }}</td>
                        <td class="text-end">{{ $product->discount }}</td>
                        <td class="text-end text-success">Tk{{ $product->discount_price }}</td>
                        <td class="text-center">{{ $product->star }}★</td>
                        <td class="text-center">
                            <span class="badge bg-info text-dark">{{ ucfirst($product->remark) }}</span>
                        </td>
                        <td class="text-center">{{ $product->category_id }}</td>
                        <td class="text-center">{{ $product->brand_id }}</td>
                        <td class="text-center">
                            @if($product->stock > 0)
                                <span class="badge bg-success">In</span>
                            @else
                                <span class="badge bg-danger">Out</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="{{ route('product.edit', $product->id) }}" class="btn btn-sm btn-outline-primary me-1">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                    <button
    class="btn btn-sm btn-outline-danger delete-btn"
    data-id="{{ $product->id }}"
    data-bs-toggle="modal"
    data-bs-target="#deleteConfirmModal"
>
    <i class="bi bi-trash3"></i>
</button>


                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="12" class="text-center text-muted">No records found.</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
