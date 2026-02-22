<?php
namespace App\Imports;

use App\Models\Product;
use App\Models\Inventory;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ProductsImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        $product = Product::create([
            'category_id'   => $row['category_id'],
            'product_name'  => $row['product_name'],
            'description'   => $row['description'] ?? null,
            'price'         => $row['price'],
            'main_img_name' => $row['main_img_name'] ?? null,
            'is_featured'   => $row['is_featured'] ?? 0,
            'is_available'  => 1,
            'created_at'    => now(),
        ]);

        Inventory::create([
            'product_id'    => $product->product_id,
            'quantity'      => $row['quantity'] ?? 0,
            'unit'          => 'pcs',
            'reorder_level' => 10,
        ]);

        return $product;
    }

    public function rules(): array
    {
        return [
            'product_name' => 'required|string',
            'category_id'  => 'required|exists:categories,category_id',
            'price'        => 'required|numeric|min:0',
            'quantity'     => 'nullable|integer|min:0',
        ];
    }
}