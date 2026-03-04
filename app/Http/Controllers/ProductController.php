<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category', 'inventory', 'images')
            ->where('is_available', 1);

        // Search: name or description or category
        if ($request->filled('search')) {
            $term = '%' . $request->search . '%';
            $query->where(function($q) use ($term) {
                $q->where('product_name', 'like', $term)
                  ->orWhere('description', 'like', $term)
                  ->orWhereHas('category', function($q2) use ($term) {
                      $q2->where('category_name', 'like', $term);
                  });
            });
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Sorting
        $sort_by = $request->get('sort', 'name_asc');
        switch ($sort_by) {
            case 'name_desc':
                $query->orderBy('product_name', 'desc');
                break;
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'latest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'name_asc':
            default:
                $query->orderBy('product_name', 'asc');
                break;
        }

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::orderBy('category_id')->get();

        return view('products.index', compact('products', 'categories', 'sort_by'));
    }

    public function show($id)
    {
        $product = Product::with('category', 'inventory', 'images', 'reviews.user')
            ->where('is_available', 1)
            ->findOrFail($id);

        return view('products.show', compact('product'));
    }
}