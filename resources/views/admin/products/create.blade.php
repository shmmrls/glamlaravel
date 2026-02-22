    @extends('layouts.app')

    @section('content')
    <div class="container">
        <h2>Add Product</h2>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label>Product Name</label>
                <input type="text" name="product_name" class="form-control" value="{{ old('product_name') }}">
            </div>

            <div class="mb-3">
                <label>Category</label>
                <select name="category_id" class="form-control">
                    <option value="">-- Select Category --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->category_id }}"
                            {{ old('category_id') == $category->category_id ? 'selected' : '' }}>
                            {{ $category->category_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Description</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
            </div>

            <div class="mb-3">
                <label>Price (₱)</label>
                <input type="number" name="price" class="form-control" step="0.01" value="{{ old('price') }}">
            </div>

            <div class="mb-3">
                <label>Stock Quantity</label>
                <input type="number" name="quantity" class="form-control" value="{{ old('quantity', 0) }}">
            </div>

            <div class="mb-3">
                <label>Main Image</label>
                <input type="file" name="main_image" class="form-control" accept="image/*">
                <div id="mainPreview" class="mt-2"></div>
            </div>

            <div class="mb-3">
                <label>Additional Images</label>
                <input type="file" name="other_images[]" class="form-control" accept="image/*" multiple>
                <div id="otherPreview" class="mt-2 d-flex gap-2 flex-wrap"></div>
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" name="is_featured" class="form-check-input" id="isFeatured">
                <label class="form-check-label" for="isFeatured">Featured Product</label>
            </div>

            <button type="submit" class="btn btn-primary">Save Product</button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
    @endsection

    @push('scripts')
    <script>
        // Main image preview
        document.querySelector('[name="main_image"]').addEventListener('change', function() {
            const preview = document.getElementById('mainPreview');
            preview.innerHTML = '';
            const img = document.createElement('img');
            img.src = URL.createObjectURL(this.files[0]);
            img.style = 'width:120px;height:120px;object-fit:cover;';
            preview.appendChild(img);
        });

        // Multiple images preview
        document.querySelector('[name="other_images[]"]').addEventListener('change', function() {
            const preview = document.getElementById('otherPreview');
            preview.innerHTML = '';
            [...this.files].forEach(file => {
                const img = document.createElement('img');
                img.src = URL.createObjectURL(file);
                img.style = 'width:80px;height:80px;object-fit:cover;';
                preview.appendChild(img);
            });
        });
    </script>
    @endpush