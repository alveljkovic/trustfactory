<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Rules\ProductQuantityRule;

class CartController extends Controller
{
    /**
     * Cart service dependancy
     *
     * @var CartService
     */
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * Display the cart page
     *
     * @return Response
     */
    public function index(): Response
    {
        $cartDetails = $this->cartService->details();

        return Inertia::render('Cart/Index', [
            'cartSummary' => $cartDetails
        ]);
    }

    /**
     * Add a product to the cart
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1', new ProductQuantityRule($request->product_id)]
        ]);

        $this->cartService->add($request->product_id, $request->input('quantity', 1));

        return redirect()->back()->with('success', 'Product added to cart');
    }

    /**
     * Update product quantity in the cart
     *
     * @param Request $request
     * @param Product $product
     * @return RedirectResponse
     */
    public function update(Request $request, Product $product): RedirectResponse
    {
        $request->validate([
            'quantity' => ['required', 'integer', 'min:1', new ProductQuantityRule($product->id)]
        ]);

        $this->cartService->update($product, $request->quantity);

        return redirect()->back()->with('success', 'Cart updated');
    }

    /**
     * Remove a product from the cart
     *
     * @param Product $product
     * @return RedirectResponse
     */
    public function destroy(Product $product): RedirectResponse
    {
        $this->cartService->remove($product);

        return redirect()->back()->with('success', 'Product removed from cart');
    }
}
