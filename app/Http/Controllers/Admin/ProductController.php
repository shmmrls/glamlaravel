<?php
namespace App\Http\Controllers\Admin;

use App\Imports\ProductsImport;
use App\Exports\ProductTemplateExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::withTrashed()->with('category', 'inventory')->get();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_name'   => 'required|string|max:150',
            'category_id'    => 'required|exists:categories,category_id',
            'description'    => 'nullable|string',
            'price'          => 'required|numeric|min:0',
            'quantity'       => 'required|integer|min:0',
            'main_image'     => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'other_images'   => 'nullable|array',
            'other_images.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $mainImgName = $this->uploadImage($request->file('main_image'), 'products');

        $product = Product::create([
            'category_id'   => $request->category_id,
            'product_name'  => $request->product_name,
            'description'   => $request->description,
            'price'         => $request->price,
            'main_img_name' => $mainImgName,
            'is_featured'   => $request->has('is_featured'),
            'is_available'  => true,
            'created_at'    => now(),
        ]);

        Inventory::create([
            'product_id'    => $product->product_id,
            'quantity'      => $request->quantity,
            'unit'          => 'pcs',
            'reorder_level' => 10,
        ]);

        if ($request->hasFile('other_images')) {
            foreach ($request->file('other_images') as $image) {
                $imgName = $this->uploadImage($image, 'product_images');
                ProductImage::create([
                    'product_id' => $product->product_id,
                    'img_name'   => $imgName,
                ]);
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Product added successfully.');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'product_name'   => 'required|string|max:150',
            'category_id'    => 'required|exists:categories,category_id',
            'description'    => 'nullable|string',
            'price'          => 'required|numeric|min:0',
            'quantity'       => 'required|integer|min:0',
            'main_image'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'other_images'   => 'nullable|array',
            'other_images.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = [
            'category_id'  => $request->category_id,
            'product_name' => $request->product_name,
            'description'  => $request->description,
            'price'        => $request->price,
            'is_featured'  => $request->has('is_featured'),
        ];

        if ($request->hasFile('main_image')) {
            $data['main_img_name'] = $this->uploadImage($request->file('main_image'), 'products');
        }

        $product->update($data);

        if ($product->inventory) {
            $product->inventory->update(['quantity' => $request->quantity]);
        } else {
            Inventory::create([
                'product_id' => $product->product_id,
                'quantity' => $request->quantity,
                'unit' => 'pcs',
                'reorder_level' => 10,
            ]);
        }

        if ($request->hasFile('other_images')) {
            foreach ($request->file('other_images') as $image) {
                $imgName = $this->uploadImage($image, 'product_images');
                ProductImage::create([
                    'product_id' => $product->product_id,
                    'img_name'   => $imgName,
                ]);
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')
            ->with('success', 'Product archived.');
    }

    public function restore($id)
    {
        Product::withTrashed()->findOrFail($id)->restore();
        return redirect()->route('admin.products.index')
            ->with('success', 'Product restored.');
    }

    public function destroyImage($id)
    {
        ProductImage::findOrFail($id)->delete();
        return back()->with('success', 'Image removed.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:5120',
        ]);

        Excel::import(new ProductsImport, $request->file('file'));

        return redirect()->route('admin.products.index')
            ->with('success', 'Products imported successfully.');
    }

    public function downloadTemplate()
    {
        return Excel::download(new ProductTemplateExport, 'products_template.xlsx');
    }

    // Helper: upload image to specified folder
    private function uploadImage($file, $folder = 'products')
    {
        $name = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $file->storeAs($folder, $name, 'public');
        return $name;
    }
}