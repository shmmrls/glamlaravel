<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index(): View
{
    // Total Products
    $totalProducts = DB::table('products')->where('is_available', 1)->count();
    
    // Total Orders
    $totalOrders = DB::table('orders')->count();
    
    // Total Revenue
    $totalRevenue = DB::table('orders as o')
        ->join('order_items as oi', 'o.order_id', '=', 'oi.order_id')
        ->where('o.payment_status', 'Paid')
        ->sum(DB::raw('oi.quantity * oi.price'));
    
    // Total Users
    $totalUsers = DB::table('users')
        ->where('role', 'customer')
        ->where('is_active', 1)
        ->count();
    
    // Pending Orders
    $pendingOrders = DB::table('orders')
        ->where('order_status', 'Pending')
        ->count();
    
    // Low Stock Products
    $lowStock = DB::table('inventory')
        ->where('quantity', '<', DB::raw('reorder_level'))
        ->count();
    
    // Recent Orders
    $recentOrders = DB::table('orders as o')
        ->select(
            'o.order_id',
            'o.transaction_id',
            'o.order_status',
            'o.payment_status',
            'o.created_at as order_date',
            'c.fullname as customer_name',
            DB::raw('(SELECT SUM(oi.quantity * oi.price) FROM order_items oi WHERE oi.order_id = o.order_id) AS total_amount'),
            DB::raw('(SELECT COUNT(oi.order_item_id) FROM order_items oi WHERE oi.order_id = o.order_id) AS item_count')
        )
        ->join('customers as c', 'o.customer_id', '=', 'c.customer_id')
        ->orderBy('o.created_at', 'desc')
        ->limit(10)
        ->get();
    
    // Low Stock Products Details
    $lowStockProducts = DB::table('inventory as i')
        ->select(
            'p.product_id',
            'p.product_name',
            'i.quantity',
            'i.reorder_level',
            'p.price'
        )
        ->join('products as p', 'i.product_id', '=', 'p.product_id')
        ->where('i.quantity', '<', DB::raw('i.reorder_level'))
        ->orderBy('i.quantity', 'asc')
        ->limit(5)
        ->get();
    
    // Recent Reviews
    $recentReviews = DB::table('reviews as r')
        ->select(
            'r.review_id',
            'r.rating',
            'r.review_text',
            'r.created_at',
            'p.product_name',
            'c.fullname as customer_name'
        )
        ->join('products as p', 'r.product_id', '=', 'p.product_id')
        ->join('customers as c', 'r.customer_id', '=', 'c.customer_id')
        ->orderBy('r.created_at', 'desc')
        ->limit(5)
        ->get();
    
    return view('admin.dashboard', compact(
        'totalProducts',
        'totalOrders', 
        'totalRevenue',
        'totalUsers',
        'pendingOrders',
        'lowStock',
        'recentOrders',
        'lowStockProducts',
        'recentReviews'
    ));
}
}