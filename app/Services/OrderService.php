<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use App\Jobs\LowStockJob;

class OrderService
{
    /**
     * Get cart details for the authenticated user
     *
     * @return array
     */
    public function cartDetails(): array
    {
        $cartService = new CartService();
        return $cartService->details();
    }

    /**
     * Checkout the cart and create an order
     *
     * @return Order
     * @throws ValidationException
     */
    public function checkout(): Order
    {
        return DB::transaction(function () {
            $user = auth()->user();
            $cart = $user->cart()
                ->with('items.product')
                ->firstOrFail();

            // Create an empty order
            $total = 0;
            $order = Order::create([
                'user_id' => $user->id,
                'total' => $total,
            ]);

            $orderItems = [];

            foreach ($cart->items as $item) {
                $product = $item->product;

                // Last minute stock check
                if ($product->stock_quantity < $item->quantity) {
                    throw ValidationException::withMessages([
                        'stock' => "{$product->name} is out of stock"
                    ]);
                }

                $orderItems[] = [
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $item->quantity,
                    'price' => $product->price,
                ];

                // Calculate total
                $total += $product->price * $item->quantity;

                // Update stock
                $product->decrement('stock_quantity', $item->quantity);

                // dispatch event za LowStock if needed
                if ($product->stock_quantity < config('shop.low_stock_threshold')) {
                    LowStockJob::dispatch($product);
                }
            }

            // Insert order items in one query
            OrderItem::insert($orderItems);

            // Update total price
            $order->update([
                'total' => $total
            ]);

            // Empty cart
            $cart->items()->delete();

            return $order;
        });
    }
}
