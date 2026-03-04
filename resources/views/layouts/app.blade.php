<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $pageTitle ?? 'GlamEssentials - Professional Salon Supplies' }}</title>

    {{-- Vite compiled assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Additional CSS assets --}}
    <link rel="stylesheet" href="{{ asset('includes/style/style.css') }}">
    <link rel="stylesheet" href="{{ asset('includes/style/components/header-extras.css') }}">

    {{-- Page-specific CSS injected per page --}}
    @stack('styles')

    {{-- Page-specific scripts that must load early (before DOM events) --}}
    @stack('head-scripts')
</head>
<body>

{{-- Flash alert --}}
@if(session('alert'))
    <div class="site-alert" data-alert-type="{{ session('alert_type', 'message') }}">
        <span class="site-alert-msg">{{ session('alert') }}</span>
        <button class="site-alert-close" onclick="this.parentElement.remove()">×</button>
    </div>
@endif

{{-- Top scrolling banner --}}
<div class="top-banner">
    <div class="banner-content">
        @if(Auth::check() && Auth::user()->role === 'admin')
            <span class="banner-text">ADMIN DASHBOARD</span>
            <span class="banner-text">MANAGE YOUR SALON BUSINESS</span>
            <span class="banner-text">ADMIN DASHBOARD</span>
            <span class="banner-text">MANAGE YOUR SALON BUSINESS</span>
        @elseif(Auth::check() && Auth::user()->role === 'customer')
            <span class="banner-text">WELCOME BACK TO GLAMESSENTIALS</span>
            <span class="banner-text">ENJOY YOUR EXCLUSIVE DEALS TODAY</span>
            <span class="banner-text">THANK YOU FOR BEING PART OF OUR COMMUNITY</span>
            <span class="banner-text">SHOP YOUR FAVORITE PRODUCTS NOW</span>
        @else
            <span class="banner-text">SIGN UP NOW TO START SHOPPING</span>
            <span class="banner-text">EXCLUSIVE DEALS OFFERED BY GLAMESSENTIALS</span>
            <span class="banner-text">SIGN UP NOW TO START SHOPPING</span>
            <span class="banner-text">EXCLUSIVE DEALS OFFERED BY GLAMESSENTIALS</span>
            <span class="banner-text">SIGN UP NOW TO START SHOPPING</span>
            <span class="banner-text">EXCLUSIVE DEALS OFFERED BY GLAMESSENTIALS</span>
            <span class="banner-text">SIGN UP NOW TO START SHOPPING</span>
            <span class="banner-text">EXCLUSIVE DEALS OFFERED BY GLAMESSENTIALS</span>
        @endif
    </div>
</div>

