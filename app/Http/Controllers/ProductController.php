<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log; // Correct import

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $products = Cache::remember('products', 60, function () {
            return Product::all();
        });
        return response()->json($products);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        //

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Log::info('Store method accessed.', [
            'token' => $request->bearerToken(),
            'authenticated_user' => auth()->user()
        ]);

        if (!auth()->check()) {
            Log::warning('No authenticated user.', [
                'token' => $request->bearerToken()
            ]);
            return response()->json(['message' => 'No authenticated user'], 401);
        }
        
        try {

            $validator = Validator::make($request->all(), [
                'name'=>'required|max:255',
                'description'=>'required',
                'price'=>'required|numeric|min:0'
            ]);

            if($validator->fails()) {
                return response()->json($validator->errors(),400);
            }

            $product = Product::Create($request->all());
            return response()->json($product, 201);

        }

        catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }

    
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
        $producs = Cache::remember('products'. $product->id, 60, function () use ($product) {
            return $product;
        });

        return response()->json($producs);}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
        try {
            
            $validated = $request->validate([
                'name' => 'required|max:255',
                'description' => 'required',
                'price' => 'required|numeric|min:0'
            ]);
    
            $product->update($validated);

            Cache::forget('products.' . $product->id); // Clear cache for this product
            Cache::forget('products.all'); // Optional: Clear all products cache if needed

            return response()->json($product, 200);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $product = Product::findOrFail($id);
        $product->delete();

        Cache::forget('products');

        return response()->json(['success' => 'Product deleted successfully']);
    
    }
}
