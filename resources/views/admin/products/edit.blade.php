@extends('layouts.app')

@section('content')

<div class="container">
    <h2>Edit Product</h2>

```
@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

{{-- MAIN UPDATE FORM --}}
<form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Product Name</label>
        <input type="text" name="product_name" class="form-control"
            value="{{ old('product_name', $product->product_name) }}">
    </div>

    <div class="mb-3">
        <label>Category</label>
        <select name="category_id" class="form-control">
            @foreach($categories as $category)
                <option value="{{ $category->category_id }}"
                    {{ $product->category_id == $category->category_id ? 'selected' : '' }}>
                    {{ $category->category_name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Description</label>
        <textarea name="description" class="form-control" rows="3">{{ old('description', $product->description) }}</textarea>
    </div>

    <div class="mb-3">
        <label>Price (₱)</label>
        <input type="number" name="price" class="form-control" step="0.01"
            value="{{ old('price', $product->price) }}">
    </div>

    <div class="mb-3">
        <label>Stock Quantity</label>
        <input type="number" name="quantity" class="form-control"
            value="{{ old('quantity', $product->inventory->quantity ?? 0) }}">
    </div>

    <div class="mb-3">
        <label>Current Main Image</label><br>
        <img src="{{ asset('storage/products/' . $product->main_img_name) }}"
             width="120" height="120" style="object-fit:cover;" class="mb-2">

        <label>Replace Main Image</label>
        <input type="file" name="main_image" class="form-control" accept="image/*">
    </div>

    {{-- ADDITIONAL IMAGES --}}
    <div class="mb-3">
        <label>Current Additional Images</label>
        <div class="d-flex gap-2 flex-wrap mb-2">
            @foreach($product->images as $image)
            <div class="position-relative">
                <img src="{{ asset('storage/products/' . $image->img_name) }}"
                     width="80" height="80" style="object-fit:cover;">

                {{-- DELETE BUTTON (NO NESTED FORM) --}}
                <button type="button"
                    onclick="deleteImage({{ $image->image_id }})"
                    class="btn btn-danger btn-sm position-absolute top-0 end-0"
                    style="padding:1px 5px;">
                    x
                </button>
            </div>
            @endforeach
        </div>

        <label>Add More Images</label>
        <input type="file" name="other_images[]" class="form-control" accept="image/*" multiple>
    </div>

    <div class="mb-3 form-check">
        <input type="checkbox" name="is_featured" class="form-check-input" id="isFeatured"
            {{ $product->is_featured ? 'checked' : '' }}>
        <label class="form-check-label" for="isFeatured">Featured Product</label>
    </div>

    <button type="submit" class="btn btn-primary">Update Product</button>
    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Cancel</a>
</form>
```

</div>

{{-- SCRIPT FOR IMAGE DELETE --}}

<script>
function deleteImage(id) {
    if(confirm('Remove this image?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/admin/products/images/' + id;

        const csrf = document.createElement('input');
        csrf.type = 'hidden';
        csrf.name = '_token';
        csrf.value = '{{ csrf_token() }}';

        const method = document.createElement('input');
        method.type = 'hidden';
        method.name = '_method';
        method.value = 'DELETE';

        form.appendChild(csrf);
        form.appendChild(method);
        document.body.appendChild(form);
        form.submit();
    }
}
</script>

@endsection
