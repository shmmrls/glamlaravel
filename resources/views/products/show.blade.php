@extends('layouts.app')

@push('styles')
    @vite(['resources/css/product.css'])
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600&family=Playfair+Display:wght@400;500&display=swap" rel="stylesheet">
@endpush

@section('content')

@php
    $user = Auth::user();
    $inStock = ($product->inventory->quantity ?? 0) > 0;
    $stockQty = $product->inventory->quantity ?? 0;

    // Collect all product images
    $allImages = [];
    
    // Main image
    $mainImg = asset('assets/nopfp.jpg');
    if (!empty($product->main_img_name)) {
        $file = public_path("storage/products/" . $product->main_img_name);
        if (file_exists($file)) {
            $mainImg = asset('storage/products/' . $product->main_img_name);
            $allImages[] = $mainImg;
        } else {
            // Try alternative path
            $altFile = public_path("storage/app/public/products/" . $product->main_img_name);
            if (file_exists($altFile)) {
                $mainImg = asset('storage/products/' . $product->main_img_name);
                $allImages[] = $mainImg;
            }
        }
    }

    // Additional images (including those saved in product_images folder)
    $additionalImages = [];
    foreach ($product->images ?? [] as $img) {
        $imgPath = null;

        // look for file in the two possible folders used by the admin controller
        $candidates = [
            "storage/product_images/{$img->img_name}",
            "storage/products/{$img->img_name}"
        ];

        foreach ($candidates as $relative) {
            $file = public_path($relative);
            if (file_exists($file)) {
                $imgPath = asset($relative);
                break;
            }
        }

        // legacy alt paths (when using storage path directly)
        if (!$imgPath) {
            $altCandidates = [
                "storage/app/public/product_images/{$img->img_name}",
                "storage/app/public/products/{$img->img_name}"
            ];
            foreach ($altCandidates as $alt) {
                $file = public_path($alt);
                if (file_exists($file)) {
                    // convert alt to asset path
                    $imgPath = str_replace('storage/app/public', 'storage', asset($alt));
                    break;
                }
            }
        }

        if ($imgPath) {
            $additionalImages[] = $imgPath;
            $allImages[] = $imgPath;
        }
    }
    
    // If no images found, use default
    if (empty($allImages)) {
        $allImages = [asset('assets/nopfp.jpg')];
        $mainImg = $allImages[0];
    }

    // Reviews
    $avgRating = $product->reviews->avg('rating') ? round($product->reviews->avg('rating'), 1) : 0;
    $totalReviews = $product->reviews->count();

    // Has user purchased this?
    $hasPurchased = false;
    $userReview = null;
    if ($user) {
        $hasPurchased = \App\Models\Order::where('user_id', $user->id)
            ->where('order_status', 'Delivered')
            ->whereHas('items', fn($q) => $q->where('product_id', $product->product_id))
            ->exists();

        $userReview = $product->reviews->firstWhere('user_id', $user->id);
    }
@endphp

