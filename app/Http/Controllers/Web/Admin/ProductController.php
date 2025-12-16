<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\AffiliateProgram;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('programs');

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $programs = AffiliateProgram::where('is_active', true)->get();
        return view('admin.products.create', compact('programs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'website_url' => ['required', 'url'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'is_active' => ['nullable'],
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'max:2048'],
            'program_ids' => ['nullable', 'array'],
            'program_ids.*' => ['exists:affiliate_programs,id'],
        ]);

        $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                $images[] = $path;
            }
        }

        $product = Product::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'website_url' => $validated['website_url'],
            'price' => $validated['price'] ?? null,
            'images' => $images,
            'is_active' => $request->has('is_active'),
        ]);

        if (!empty($validated['program_ids'])) {
            $product->programs()->attach($validated['program_ids']);
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    public function show(Product $product)
    {
        $product->load('programs');
        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $programs = AffiliateProgram::where('is_active', true)->get();
        $product->load('programs');
        return view('admin.products.edit', compact('product', 'programs'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'website_url' => ['required', 'url'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'is_active' => ['nullable'],
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'max:2048'],
            'program_ids' => ['nullable', 'array'],
            'program_ids.*' => ['exists:affiliate_programs,id'],
        ]);

        $images = $product->images ?? [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                $images[] = $path;
            }
        }

        $product->update([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'website_url' => $validated['website_url'],
            'price' => $validated['price'] ?? null,
            'images' => $images,
            'is_active' => $request->has('is_active'),
        ]);

        $product->programs()->sync($validated['program_ids'] ?? []);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        // Delete images
        if ($product->images) {
            foreach ($product->images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $product->programs()->detach();
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }

    public function toggleStatus(Product $product)
    {
        $product->update(['is_active' => !$product->is_active]);

        return back()->with('success', 'Product status updated successfully.');
    }

    public function deleteImage(Product $product, int $index)
    {
        $images = $product->images ?? [];

        if (isset($images[$index])) {
            Storage::disk('public')->delete($images[$index]);
            unset($images[$index]);
            $product->update(['images' => array_values($images)]);
        }

        return back()->with('success', 'Image deleted successfully.');
    }
}
