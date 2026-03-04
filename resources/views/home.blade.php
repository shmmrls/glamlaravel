@extends('layouts.app')


@push('styles')
    @vite([
        'resources/css/index.css',
        'resources/css/hero.css',
        'resources/css/home-search.css',
        'resources/css/category-showcase.css',
        'resources/css/featured-products-home.css',
        'resources/css/whoarewe.css',
    ])
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600&family=Playfair+Display:wght@400;500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
@endpush

@section('content')

{{-- ===== HERO ===== --}}
<section class="hero">
    <div class="hero-overlay">
        <div class="hero-content">
            <h1>DISCOVER ELEGANCE</h1>
            <p>Premium salon essentials curated for the modern professional.</p>
            <a href="{{ $shopUrl }}" class="btn btn-primary">Shop Now</a>
        </div>
    </div>
</section>

{{-- ===== HOME SEARCH ===== --}}
<section class="home-search">
    <div class="page-header">
        <div class="header-content">
            <div class="header-info">
                <h1 class="page-title">Search Products</h1>
                <p class="page-subtitle">Find exactly what you're looking for in our premium collection</p>
            </div>
        </div>
    </div>

    <div class="search-container">
        <form class="home-search-form" action="{{ route('search') }}" method="get">
            <div class="search-box">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8"></circle>
                    <path d="m21 21-4.35-4.35"></path>
                </svg>
                <input type="text" name="search" class="search-input"
                       placeholder="Search products, brands, or categories..." required>
            </div>
            <button type="submit" class="btn-search">Search</button>
        </form>
    </div>
</section>

{{-- ===== CATEGORY SHOWCASE ===== --}}
<section class="category-showcase">
    <div class="container">
        <h2>SHOP BY CATEGORY</h2>
        <div class="category-grid">
            @foreach($categories as $category)
                @php
                    $imgPath = asset('assets/default.png');
                    $categoryImagesDir = public_path('storage/product_category/');
                    $extensions = ['.png', '.jpg', '.jpeg', '.webp'];

                    if (!empty($category->img_name)) {
                        $imgName = strtolower(str_replace(' ', '_', $category->img_name));
                        foreach ($extensions as $ext) {
                            if (file_exists($categoryImagesDir . $imgName . $ext)) {
                                $imgPath = asset('storage/product_category/' . $imgName . $ext);
                                break;
                            }
                        }
                    }

                    // Fallback to category_ID naming
                    if ($imgPath === asset('assets/default.png')) {
                        foreach ($extensions as $ext) {
                            if (file_exists($categoryImagesDir . 'category_' . $category->category_id . $ext)) {
                                $imgPath = asset('storage/product_category/category_' . $category->category_id . $ext);
                                break;
                            }
                        }
                    }

                    $categoryUrl = $user
                        ? ($user->role === 'admin'
                            ? route('admin.products.index', ['category' => $category->category_id])
                            : route('products.index', ['category' => $category->category_id]))
                        : route('products.index', ['category' => $category->category_id]);
                @endphp

                <div class="category-item" onclick="window.location.href='{{ $categoryUrl }}'">
                    <div class="category-image-wrapper">
                        <img src="{{ $imgPath }}" alt="{{ $category->category_name }}">
                    </div>
                    <h3>{{ $category->category_name }}</h3>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ===== FEATURED PRODUCTS ===== --}}
@if($featuredProducts->isNotEmpty())
    <section class="featured-products-section">
        <div class="featured-products-container">
            <div class="featured-products-header">
                <div class="featured-products-title-wrapper">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                    </svg>
                    <h2 class="featured-products-title">FEATURED PRODUCTS</h2>
                </div>
                <p class="featured-products-subtitle">Handpicked essentials for the discerning professional</p>
            </div>

            <div class="featured-products-grid">
                @foreach($featuredProducts as $featured)
                    @php
                        // Resolve product image
                        $imgTag = '<div class="featured-product-img-placeholder">No Image Available</div>';
                        $imgBase = trim($featured->main_img_name ?? '');
                        if ($imgBase !== '') {
                            $file = public_path("storage/products/{$imgBase}");
                            if (file_exists($file)) {
                                $timestamp = filemtime($file);
                                $imgTag = '<img src="' . asset('storage/products/' . $imgBase) . '?v=' . $timestamp . '" '
                                        . 'alt="' . e($featured->product_name) . '" class="featured-product-img" />';
                            }
                        }

                        // Stock status
                        $quantity = (int) $featured->quantity;
                        $stockClass = '';
                        $stockText = $quantity . ' in stock';
                        if ($quantity === 0) {
                            $stockClass = 'out-of-stock';
                            $stockText = 'Out of stock';
                        } elseif ($quantity < 10) {
                            $stockClass = 'low-stock';
                        }

                        // Product URL
                        $productUrl = route('products.show', $featured->product_id);
                        if ($user) {
                            $productUrl = $user->role === 'admin'
                                ? route('admin.products.show', $featured->product_id)
                                : route('products.show', $featured->product_id);
                        }
                    @endphp

                    <a href="{{ $productUrl }}" class="featured-product-card">
                        <div class="featured-product-img-wrapper">
                            {!! $imgTag !!}
                            <div class="featured-product-badge">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                                </svg>
                                Featured
                            </div>
                        </div>
                        <div class="featured-product-content">
                            <div class="featured-product-category">{{ $featured->category_name }}</div>
                            <h3 class="featured-product-name">{{ $featured->product_name }}</h3>
                            @if(!empty($featured->description))
                                <p class="featured-product-description">{{ $featured->description }}</p>
                            @endif
                            <div class="featured-product-footer">
                                <div class="featured-product-price">₱{{ number_format((float) $featured->price, 2) }}</div>
                                <div class="featured-product-stock {{ $stockClass }}">{{ $stockText }}</div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="featured-view-all">
                <a href="{{ $viewAllUrl }}" class="featured-view-all-btn">
                    View All Products
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                        <polyline points="12 5 19 12 12 19"></polyline>
                    </svg>
                </a>
            </div>
        </div>
    </section>
@endif

{{-- ===== CART SUMMARY (session-based) ===== --}}
<div class="container">
    @if($cartTotalItems > 0)
        <div class="cart-summary mb-4 text-center">
            <strong>Cart:</strong> {{ $cartTotalItems }} items |
            <strong>Total:</strong> ₱{{ number_format($cartTotalPrice, 2) }}
            <a href="{{ route('cart.index') }}" class="btn btn-primary btn-sm ms-2">View Cart</a>
        </div>
    @endif
</div>

{{-- ===== WHO ARE WE ===== --}}
<section class="who-are-we">
    <div class="who-text">
        <h3>Who Are We</h3>
        <h1>Your New Go-to for<br>Salon Essentials</h1>
        <p>GlamEssentials Salon Supplies is your trusted local destination for professional hair and beauty products. With everything in stock, we offer fast, reliable island-wide delivery straight to your door.</p>
        <a href="{{ $shopUrl }}" class="shop-btn">Shop Now</a>
    </div>
    <div class="who-image">
        <img src="{{ asset('images/salon_essentials.jpg') }}" alt="Salon Essentials">
    </div>
</section>

@endsection