<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id', 'product_id');
    }

    public function inventory()
    {
        return $this->hasOne(Inventory::class, 'product_id', 'product_id');
    }

    public function getRouteKeyName()
    {
        return 'product_id';
    }
}