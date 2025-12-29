<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Inertia\Inertia;
use Inertia\Response;

class ProductController extends Controller
{
    /**
     * Display a listing of products
     *
     * @return Response
     */
    public function index(): Response
    {
        // $products = Product::all();
        $products = Product::paginate(20)->withQueryString();
        return Inertia::render('Products/Index', [
            'products' => $products
        ]);
    }

    /**
     * Show a specific product page
     *
     * @param Product $product
     * @return Response
     */
    public function show(Product $product): Response
    {
        return Inertia::render('Products/Show', [
            'product' => $product
        ]);
    }
}
