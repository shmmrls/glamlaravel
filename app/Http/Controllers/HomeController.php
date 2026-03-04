<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Determine shop URL based on role
        $shopUrl = route('products.index'); // Default to products for all users
        if ($user && $user->role === 'admin') {
            $shopUrl = route('admin.products.index'); // Admin gets admin products
        }

        // Determine view-all URL
        $viewAllUrl = route('products.index'); // Default to products for all users
        if ($user && $user->role === 'admin') {
            $viewAllUrl = route('admin.products.index'); // Admin gets admin products
        }

        // Fetch categories
        $categories = Category::orderBy('category_id')->get();

        // Fetch featured products
        $featuredProducts = Product::select(
                'products.product_id',
                'products.product_name',
                'products.description',
                'products.price',
                'products.main_img_name',
                'categories.category_name',
                \DB::raw('COALESCE(inventory.quantity, 0) AS quantity')
            )
            ->join('categories', 'categories.category_id', '=', 'products.category_id')
            ->leftJoin('inventory', 'inventory.product_id', '=', 'products.product_id')
            ->where('products.is_featured', 1)
            ->where('products.is_available', 1)
            ->orderByDesc('products.product_id')
            ->limit(6)
            ->get();

        // Cart summary
        $cartItems = session('cart_products', []);
        $cartTotalItems = 0;
        $cartTotalPrice = 0;
        foreach ($cartItems as $item) {
            $cartTotalItems += $item['item_qty'];
            $cartTotalPrice += $item['item_price'] * $item['item_qty'];
        }

        return view('home', compact(
            'shopUrl',
            'viewAllUrl',
            'categories',
            'featuredProducts',
            'cartTotalItems',
            'cartTotalPrice',
            'cartItems',
            'user'
        ));
    }
}