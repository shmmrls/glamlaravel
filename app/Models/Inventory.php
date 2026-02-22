<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $primaryKey = 'item_id';
    protected $table = 'inventory'; // add this line
    public $timestamps = false;
    protected $fillable = ['product_id', 'quantity', 'unit', 'reorder_level'];
}