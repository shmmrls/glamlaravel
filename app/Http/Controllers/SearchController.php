<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Level 1: Basic LIKE search (8 points)
     * Simple product name, description, and category search
     */
    public function searchBasic(Request $request)
    {
        $searchTerm = $request->input('search', '');
        $products = [];
        $hasSearched = false;

        if ($searchTerm) {
            $hasSearched = true;
            $products = Product::searchLike($searchTerm)
                ->where('is_available', 1)
                ->paginate(12)
                ->appends($request->query());
        }

        $categories = Category::orderBy('category_name')->get();

        return view('search.results-basic', compact('products', 'searchTerm', 'categories', 'hasSearched'));
    }

    /**
     * Level 2: Model-based search with relevance (10 points)
     * Advanced search using Eloquent with relationship loading and scoring
     */
    public function searchModel(Request $request)
    {
        $searchTerm = $request->input('search', '');
        $products = [];
        $hasSearched = false;

        if ($searchTerm) {
            $hasSearched = true;
            $products = Product::searchModel($searchTerm)
                ->where('is_available', 1)
                ->paginate(12)
                ->appends($request->query());
        }

        $categories = Category::orderBy('category_name')->get();

        return view('search.results-model', compact('products', 'searchTerm', 'categories', 'hasSearched'));
    }

    /**
     * Level 3: Scout-like search with full-text ranking (15 points)
     * Advanced search with relevance ranking and pagination
     */
    public function searchScout(Request $request)
    {
        $searchTerm = $request->input('search', '');
        $products = [];
        $hasSearched = false;

        if ($searchTerm) {
            $hasSearched = true;
            $products = Product::searchScout($searchTerm)
                ->where('is_available', 1)
                ->paginate(12)
                ->appends($request->query());
        }

        $categories = Category::orderBy('category_name')->get();

        return view('search.results-scout', compact('products', 'searchTerm', 'categories', 'hasSearched'));
    }

    /**
     * Home page search - uses basic LIKE search for performance
     * Redirects to dedicated search results page
     */
    public function homeSearch(Request $request)
    {
        $searchTerm = $request->input('search', '');

        if (!$searchTerm) {
            return redirect()->route('home');
        }

        // Use basic LIKE search for home page
        $products = Product::searchLike($searchTerm)
            ->where('is_available', 1)
            ->paginate(12)
            ->appends($request->query());

        $categories = Category::orderBy('category_name')->get();
        $hasSearched = true;

        return view('search.results-home', compact('products', 'searchTerm', 'categories', 'hasSearched'));
    }
}
