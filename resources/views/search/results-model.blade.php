@extends('layouts.app')

@push('styles')
    @vite([
        'resources/css/index.css',
        'resources/css/hero.css',
        'resources/css/category-showcase.css',
        'resources/css/featured-products-home.css',
    ])
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600&family=Playfair+Display:wght@400;500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        .search-results-header {
            padding: 40px 20px;
            background: linear-gradient(135deg, #f5f5f5 0%, #fafafa 100%);
            text-align: center;
            margin-bottom: 40px;
        }
        
        .search-results-header h1 {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            color: #2c2c2c;
            margin-bottom: 10px;
        }
        
        .search-level-badge {
            display: inline-block;
            background: #d4a574;
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 15px;
        }
        
        .search-results-header p {
            font-size: 1.1rem;
            color: #666;
            margin-bottom: 20px;
        }
        
        .search-term {
            color: #d4a574;
            font-weight: 600;
        }
        
        .search-results-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            margin-bottom: 60px;
        }
        
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }
        
        .product-card {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
        }
        
        .product-card:hover {
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
            transform: translateY(-4px);
        }
        
        .relevance-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background: #d4a574;
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            z-index: 10;
        }
        
        .product-image {
            width: 100%;
            height: 250px;
            object-fit: cover;
            background: #f0f0f0;
        }
        
        .product-card-inner {
            padding: 20px;
        }
        
        .product-name {
            font-family: 'Montserrat', sans-serif;
            font-size: 1rem;
            font-weight: 600;
            color: #2c2c2c;
            margin-bottom: 8px;
            line-height: 1.3;
            min-height: 48px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        .product-category {
            font-size: 0.85rem;
            color: #999;
            margin-bottom: 10px;
        }
        
        .product-price {
            font-family: 'Montserrat', sans-serif;
            font-size: 1.3rem;
            font-weight: 700;
            color: #d4a574;
            margin-bottom: 15px;
        }
        
        .relevance-score {
            font-size: 0.8rem;
            color: #d4a574;
            margin-bottom: 10px;
            padding: 5px 0;
            font-weight: 600;
        }
        
        .stock-status {
            font-size: 0.85rem;
            padding: 5px 10px;
            border-radius: 4px;
            margin-bottom: 15px;
            display: inline-block;
        }
        
        .stock-status.in-stock {
            background: #e8f5e9;
            color: #2e7d32;
        }
        
        .stock-status.low-stock {
            background: #fff3e0;
            color: #e65100;
        }
        
        .stock-status.out-of-stock {
            background: #ffebee;
            color: #c62828;
        }
        
        .product-actions {
            display: flex;
            gap: 10px;
        }
        
        .btn-view, .btn-add {
            flex: 1;
            padding: 10px;
            border: none;
            border-radius: 4px;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            text-align: center;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn-view {
            background: white;
            color: #d4a574;
            border: 2px solid #d4a574;
        }
        
        .btn-view:hover {
            background: #d4a574;
            color: white;
        }
        
        .btn-add {
            background: #d4a574;
            color: white;
        }
        
        .btn-add:hover {
            background: #b8935e;
        }
        
        .no-results {
            text-align: center;
            padding: 60px 20px;
        }
        
        .no-results h2 {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            color: #2c2c2c;
            margin-bottom: 20px;
        }
        
        .no-results p {
            font-size: 1.1rem;
            color: #666;
            margin-bottom: 30px;
        }
        
        .pagination {
            display: flex;
            justify-content: center;
            gap: 5px;
            margin-top: 40px;
        }
        
        .pagination a, .pagination span {
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            text-decoration: none;
            color: #2c2c2c;
            transition: all 0.3s ease;
        }
        
        .pagination a:hover {
            background: #d4a574;
            color: white;
            border-color: #d4a574;
        }
        
        .pagination .active span {
            background: #d4a574;
            color: white;
            border-color: #d4a574;
        }
        
        @media (max-width: 768px) {
            .search-results-header h1 {
                font-size: 1.8rem;
            }
            
            .products-grid {
                grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
                gap: 15px;
            }
            
            .product-image {
                height: 200px;
            }
        }
    </style>
@endpush

@section('content')

{{-- Search Results Header --}}
<div class="search-results-header">
    <div class="search-level-badge">✓ Level 2: Model-Based Search (10 Points)</div>
    <h1>Search Results</h1>
    <p>Showing results for: <span class="search-term">"{{ $searchTerm }}"</span></p>
    <p style="font-size: 0.95rem; color: #999;">Found {{ $products->total() }} product(s) • Results sorted by relevance</p>
</div>

{{-- Search Results --}}
<div class="search-results-container">
    @if($products->isNotEmpty())
        <div class="products-grid">
            @foreach($products as $index => $product)
                @php
                    $imgTag = '<div class="featured-product-img-placeholder">No Image Available</div>';
                    $imgBase = trim($product->main_img_name ?? '');
                    if ($imgBase !== '') {
                        $file = public_path("storage/products/{$imgBase}");
                        if (file_exists($file)) {
                            $timestamp = filemtime($file);
                            $imgTag = '<img src="' . asset('storage/products/' . $imgBase) . '?v=' . $timestamp . '" '
                                    . 'alt="' . e($product->product_name) . '" class="product-image" />';
                        }
                    }

                    $quantity = (int) $product->inventory->quantity ?? 0;
                    $stockClass = '';
                    $stockText = $quantity . ' in stock';
                    if ($quantity === 0) {
                        $stockClass = 'out-of-stock';
                        $stockText = 'Out of stock';
                    } elseif ($quantity < 10) {
                        $stockClass = 'low-stock';
                    } else {
                        $stockClass = 'in-stock';
                    }

                    $productUrl = route('products.show', $product->product_id);
                    
                    // Determine relevance label
                    $relevanceScore = $product->relevance ?? 1;
                    $relevanceText = 'Good match';
                    if ($relevanceScore == 1) {
                        $relevanceText = 'Exact match';
                    } elseif ($relevanceScore == 2) {
                        $relevanceText = 'Close match';
                    }
                @endphp
                
                <div class="product-card">
                    <div class="relevance-badge">{{ $relevanceText }}</div>
                    {!! $imgTag !!}
                    <div class="product-card-inner">
                        <div class="product-category">{{ $product->category->category_name ?? 'Uncategorized' }}</div>
                        <h3 class="product-name">{{ $product->product_name }}</h3>
                        <div class="product-price">₱{{ number_format($product->price, 2) }}</div>
                        <div class="relevance-score">Relevance: {{ $relevanceText }}</div>
                        <div class="stock-status {{ $stockClass }}">{{ $stockText }}</div>
                        <div class="product-actions">
                            <a href="{{ $productUrl }}" class="btn-view">View Details</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        @if($products->hasPages())
            <div class="pagination">
                {{ $products->links() }}
            </div>
        @endif
    @else
        <div class="no-results">
            <h2>No Products Found</h2>
            <p>We couldn't find any products matching "<strong>{{ $searchTerm }}</strong>"</p>
            <p>Try searching with different keywords or <a href="{{ route('home') }}" style="color: #d4a574; text-decoration: underline;">browse all products</a></p>
        </div>
    @endif
</div>

@endsection