<main class="product-detail-page">
    <div class="product-container">
        <div class="breadcrumb">
            <a href="{{ route('home') }}">Home</a>
            <span class="separator">/</span>
            <a href="{{ route('products.index') }}">Shop</a>
            <span class="separator">/</span>
            <span>{{ $product->product_name }}</span>
        </div>

        {{-- Alerts --}}
        @if(session('success'))
            <div class="alert alert-success">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="20 6 9 17 4 12"/>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @if(request('login_required') && !$user)
            <div class="alert alert-error">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
                <span>Please log in to add items to your cart.</span>
            </div>
        @endif

        <div class="product-grid">

            <div class="product-images">
                <div class="main-image-wrapper">
                    <img id="mainImage" src="{{ $mainImg }}" 
                         alt="{{ $product->product_name }}"
                         class="main-image">
                    
                    @if($product->is_featured)
                        <span class="featured-badge">Featured</span>
                    @endif

                    {{-- navigation arrows on main image --}}
                    <div class="gallery-nav prev" onclick="prevImage()">‹</div>
                    <div class="gallery-nav next" onclick="nextImage()">›</div>
                </div>
                
                {{-- Always show thumbnail gallery with at least main image --}}
                <div class="thumbnail-gallery">
                    <div class="thumbnail-item active" onclick="changeImage('{{ $mainImg }}', this)">
                        <img src="{{ $mainImg }}" alt="Main">
                    </div>
                    @foreach($additionalImages as $img)
                        <div class="thumbnail-item" onclick="changeImage('{{ $img }}', this)">
                            <img src="{{ $img }}" alt="Gallery">
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="product-info-section">
                <div class="product-category">{{ $product->category->category_name }}</div>
                <h1 class="product-title">{{ $product->product_name }}</h1>
                
                <div class="rating-summary">
                    <div class="stars">
                        @for($i = 1; $i <= 5; $i++)
                            <svg width="18" height="18" viewBox="0 0 24 24"
                                 fill="{{ $i <= $avgRating ? '#0a0a0a' : 'none' }}"
                                 stroke="#0a0a0a" stroke-width="2">
                                <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                            </svg>
                        @endfor
                    </div>
                    <span class="rating-text">
                        @if($totalReviews > 0)
                            {{ $avgRating }} ({{ $totalReviews }} review{{ $totalReviews != 1 ? 's' : '' }})
                        @else
                            No reviews yet
                        @endif
                    </span>
                </div>

                <div class="product-price">₱{{ number_format((float) $product->price, 2) }}</div>

                <div class="stock-status {{ $inStock ? 'in-stock' : 'out-of-stock' }}">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        @if($inStock)
                            <polyline points="20 6 9 17 4 12"/>
                        @else
                            <line x1="18" y1="6" x2="6" y2="18"/>
                            <line x1="6" y1="6" x2="18" y2="18"/>
                        @endif
                    </svg>
                    {{ $inStock ? "In Stock ($stockQty available)" : 'Out of Stock' }}
                </div>

                @if(!empty($product->description))
                    <div class="product-description">
                        {!! nl2br(e($product->description)) !!}
                    </div>
                @endif

                {{-- Add to Cart (hide from admins) --}}
                @if(!$user || $user->role !== 'admin')
                    @if($inStock)
                        @auth
                            <form method="POST" action="{{ route('cart.store') }}" class="add-to-cart-form">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->product_id }}">
                                <div class="quantity-selector">
                                    <label>Quantity</label>
                                    <div class="quantity-controls">
                                        <button type="button" class="qty-btn" onclick="decreaseQty()">−</button>
                                        <input type="number" id="quantity" name="quantity"
                                               min="1" max="{{ $stockQty }}" value="1">
                                        <button type="button" class="qty-btn" onclick="increaseQty({{ $stockQty }})">+</button>
                                    </div>
                                </div>
                                <button class="btn btn-primary" type="submit">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
                                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                                    </svg>
                                    Add to Cart
                                </button>
                            </form>
                        @else
                            <div class="add-to-cart-form">
                                <div class="quantity-selector">
                                    <label>Quantity</label>
                                    <div class="quantity-controls">
                                        <button type="button" class="qty-btn" onclick="decreaseQty()">−</button>
                                        <input type="number" id="quantity" name="quantity"
                                               min="1" max="{{ $stockQty }}" value="1">
                                        <button type="button" class="qty-btn" onclick="increaseQty({{ $stockQty }})">+</button>
                                    </div>
                                </div>
                                <a href="{{ route('login') }}?redirect={{ urlencode(route('products.show', $product->product_id)) }}&login_required=1"
                                   class="btn btn-primary">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
                                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                                    </svg>
                                    Add to Cart
                                </a>
                            </div>
                        @endauth
                    @else
                        <div class="out-of-stock-notice">
                            <p>This product is currently out of stock. Please check back later.</p>
                        </div>
                    @endif
                @endif
            </div>
        </div>

        {{-- Reviews Section --}}
        <section class="reviews-section">
            <div class="reviews-header">
                <h2 class="section-title">Customer Reviews</h2>
                <div class="review-stats">
                    <div class="stat-item">
                        <span class="stat-value">{{ $avgRating }}</span>
                        <span class="stat-label">Average Rating</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-value">{{ $totalReviews }}</span>
                        <span class="stat-label">Total Reviews</span>
                    </div>
                </div>
            </div>

            {{-- Review Form --}}
            @auth
                @if($hasPurchased)
                    <div class="review-form-section">
                        <h3 class="form-title">{{ $userReview ? 'Update Your Review' : 'Write a Review' }}</h3>
                        <form method="POST"
                              action="{{ $userReview ? route('reviews.update', $userReview->review_id) : route('reviews.store') }}"
                              class="review-form" id="reviewForm">
                            @csrf
                            @if($userReview)
                                @method('PATCH')
                            @endif
                            <input type="hidden" name="product_id" value="{{ $product->product_id }}">

                            <div class="form-group">
                                <label class="form-label">Your Rating <span class="required">*</span></label>
                                <div class="star-rating-input">
                                    @for($i = 5; $i >= 1; $i--)
                                        <input type="radio" name="rating" id="star{{ $i }}" value="{{ $i }}"
                                            {{ $userReview && (int)$userReview->rating === $i ? 'checked' : ($i === 5 && !$userReview ? 'checked' : '') }}>
                                        <label for="star{{ $i }}">
                                            <svg width="24" height="24" viewBox="0 0 24 24" stroke-width="2">
                                                <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                                            </svg>
                                        </label>
                                    @endfor
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="review_text" class="form-label">Your Review <span class="required">*</span></label>
                                <textarea id="review_text" name="review_text" class="form-textarea"
                                          placeholder="Share your experience with this product..."
                                          rows="5">{{ $userReview ? $userReview->review_text : '' }}</textarea>
                                <span class="form-hint">Minimum 10 characters</span>
                            </div>

                            <div class="form-actions">
                                <button class="btn btn-primary" type="submit">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                                    </svg>
                                    {{ $userReview ? 'Update Review' : 'Submit Review' }}
                                </button>
                            </div>
                        </form>
                    </div>
                @else
                    <div class="purchase-required">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                        </svg>
                        <p>You can only review products you've purchased and received.</p>
                        <p class="hint">Complete a purchase to share your experience!</p>
                    </div>
                @endif
            @else
                <div class="login-prompt">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                    </svg>
                    <p>Please <a href="{{ route('login') }}?redirect={{ urlencode(route('products.show', $product->product_id)) }}" class="sign-in-link">sign in</a> to write a review</p>
                </div>
            @endauth

            {{-- Reviews List --}}
            <div class="reviews-list">
                @forelse($product->reviews as $review)
                    <div class="review-item">
                        <div class="review-header-row">
                            <div class="reviewer-info">
                                <div class="reviewer-avatar">
                                    {{ strtoupper(substr($review->user->name ?? 'C', 0, 1)) }}
                                </div>
                                <div>
                                    <div class="reviewer-name">{{ $review->user->name ?? 'Customer' }}</div>
                                    <div class="review-date">{{ $review->created_at->format('F j, Y') }}</div>
                                </div>
                            </div>
                            <div class="review-rating">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg width="14" height="14" viewBox="0 0 24 24"
                                         fill="{{ $i <= (int)$review->rating ? '#0a0a0a' : 'none' }}"
                                         stroke="#0a0a0a" stroke-width="2">
                                        <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                                    </svg>
                                @endfor
                                <span class="rating-number">{{ (int)$review->rating }}.0</span>
                            </div>
                        </div>
                        @if(!empty($review->review_text))
                            <div class="review-content">
                                {!! nl2br(e($review->review_text)) !!}
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="no-reviews">
                        <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                        </svg>
                        <h3>No Reviews Yet</h3>
                        <p>Be the first to review this product</p>
                    </div>
                @endforelse
            </div>
        </section>
    </div>
