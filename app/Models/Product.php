<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'product_id';
    public $incrementing = true;
    protected $keyType = 'int'; 
    public $timestamps = false;

    protected $fillable = [
        'category_id', 'product_name', 'description',
        'price', 'main_img_name', 'is_featured',
        'is_available',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }

    public function reviews() {
        return $this->hasMany(Review::class, 'product_id');
    }

    public function images() {
        return $this->hasMany(ProductImage::class, 'product_id');
    }

    public function inventory()
    {
        return $this->hasOne(Inventory::class, 'product_id', 'product_id');
    }

    public function getRouteKeyName()
    {
        return 'product_id';
    }

    /**
     * Scope 1: Simple LIKE query search (8 pts)
     */
    public function scopeSearchLike($query, $term)
    {
        if (!$term) {
            return $query;
        }

        $term = '%' . $term . '%';
        return $query->where(function($q) use ($term) {
            $q->where('product_name', 'like', $term)
              ->orWhere('description', 'like', $term)
              ->orWhereHas('category', function($q2) use ($term) {
                  $q2->where('category_name', 'like', $term);
              });
        });
    }

    /**
     * Scope 2: Model search using advanced query (10 pts)
     */
    public function scopeSearchModel($query, $term)
    {
        if (!$term) {
            return $query;
        }

        $term = '%' . $term . '%';
        $lowerTerm = strtolower($term);
        
        return $query->with(['category', 'inventory', 'images'])
            ->where(function($q) use ($term, $lowerTerm) {
                $q->whereRaw('LOWER(product_name) LIKE ?', [$lowerTerm])
                  ->orWhereRaw('LOWER(description) LIKE ?', [$lowerTerm])
                  ->orWhereHas('category', function($q2) use ($lowerTerm) {
                      $q2->whereRaw('LOWER(category_name) LIKE ?', [$lowerTerm]);
                  });
            })
            ->selectRaw('products.*, 
                CASE 
                    WHEN LOWER(product_name) LIKE ? THEN 1 
                    WHEN LOWER(description) LIKE ? THEN 2 
                    ELSE 3 
                END as relevance', [$lowerTerm, $lowerTerm])
            ->orderBy('relevance')
            ->orderBy('product_name');
    }

    /**
     * Scope 3: Scout-like search with full-text capabilities (15 pts)
     */
    public function scopeSearchScout($query, $term)
    {
        if (!$term) {
            return $query;
        }

        $lowerTerm = '%' . strtolower($term) . '%';

        return $query->with(['category', 'inventory', 'images'])
            ->where(function($q) use ($lowerTerm) {
                $q->whereRaw('LOWER(product_name) LIKE ?', [$lowerTerm])
                  ->orWhereRaw('LOWER(description) LIKE ?', [$lowerTerm])
                  ->orWhereHas('category', function($q2) use ($lowerTerm) {
                      $q2->whereRaw('LOWER(category_name) LIKE ?', [$lowerTerm]);
                  });
            })
            ->selectRaw('products.*,
                CASE 
                    WHEN LOWER(product_name) LIKE ? THEN 0
                    WHEN LOWER(description) LIKE ? THEN 1
                    ELSE 2 
                END as search_rank', [$lowerTerm, $lowerTerm])
            ->orderBy('search_rank')
            ->orderBy('product_name');
    }
}