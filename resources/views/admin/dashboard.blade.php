@extends('layouts.app')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600&family=Playfair+Display:wght@400;500&display=swap" rel="stylesheet">
@endpush

@section('content')
<main class="dashboard-page">
    <div class="dashboard-container">
        <div class="dashboard-header">
            <div class="header-content">
                <div class="header-info">
                    <h1 class="dashboard-title">Dashboard</h1>
                    <p class="dashboard-subtitle">Welcome back, {{ Auth::user()->name }}</p>
                </div>
                <div class="header-actions">
                    <span class="role-badge">{{ ucfirst(Auth::user()->role) }}</span>
                </div>
            </div>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon stat-icon-primary">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 7h-9"/><path d="M14 17H5"/><circle cx="17" cy="17" r="3"/><circle cx="7" cy="7" r="3"/>
                    </svg>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ number_format($totalProducts) }}</div>
                    <div class="stat-label">Total Products</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon stat-icon-success">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                    </svg>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ number_format($totalOrders) }}</div>
                    <div class="stat-label">Total Orders</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon stat-icon-info">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <text x="12" y="18" text-anchor="middle" font-size="20" font-weight="bold" fill="currentColor" stroke="none">₱</text>
                    </svg>
                </div>
                <div class="stat-content">
                    <div class="stat-value">₱{{ number_format($totalRevenue, 2) }}</div>
                    <div class="stat-label">Total Revenue</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon stat-icon-secondary">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ number_format($totalUsers) }}</div>
                    <div class="stat-label">Active Users</div>
                </div>
            </div>

            <div class="stat-card stat-card-highlight">
                <div class="stat-icon stat-icon-warning">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><rect x="8" y="2" width="8" height="4" rx="1" ry="1"/>
                    </svg>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ number_format($pendingOrders) }}</div>
                    <div class="stat-label">Pending Orders</div>
                </div>
            </div>

            <div class="stat-card stat-card-highlight">
                <div class="stat-icon stat-icon-danger">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
                    </svg>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ number_format($lowStock) }}</div>
                    <div class="stat-label">Low Stock Items</div>
                </div>
            </div>
        </div>

        <div class="quick-actions">
            <h2 class="section-title">Quick Actions</h2>
            <div class="actions-grid">
                <a href="{{ route('admin.products.index') }}" class="action-card">
                    <div class="action-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 7h-9"/><path d="M14 17H5"/><circle cx="17" cy="17" r="3"/><circle cx="7" cy="7" r="3"/>
                        </svg>
                    </div>
                    <div class="action-label">Manage Products</div>
                </a>

                <a href="{{ route('admin.orders.index') }}" class="action-card">
                    <div class="action-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                        </svg>
                    </div>
                    <div class="action-label">View Orders</div>
                </a>

                <a href="{{ route('admin.users.index') }}" class="action-card">
                    <div class="action-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                        </svg>
                    </div>
                    <div class="action-label">Manage Users</div>
                </a>

                <a href="#" class="action-card">
                    <div class="action-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/>
                        </svg>
                    </div>
                    <div class="action-label"> Manage Categories</div>
                </a>

                <a href="{{ route('admin.reviews.index') }}" class="action-card">
                    <div class="action-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                        </svg>
                    </div>
                    <div class="action-label">Manage Reviews</div>
                </a>

                <a href="{{ route('admin.analytics') }}" class="action-card">
                    <div class="action-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M3 3v18h18"/>
                            <path d="M18 17V9"/>
                            <path d="M13 17V5"/>
                            <path d="M8 17v-3"/>
                        </svg>
                    </div>
                    <div class="action-label">Sales Analytics</div>
                </a>

                @if(Auth::user()->role === 'admin')
                <a href="#" class="action-card">
                    <div class="action-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><line x1="20" y1="8" x2="20" y2="14"/><line x1="23" y1="11" x2="17" y2="11"/>
                        </svg>
                    </div>
                    <div class="action-label">Add Admin</div>
                </a>
                @endif
            </div>
        </div>

        <div class="content-grid">
            <div class="content-section">
                <div class="section-header">
                    <h2 class="section-title">Recent Orders</h2>
                    <a href="{{ route('admin.orders.index') }}" class="section-link">View All →</a>
                </div>

                @if($recentOrders->count() > 0)
                    <div class="table-wrapper">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Items</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentOrders as $order)
                                    <tr>
                                        <td><span class="order-id">#{{ $order->order_id }}</span></td>
                                        <td>{{ $order->customer_name }}</td>
                                        <td>{{ $order->item_count }} item{{ $order->item_count != 1 ? 's' : '' }}</td>
                                        <td><strong>₱{{ number_format($order->total_amount, 2) }}</strong></td>
                                        <td>
                                            <span class="badge badge-{{ strtolower($order->order_status) }}">
                                                {{ $order->order_status }}
                                            </span>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($order->order_date)->format('M d, Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="empty-state">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                        </svg>
                        <p>No orders yet</p>
                    </div>
                @endif
            </div>

            <div class="content-section">
                <div class="section-header">
                    <h2 class="section-title">Low Stock Alert</h2>
                    <a href="{{ route('admin.products.index') }}?filter=low-stock" class="section-link">View All →</a>
                </div>

                @if($lowStockProducts->count() > 0)
                    <div class="stock-list">
                        @foreach($lowStockProducts as $product)
                            <div class="stock-item">
                                <div class="stock-info">
                                    <div class="stock-name">{{ $product->product_name }}</div>
                                    <div class="stock-price">₱{{ number_format($product->price, 2) }}</div>
                                </div>
                                <div class="stock-status">
                                    <span class="stock-quantity {{ $product->quantity == 0 ? 'out-of-stock' : 'low-stock' }}">
                                        {{ $product->quantity }} left
                                    </span>
                                    <span class="stock-reorder">Reorder: {{ $product->reorder_level }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>
                        </svg>
                        <p>All products are well stocked</p>
                    </div>
                @endif
            </div>
        </div>

        @if($recentReviews->count() > 0)
        <div class="reviews-section">
            <div class="section-header">
                <h2 class="section-title">Recent Reviews</h2>
                <a href="{{ route('admin.reviews.index') }}" class="section-link">View All →</a>
            </div>

            <div class="reviews-grid">
                @foreach($recentReviews as $review)
                    <div class="review-card">
                        <div class="review-header">
                            <div class="review-rating">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="{{ $i <= $review->rating ? '#0a0a0a' : 'none' }}" stroke="#0a0a0a" stroke-width="2">
                                        <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                                    </svg>
                                @endfor
                            </div>
                            <div class="review-date">{{ \Carbon\Carbon::parse($review->created_at)->format('M d, Y') }}</div>
                        </div>
                        <div class="review-product">{{ $review->product_name }}</div>
                        <div class="review-text">{{ Str::limit($review->review_text, 100) }}</div>
                        <div class="review-customer">— {{ $review->customer_name }}</div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</main>
@endsection