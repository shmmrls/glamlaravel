@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Products</h2>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary">Add Product</a>

            {{-- Import button triggers modal --}}
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#importModal">
                Import Excel
            </button>

            {{-- Download template button --}}
            <a href="{{ route('admin.products.template') }}" class="btn btn-outline-secondary">
                Download Template
            </a>
        </div>
    </div>

    {{-- Import Modal --}}
    <div class="modal fade" id="importModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Import Products via Excel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('admin.products.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        @if(session('import_errors'))
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach(session('import_errors') as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <p class="text-muted">Download the template first, fill it in, then upload it here.</p>
                        <div class="mb-3">
                            <label>Excel File (.xlsx, .xls, .csv)</label>
                            <input type="file" name="file" class="form-control" accept=".xlsx,.xls,.csv">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table id="productsTable" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Image</th>
                <th>Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td>{{ $product->product_id }}</td>
                <td>
                    <img src="{{ asset('storage/products/' . $product->main_img_name) }}"
                         width="60" height="60" style="object-fit:cover;">
                </td>
                <td>{{ $product->product_name }}</td>
                <td>{{ $product->category->category_name }}</td>
                <td>₱{{ number_format($product->price, 2) }}</td>
                <td>{{ $product->inventory->quantity ?? 0 }}</td>
                <td>
                    @if($product->deleted_at)
                        <span class="badge bg-secondary">Archived</span>
                    @else
                        <span class="badge bg-success">Active</span>
                    @endif
                </td>
                <td>
                    @if($product->deleted_at)
                        {{-- Restore --}}
                        <form action="{{ route('admin.products.restore', $product->product_id) }}" method="POST" class="d-inline">
                            @csrf
                            <button class="btn btn-sm btn-success">Restore</button>
                        </form>
                    @else
                        {{-- Edit --}}
                        <a href="{{ route('admin.products.edit', $product->product_id) }}"
                           class="btn btn-sm btn-warning">Edit</a>
                        {{-- Archive --}}
                        <form action="{{ route('admin.products.destroy', $product->product_id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger"
                                onclick="return confirm('Archive this product?')">Archive</button>
                        </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#productsTable').DataTable();
    });
</script>
@endpush