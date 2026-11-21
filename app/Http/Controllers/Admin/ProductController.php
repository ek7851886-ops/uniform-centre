<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    const CUSTOMIZATION_OPTIONS = [
        'logo' => 'Logo Embroidery',
        'printing' => 'Printing',
        'reflective' => 'Reflective Strips',
        'name_embroidery' => 'Name Embroidery',
        'custom_measurements' => 'Custom Measurements',
    ];

    public function index(Request $request)
    {
        $query = Product::with(['images', 'category']);
        if ($request->filled('q')) {
            $query->where('name', 'like', '%' . $request->q . '%');
        }
        $products = $query->latest()->paginate(15)->withQueryString();

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.products.form', [
            'product' => null,
            'categories' => $categories,
            'customizationOptions' => self::CUSTOMIZATION_OPTIONS,
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $data['slug'] = $this->uniqueSlug($data['name']);

        $product = Product::create($data);
        $this->storeImages($request, $product);

        return redirect()->route('admin.products.index')->with('success', 'New uniform added.');
    }

    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();
        $product->load('images');

        return view('admin.products.form', [
            'product' => $product,
            'categories' => $categories,
            'customizationOptions' => self::CUSTOMIZATION_OPTIONS,
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $data = $this->validateData($request);
        if ($data['name'] !== $product->name) {
            $data['slug'] = $this->uniqueSlug($data['name'], $product->id);
        }

        $product->update($data);
        $this->storeImages($request, $product);

        return redirect()->route('admin.products.index')->with('success', 'Product updated.');
    }

    public function destroy(Product $product)
    {
        foreach ($product->images as $img) {
            Storage::disk('public')->delete($img->image_path);
        }
        $product->delete();

        return back()->with('success', 'Product deleted.');
    }

    public function toggle(Product $product)
    {
        $product->update(['is_active' => !$product->is_active]);

        return back()->with('success', 'Product status updated.');
    }

    public function deleteImage(ProductImage $image)
    {
        Storage::disk('public')->delete($image->image_path);
        $image->delete();

        return back()->with('success', 'Image removed.');
    }

    private function validateData(Request $request): array
    {
        $data = $request->validate([
            'category_id' => 'nullable|exists:categories,id',
            'name' => 'required|string|max:150',
            'description' => 'nullable|string',
            'fabric_options' => 'nullable|string|max:150',
            'color_options' => 'nullable|string|max:150',
            'customization_options' => 'nullable|array',
            'is_active' => 'nullable|boolean',
        ]);
        $data['is_active'] = $request->boolean('is_active', true);
        $data['customization_options'] = $data['customization_options'] ?? [];

        return $data;
    }

    private function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name);
        $slug = $base;
        $i = 1;
        while (Product::where('slug', $slug)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = $base . '-' . $i++;
        }

        return $slug;
    }

    private function storeImages(Request $request, Product $product): void
    {
        if (!$request->hasFile('images')) {
            return;
        }
        $hasPrimary = $product->images()->where('is_primary', true)->exists();
        foreach ($request->file('images') as $i => $file) {
            $path = $file->store('products', 'public');
            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => $path,
                'is_primary' => !$hasPrimary && $i === 0,
                'sort_order' => $product->images()->count(),
            ]);
        }
    }
}
