<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Product;

class CartService
{
    /**
     * Get or create the cart for the authenticated user
     *
     * @return Cart
     */
    protected function cart(): Cart
    {
        return auth()->user()
            ->cart()
            ->firstOrCreate();
    }

    /**
     * Add a product to the cart
     *
     * @param int $productId
     * @param int $quantity
     * @return void
     */
    public function add(int $productId, int $quantity = 1): void
    {
        $product = Product::findOrFail($productId);
        $cart = $this->cart();

        $item = $cart->items()
            ->where('product_id', $product->id)
            ->first();

        if ($item) {
            $newQuantity = $item->quantity + $quantity;

            $item->update([
                'quantity' => $newQuantity
            ]);
        } else {
            $cart->items()->create([
                'product_id' => $product->id,
                'quantity' => $quantity
            ]);
        }
    }

    /**
     * Update a product in the cart
     *
     * @param Product $product
     * @return void
     */
    public function update(Product $product, int $quantity): void
    {
        if ($quantity <= 0) {
            $this->remove($product);
            return;
        }

        $cart = $this->cart();

        $cart->items()
            ->where('product_id', $product->id)
            ->update([
                'quantity' => $quantity
            ]);
    }

    /**
     * Remove a product from the cart
     *
     * @param Product $product
     * @return void
     */
    public function remove(Product $product): void
    {
        $cart = $this->cart();

        $cart->items()
            ->where('product_id', $product->id)
            ->delete();
    }

    /**
     * Get the cart with items and products
     *
     * @return Cart
     */
    public function get(): Cart
    {
        return $this->cart()
            ->load('items.product');
    }

    /**
     * Get cart details including subtotal
     *
     * @return array
     */
    public function details(): array
    {
        $cart = $this->get();

        $subtotal = 0;

        foreach ($cart->items as $item) {
            $subtotal += $item->quantity * $item->product->price;
        }

        return [
            'items' => $cart->items,
            'subtotal' => $subtotal,
        ];
    }
}
