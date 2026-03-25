<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Store;
use Illuminate\Http\Request;
use App\Services\SystemLogger;
use App\Helpers\S3;
use Exception;

class ProductController extends BaseController
{
    /**
     * Validation rules
     * (Project standard: before store/update)
     */
    protected function validatedData(Request $request): array
    {
        return $request->validate([
            'store_id' => ['required', 'exists:stores,id'],

            'name' => ['required', 'string', 'max:255'],
            'type' => ['nullable', 'string', 'max:255'],

            'description_en' => ['nullable', 'string'],
            'description_es' => ['nullable', 'string'],

            'price' => ['required', 'numeric', 'min:0'],
            'currency' => ['required', 'string', 'size:3'],

            'sku' => ['nullable', 'string', 'max:255'],
            'stock' => ['nullable', 'integer', 'min:0'],

            'is_digital' => ['required', 'boolean'],
            'file_url' => ['nullable', 'string'],

            'image_url' => ['nullable', 'string'],

            'is_published' => ['required', 'boolean'],
        ]);
    }

    /**
     * Display a listing of products.
     */
    public function index()
    {
        $products = Product::with('store')
            ->orderBy('name')
            ->get();

        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        $stores = Store::orderBy('name')->get();

        return view('admin.products.form', compact('stores'));
    }

    /**
     * Store a newly created product.
     */
    public function store(Request $request)
    {
        // ✅ Validation first
        $data = $this->validatedData($request);

        try {
            $product = Product::create($data);

            SystemLogger::log(
                'Product created',
                'info',
                'products.store',
                [
                    'product_id' => $product->id,
                    'slug' => $product->slug,
                    'store_id' => $product->store_id,
                    'email' => $request->email,
                ]
            );

            return redirect()
                ->route('products.index')
                ->with('success', 'Product created successfully.');

        } catch (Exception $e) {
            SystemLogger::log(
                'Product creation failed',
                'error',
                'products.store',
                [
                    'exception' => $e->getMessage(),
                    'email' => $request->email,
                ]
            );

            return back()
                ->withInput()
                ->with('error', 'Failed to create product.');
        }
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product)
    {
        $stores = Store::orderBy('name')->get();

        return view('admin.products.form', compact('product', 'stores'));
    }

    /**
     * Update the specified product.
     */
    public function update(Request $request, Product $product)
    {
        // ✅ Validation first
        $data = $this->validatedData($request);

        try {
            $product->update($data);

            SystemLogger::log(
                'Product updated',
                'info',
                'products.update',
                [
                    'product_id' => $product->id,
                    'slug' => $product->slug,
                    'store_id' => $product->store_id,
                    'email' => $request->email,
                ]
            );

            return redirect()
                ->route('products.index')
                ->with('success', 'Product updated successfully.');

        } catch (Exception $e) {
            SystemLogger::log(
                'Product update failed',
                'error',
                'products.update',
                [
                    'product_id' => $product->id,
                    'exception' => $e->getMessage(),
                    'email' => $request->email,
                ]
            );

            return back()
                ->withInput()
                ->with('error', 'Failed to update product.');
        }
    }

    /**
     * Remove the specified product.
     */
    public function destroy(Product $product)
    {
        try {
            // Cleanup digital file if exists
            if (!empty($product->file_url)) {
                S3::delete($product->file_url);
            }

            // Cleanup image if exists
            if (!empty($product->image_url)) {
                S3::delete($product->image_url);
            }

            $product->delete();

            SystemLogger::log(
                'Product deleted',
                'warning',
                'products.delete',
                [
                    'product_id' => $product->id,
                    'email' => request()->email,
                ]
            );

            return redirect()
                ->route('products.index')
                ->with('success', 'Product deleted successfully.');

        } catch (Exception $e) {
            SystemLogger::log(
                'Product deletion failed',
                'error',
                'products.delete',
                [
                    'product_id' => $product->id,
                    'exception' => $e->getMessage(),
                    'email' => request()->email,
                ]
            );

            return back()
                ->with('error', 'Failed to delete product.');
        }
    }
}