{{-- ===== HEADER ===== --}}
<header class="header-container">
    <div class="header-main">
        <a href="{{ route('home') }}" class="logo">
            <img src="{{ asset('assets/logo1.png') }}" alt="GlamEssentials" class="logo-img">
        </a>

        <nav class="nav-container" id="mobile-nav">
            <ul class="main-nav">
                @if(Auth::check() && Auth::user()->role === 'admin')
                    <li><a href="{{ route('admin.dashboard') }}" class="nav-link">Dashboard</a></li>
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link">Manage</a>
                        <div class="dropdown-menu">
                            <a href="{{ route('admin.products.index') }}">Products</a>
                            <a href="{{ route('admin.users.index') }}">Users</a>
                            <a href="{{ route('admin.orders.index') }}">Orders</a>
                            <a href="{{ route('admin.reviews.index') }}">Reviews</a>
                        </div>
                    </li>
                @else
                    <li><a href="{{ route('home') }}" class="nav-link">Home</a></li>
                    <li>
                        <a href="{{ Auth::check() && Auth::user()->role === 'admin' ? route('admin.products.index') : route('products.index') }}"
                           class="nav-link">Products</a>
                    </li>
                    <li><a href="{{ route('about') }}" class="nav-link">About</a></li>
                    <li><a href="{{ route('faq') }}" class="nav-link">FAQ</a></li>

                    @if(Auth::check() && Auth::user()->role === 'customer')
                        <li class="nav-item dropdown">
                            <a href="#" class="nav-link">Account</a>
                            <div class="dropdown-menu">
                                <a href="{{ route('profile.edit') }}">Profile</a>
                                <a href="{{ route('orders.index') }}">My Orders</a>
                                <a href="{{ route('cart.index') }}">My Cart</a>
                                <a href="{{ route('reviews.index') }}">My Reviews</a>
                            </div>
                        </li>
                    @endif
                @endif
            </ul>
        </nav>

        <div class="header-actions desktop-only">
            @if(!Auth::check() || Auth::user()->role !== 'admin')
                {{-- Search trigger --}}
                <button class="icon-btn search-trigger-btn" aria-label="Search" type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 21l-5.197-5.197m0 0A7.5 7.5 0
                            105.196 5.196a7.5 7.5 0
                            0010.607 10.607z" />
                    </svg>
                </button>

                {{-- Cart --}}
                <a href="{{ route('cart.index') }}" class="icon-btn" aria-label="Shopping Cart">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 10.5V6a3.75 3.75 0
                            10-7.5 0v4.5m11.356-1.993l1.263
                            12c.07.665-.45 1.243-1.119
                            1.243H4.25a1.125 1.125 0
                            01-1.12-1.243l1.264-12A1.125
                            1.125 0 015.513
                            7.5h12.974c.576 0 1.059.435
                            1.119 1.007zM8.625
                            10.5a.375.375 0
                            11-.75 0 .375.375 0
                            01.75 0zm7.5
                            0a.375.375 0 11-.75 0 .375.375 0
                            01.75 0z" />
                    </svg>
                </a>
            @endif

            @auth
                @php
                    $headerUser = Auth::user();
                    $profilePic = $headerUser->img_name
                        ? asset('user/images/profile_pictures/' . $headerUser->img_name)
                        : asset('assets/nopfp.jpg');
                    $userName = $headerUser->name ?? 'User';
                    $userRole = ucfirst($headerUser->role ?? 'customer');
                @endphp

                <div class="account-dropdown-wrapper">
                    <button class="icon-btn account-dropdown-btn" aria-label="Account" type="button">
                        <img src="{{ $profilePic }}"
                             alt="Profile"
                             class="account-profile-img"
                             onerror="this.src='{{ asset('assets/nopfp.jpg') }}'">
                    </button>
                    <div class="account-dropdown-menu">
                        <div class="account-dropdown-header">
                            <img src="{{ $profilePic }}"
                                 alt="Profile"
                                 class="account-dropdown-avatar"
                                 onerror="this.src='{{ asset('assets/nopfp.jpg') }}'">
                            <div class="account-dropdown-name">{{ $userName }}</div>
                            <div class="account-dropdown-role">{{ $userRole }}</div>
                        </div>
                        <div class="account-dropdown-divider"></div>
                        <a href="{{ route('profile.edit') }}" class="account-dropdown-item">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                <circle cx="12" cy="7" r="4"/>
                            </svg>
                            <span>Profile</span>
                        </a>
                        @if($headerUser->role === 'customer')
                            <a href="{{ route('orders.index') }}" class="account-dropdown-item">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/>
                                    <rect x="8" y="2" width="8" height="4" rx="1" ry="1"/>
                                </svg>
                                <span>My Orders</span>
                            </a>
                            <a href="{{ route('cart.index') }}" class="account-dropdown-item">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="9" cy="21" r="1"/>
                                    <circle cx="20" cy="21" r="1"/>
                                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                                </svg>
                                <span>My Cart</span>
                            </a>
                            <a href="{{ route('reviews.index') }}" class="account-dropdown-item">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                                </svg>
                                <span>My Reviews</span>
                            </a>
                        @elseif($headerUser->role === 'admin')
                            <a href="{{ route('home') }}" class="account-dropdown-item">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                                    <polyline points="9 22 9 12 15 12 15 22"/>
                                </svg>
                                <span>View Store</span>
                            </a>
                        @endif
                        <div class="account-dropdown-divider"></div>
                        <a href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                           class="account-dropdown-item">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                                <polyline points="16 17 21 12 16 7"/>
                                <line x1="21" y1="12" x2="9" y2="12"/>
                            </svg>
                            <span>Sign Out</span>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
                            @csrf
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="icon-btn" aria-label="Account">
                    <svg width="24" height="24" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1">
                        <circle cx="10" cy="7" r="3.5"/>
                        <path d="M4 18c0-3.5 2.5-6 6-6s6 2.5 6 6"/>
                    </svg>
                </a>
            @endauth
        </div>

        <button class="hamburger-btn" aria-label="Menu">
            <span class="hamburger-bar"></span>
            <span class="hamburger-bar"></span>
            <span class="hamburger-bar"></span>
        </button>
    </div>
</header>