</main>

@push('scripts')
<script>
    // gallery state helpers (array injected below)
    let galleryImages = [];
    let currentIndex = 0;

    function changeImage(src, el) {
        const mainImg = document.getElementById('mainImage');
        mainImg.src = src;
        
        // Update thumbnail active state
        document.querySelectorAll('.thumbnail-item').forEach(t => t.classList.remove('active'));
        el.classList.add('active');

        // keep index in sync
        const idx = galleryImages.indexOf(src);
        if (idx !== -1) {
            currentIndex = idx;
        }
    }

    function nextImage() {
        if (galleryImages.length === 0) return;
        currentIndex = (currentIndex + 1) % galleryImages.length;
        const nextSrc = galleryImages[currentIndex];
        const thumb = document.querySelectorAll('.thumbnail-item')[currentIndex];
        if (thumb) {
            changeImage(nextSrc, thumb);
        }
    }

    function prevImage() {
        if (galleryImages.length === 0) return;
        currentIndex = (currentIndex - 1 + galleryImages.length) % galleryImages.length;
        const prevSrc = galleryImages[currentIndex];
        const thumb = document.querySelectorAll('.thumbnail-item')[currentIndex];
        if (thumb) {
            changeImage(prevSrc, thumb);
        }
    }

    function decreaseQty() {
        const input = document.getElementById('quantity');
        if (parseInt(input.value) > 1) input.value = parseInt(input.value) - 1;
    }

    function increaseQty(max) {
        const input = document.getElementById('quantity');
        if (parseInt(input.value) < max) input.value = parseInt(input.value) + 1;
    }

    // inject list of image urls (php variable `$allImages` defined earlier)
    @if(!empty($allImages))
        galleryImages = @json($allImages);
        currentIndex = 0; // start with first item
    @endif

    // Zoom functionality
    function openZoomModal(imageSrc) {
        const modal = document.createElement('div');
        modal.className = 'image-zoom-modal';
        modal.style.display = 'flex';
        
        const modalContent = document.createElement('div');
        modalContent.className = 'zoom-modal-content';
        
        const closeBtn = document.createElement('button');
        closeBtn.className = 'zoom-modal-close';
        closeBtn.innerHTML = '✕';
        closeBtn.onclick = () => document.body.removeChild(modal);
        
        const img = document.createElement('img');
        img.src = imageSrc;
        img.className = 'zoom-modal-image';
        
        modalContent.appendChild(closeBtn);
        modalContent.appendChild(img);
        modal.appendChild(modalContent);
        document.body.appendChild(modal);
        
        // Close on background click
        modal.onclick = (e) => {
            if (e.target === modal) {
                document.body.removeChild(modal);
            }
        };
        
        // Close on ESC key
        const handleEsc = (e) => {
            if (e.key === 'Escape') {
                document.body.removeChild(modal);
                document.removeEventListener('keydown', handleEsc);
            }
        };
        document.addEventListener('keydown', handleEsc);
    }

    // Initialize zoom functionality and navigation visibility
    document.addEventListener('DOMContentLoaded', function() {
        // hide nav arrows if only one image
        if (galleryImages.length <= 1) {
            document.querySelectorAll('.gallery-nav').forEach(el => el.style.display = 'none');
        }

        // Main image zoom
        const mainImg = document.getElementById('mainImage');
        if (mainImg) {
            mainImg.addEventListener('click', () => openZoomModal(mainImg.src));
        }
        
        // Thumbnail zoom
        document.querySelectorAll('.thumbnail-item img').forEach(thumb => {
            thumb.addEventListener('click', (e) => {
                e.stopPropagation();
                openZoomModal(thumb.src);
            });
        });

        // Keyboard navigation
        document.addEventListener('keydown', function(e) {
            if (e.key === 'ArrowRight') {
                nextImage();
            } else if (e.key === 'ArrowLeft') {
                prevImage();
            }
        });
    });
</script>
@endpush
@endsection
