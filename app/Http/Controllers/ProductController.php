<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\ProductService;
use Inertia\Inertia;
use Inertia\Response;

class ProductController extends Controller
{
    protected ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Display a listing of products
     *
     * @return Response
     */
    public function index(): Response
    {
        $products = $this->productService->getPaginated();

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