{{-- Search Overlay --}}
@if(!Auth::check() || Auth::user()->role !== 'admin')
<div class="search-overlay" id="searchOverlay">
    <div class="search-overlay-content">
        <button class="search-close-btn" aria-label="Close search" type="button">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
        <div class="search-box-wrapper">
            <form action="{{ route('products.index') }}" method="GET" class="search-form">
                <div class="search-input-container">
                    <svg class="search-input-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 21l-5.197-5.197m0 0A7.5 7.5 0
                            105.196 5.196a7.5 7.5 0
                            0010.607 10.607z" />
                    </svg>
                    <input type="text" name="search" class="search-input"
                           placeholder="Search for products..." autocomplete="off" autofocus>
                    <button type="submit" class="search-submit-btn">Search</button>
                </div>
            </form>
            <div class="search-suggestions">
                <p class="search-suggestions-title">Popular Searches</p>
                <div class="search-tags">
                    <a href="{{ route('products.index', ['search' => 'shampoo']) }}" class="search-tag">Shampoo</a>
                    <a href="{{ route('products.index', ['search' => 'conditioner']) }}" class="search-tag">Conditioner</a>
                    <a href="{{ route('products.index', ['search' => 'hair color']) }}" class="search-tag">Hair Color</a>
                    <a href="{{ route('products.index', ['search' => 'styling']) }}" class="search-tag">Styling</a>
                    <a href="{{ route('products.index', ['search' => 'treatment']) }}" class="search-tag">Treatment</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

{{-- ===== MAIN CONTENT ===== --}}
<main>
    @yield('content')
</main>

{{-- ===== FOOTER ===== --}}
<link rel="stylesheet" href="{{ asset('css/footer.css') }}">

<footer class="footer">
    <div class="footer-content">
        <div class="footer-grid">
            <div class="footer-column">
                <div class="footer-logo">
                    <img src="{{ asset('assets/logo2.png') }}" alt="GlamEssentials" class="logo-img">
                </div>
                <p class="footer-tagline">Your trusted destination for professional salon supplies.</p>
            </div>

            <div class="footer-column">
                <h4 class="footer-title">Collections</h4>
                <ul class="footer-links">
                    @php
                        $footerProductPage = Auth::check()
                            ? (Auth::user()->role === 'admin' ? route('admin.products.index') : route('products.index'))
                            : route('products.index');
                    @endphp
                    <li><a href="{{ $footerProductPage }}">All Products</a></li>
                    @foreach(\App\Models\Category::orderBy('category_id')->get() as $cat)
                        <li>
                            <a href="{{ $footerProductPage . '?category=' . $cat->category_id }}">
                                {{ $cat->category_name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="footer-column">
                <h4 class="footer-title">Information</h4>
                <ul class="footer-links">
                    <li><a href="{{ route('about') }}">About</a></li>
                    <li><a href="{{ route('contact') }}">Contact Us</a></li>
                    <li><a href="{{ route('shipping') }}">Shipping & Delivery</a></li>
                    <li><a href="{{ route('faq') }}">FAQ</a></li>
                </ul>
            </div>

            <div class="footer-column">
                <h4 class="footer-title">Account</h4>
                <ul class="footer-links">
                    @auth
                        @if(Auth::user()->role === 'admin')
                            <li><a href="{{ route('profile.edit') }}">My Profile</a></li>
                            <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li>
                                <a href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('footer-logout').submit();">
                                    Logout
                                </a>
                                <form id="footer-logout" action="{{ route('logout') }}" method="POST" style="display:none;">@csrf</form>
                            </li>
                        @else
                            <li><a href="{{ route('profile.edit') }}">My Profile</a></li>
                            <li><a href="{{ route('orders.index') }}">Order History</a></li>
                            <li><a href="{{ route('cart.index') }}">Shopping Cart</a></li>
                            <li>
                                <a href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('footer-logout').submit();">
                                    Logout
                                </a>
                                <form id="footer-logout" action="{{ route('logout') }}" method="POST" style="display:none;">@csrf</form>
                            </li>
                        @endif
                    @else
                        <li><a href="{{ route('login') }}">Login/Register</a></li>
                    @endauth
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} GlamEssentials. All Rights Reserved.</p>
            <div class="footer-legal">
                <a href="{{ route('privacy-policy') }}">Privacy Policy</a>
                <span class="separator">|</span>
                <a href="{{ route('terms-of-service') }}">Terms of Service</a>
            </div>
        </div>
    </div>
</footer>

{{-- Page-specific scripts injected per page --}}
@stack('scripts')

</body>
</html>