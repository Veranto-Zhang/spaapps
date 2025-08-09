<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\StockLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $products = Product::orderByDesc('name')->paginate(20);
        return view('products.index', compact('products'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $productCategories = ProductCategory::orderBy('name')->get();
        return view('products.create', compact('productCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        //
        DB::transaction(function () use ($request) {
            
            $validated = $request->validated();

            $newProduct = Product::create($validated);
        });

        return redirect()->route('products.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
        $productCategories = ProductCategory::orderBy('name')->get();
        return view('products.edit', compact('product', 'productCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product)
    {
        //
        DB::transaction(function () use ($request, $product) {
            
            $validated = $request->validated();


            $product->update($validated);
        });

        return redirect()->route('products.index');
    }

    public function stockedit(Product $product)
    {
        //
        $stockLogs = $product->stockLogs()
                    ->with('user')
                    ->orderBy('created_at', 'desc')
                    ->paginate(20);
        return view('products.stockedit', compact('product', 'stockLogs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateStock(Request $request, Product $product)
    {
        $validated = $request->validate([
            'stock' => ['required', 'integer'],
        ]);
    
        DB::transaction(function () use ($validated, $product) {
            $oldStock = $product->stock;
    
            // Update stock
            $product->update(['stock' => $validated['stock']]);
    
            // Log the change
            StockLog::create([
                'product_id' => $product->id,
                'old_stock' => $oldStock,
                'new_stock' => $validated['stock'],
                'changed_by' => Auth::id(),
            ]);
        });
    
        return redirect()->route('products.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
        DB::transaction(function() use($product){
            $product->delete();
        });

        return redirect()->route('products.index');
    }

    
}
