<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $primaryKey = 'image_id';
    public $timestamps = false;
    protected $fillable = ['product_id', 'img_name'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }
}