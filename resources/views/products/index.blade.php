@extends('layouts.app')



@push('styles')

    @vite(['resources/css/product-list.css'])

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600&family=Playfair+Display:wght@400;500&display=swap" rel="stylesheet">

@endpush



@section('content')

<main class="products-page">

    <div class="products-container">



        {{-- Page Header --}}

        <div class="page-header">

            <div class="header-content">

                <h1 class="page-title">Our Products</h1>

                <p class="page-subtitle">Discover our premium collection of beauty essentials</p>

            </div>

            <div class="results-count">

                <span>{{ $products->total() }}</span> Product{{ $products->total() != 1 ? 's' : '' }} Found

            </div>

        </div>



        {{-- Filters --}}

        <div class="filters-section">



            {{-- Search --}}

            <div class="search-wrapper">

                <form method="GET" action="{{ route('products.index') }}" class="search-form" id="searchForm">

                    <div class="search-input-wrapper">

                        <svg class="search-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">

                            <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>

                        </svg>

                        <input type="text" name="search" id="searchInput" class="search-input"

                               placeholder="Search products..."

                               value="{{ request('search') }}">

                        @if(request('search'))

                            <button type="button" class="clear-search" onclick="clearSearch()">

                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">

                                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>

                                </svg>

                            </button>

                        @endif

                    </div>

                    <input type="hidden" name="category" value="{{ request('category') }}">

                    <input type="hidden" name="sort" value="{{ request('sort', 'name_asc') }}">

                </form>

            </div>



            {{-- Controls --}}

            <div class="controls-wrapper">



                {{-- Category Filter --}}

                <div class="filter-group">

                    <label class="filter-label">

                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">

                            <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/>

                            <rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/>

                        </svg>

                        Category

                    </label>

                    <select name="category" class="filter-select" onchange="applyFilters()">

                        <option value="0">All Categories</option>

                        @foreach($categories as $category)

                            <option value="{{ $category->category_id }}"

                                {{ request('category') == $category->category_id ? 'selected' : '' }}>

                                {{ $category->category_name }}

                            </option>

                        @endforeach

                    </select>

                </div>



                {{-- Sort --}}

                <div class="filter-group">

                    <label class="filter-label">

                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">

                            <line x1="4" y1="6" x2="20" y2="6"/><line x1="4" y1="12" x2="16" y2="12"/><line x1="4" y1="18" x2="12" y2="18"/>

                        </svg>

                        Sort By

                    </label>

                    <select name="sort" class="filter-select" onchange="applyFilters()">

                        <option value="name_asc"  {{ request('sort', 'name_asc') == 'name_asc'  ? 'selected' : '' }}>Name (A-Z)</option>

                        <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name (Z-A)</option>

                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price (Low to High)</option>

                        <option value="price_desc"{{ request('sort') == 'price_desc'? 'selected' : '' }}>Price (High to Low)</option>

                        <option value="latest"    {{ request('sort') == 'latest'    ? 'selected' : '' }}>Latest</option>

                        <option value="oldest"    {{ request('sort') == 'oldest'    ? 'selected' : '' }}>Oldest</option>

                    </select>

                </div>



                {{-- Clear Filters --}}

                @if(request('category') || request('search') || (request('sort') && request('sort') != 'name_asc'))

                    <button type="button" class="clear-filters-btn" onclick="clearFilters()">

                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">

                            <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>

                        </svg>

                        Clear Filters

                    </button>

                @endif

            </div>

        </div>



        {{-- Products Grid --}}

        <div class="products-grid">

            @forelse($products as $product)

                @php
                    $imgPath = asset('assets/nopfp.jpg');
                    
                    if (!empty($product->main_img_name)) {
                        $file = public_path("storage/products/" . $product->main_img_name);
                        if (file_exists($file)) {
                            $imgPath = asset('storage/products/' . $product->main_img_name);
                        }
                    }
                @endphp



                <div class="product-card">

                    <a href="{{ route('products.show', $product->product_id) }}" class="product-link">

                        <div class="product-image-wrapper">

                            <img src="{{ $imgPath }}"

                                 alt="{{ $product->product_name }}"

                                 class="product-image"

                                 onerror="this.src='{{ asset('assets/default.png') }}'">

                            @if($product->is_featured)

                                <span class="featured-badge">Featured</span>

                            @endif

                        </div>

                        <div class="product-info">

                            <span class="product-category">{{ $product->category_name }}</span>

                            <h3 class="product-name">{{ $product->product_name }}</h3>

                            <p class="product-price">₱{{ number_format($product->price, 2) }}</p>

                            @if(!empty($product->description))

                                <p class="product-description">

                                    {{ Str::limit($product->description, 80) }}

                                </p>

                            @endif

                        </div>

                        <div class="product-actions">

                            <span class="view-details">

                                View Details

                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">

                                    <line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/>

                                </svg>

                            </span>

                        </div>

                    </a>

                </div>

            @empty

                <div class="no-products">

                    <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">

                        <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>

                    </svg>

                    <h3>No Products Found</h3>

                    <p>Try adjusting your filters or search terms</p>

                    <button onclick="clearFilters()" class="btn btn-primary">Clear All Filters</button>

                </div>

            @endforelse

        </div>



        {{-- Pagination --}}

        <div class="mt-6">

            {{ $products->withQueryString()->links() }}

        </div>



    </div>

</main>



@push('scripts')

<script>

    function applyFilters() {

        const form = document.getElementById('searchForm');

        const category = document.querySelector('select[name="category"]').value;

        const sort = document.querySelector('select[name="sort"]').value;

        form.querySelector('input[name="category"]').value = category;

        form.querySelector('input[name="sort"]').value = sort;

        form.submit();

    }



    function clearSearch() {

        document.getElementById('searchInput').value = '';

        document.getElementById('searchForm').submit();

    }



    function clearFilters() {

        window.location.href = '{{ route('products.index') }}';

    }



    function removeFilter(type) {

        const url = new URL(window.location.href);

        url.searchParams.delete(type);

        window.location.href = url.toString();

    }

</script>

@endpush

@endsection