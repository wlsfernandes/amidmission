<?php
namespace App\Http\Controllers;

use App\Helpers\S3;
use App\Models\Product;
use App\Models\Store;
use App\Services\SystemLogger;
use Exception;
use Illuminate\Http\Request;

class StoreController extends BaseController
{

/*  */
    public function indexPublic()
    {
        $products = Product::where('is_published', true)->paginate(12);

        return view('frontend.store.index', compact('products'));
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        return view('frontend.store.show', compact('product'));
    }
/**
 * Validation rules
 * (Project standard: before store/update)
 */
    protected function validatedData(Request $request): array
    {
        return $request->validate([
            'name'         => ['required', 'string', 'max:255'],
            'type'         => ['nullable', 'string', 'max:255'],

            'content_en'   => ['nullable', 'string'],
            'content_es'   => ['nullable', 'string'],

            'image_url'    => ['nullable', 'string'],

            'is_published' => ['required', 'boolean'],

        ]);
    }

    /**
     * Display a listing of stores.
     */
    public function index()
    {
        $stores = Store::orderBy('name')->get();

        return view('admin.stores.index', compact('stores'));
    }

    /**
     * Show the form for creating a new store.
     */
    public function create()
    {
        return view('admin.stores.form');
    }

    /**
     * Store a newly created store.
     */
    public function store(Request $request)
    {
        // ✅ Validation first
        $data = $this->validatedData($request);

        try {
            $store = Store::create($data);

            SystemLogger::log(
                'Store created',
                'info',
                'stores.store',
                [
                    'store_id' => $store->id,
                    'slug'     => $store->slug,
                    'email'    => $request->email,
                ]
            );

            return redirect()
                ->route('stores.index')
                ->with('success', 'Store created successfully.');

        } catch (Exception $e) {
            SystemLogger::log(
                'Store creation failed',
                'error',
                'stores.store',
                [
                    'exception' => $e->getMessage(),
                    'email'     => $request->email,
                ]
            );

            return back()
                ->withInput()
                ->with('error', 'Failed to create store.');
        }
    }

    /**
     * Show the form for editing the specified store.
     */
    public function edit(Store $store)
    {
        return view('admin.stores.form', compact('store'));
    }

    /**
     * Update the specified store.
     */
    public function update(Request $request, Store $store)
    {
        // ✅ Validation first
        $data = $this->validatedData($request);

        try {
            $store->update($data);

            SystemLogger::log(
                'Store updated',
                'info',
                'stores.update',
                [
                    'store_id' => $store->id,
                    'slug'     => $store->slug,
                    'email'    => $request->email,
                ]
            );

            return redirect()
                ->route('stores.index')
                ->with('success', 'Store updated successfully.');

        } catch (Exception $e) {
            SystemLogger::log(
                'Store update failed',
                'error',
                'stores.update',
                [
                    'store_id'  => $store->id,
                    'exception' => $e->getMessage(),
                    'email'     => $request->email,
                ]
            );

            return back()
                ->withInput()
                ->with('error', 'Failed to update store.');
        }
    }

    /**
     * Remove the specified store.
     */
    public function destroy(Store $store)
    {
        try {
            // Cleanup image if exists
            if (! empty($store->image_url)) {
                S3::delete($store->image_url);
            }

            $store->delete();

            SystemLogger::log(
                'Store deleted',
                'warning',
                'stores.delete',
                [
                    'store_id' => $store->id,
                    'email'    => request()->email,
                ]
            );

            return redirect()
                ->route('stores.index')
                ->with('success', 'Store deleted successfully.');

        } catch (Exception $e) {
            SystemLogger::log(
                'Store deletion failed',
                'error',
                'stores.delete',
                [
                    'store_id'  => $store->id,
                    'exception' => $e->getMessage(),
                    'email'     => request()->email,
                ]
            );

            return back()
                ->with('error', 'Failed to delete store.');
        }
    }
}
