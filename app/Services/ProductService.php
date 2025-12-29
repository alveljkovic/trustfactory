<?php

namespace App\Services;

use App\Jobs\LowStockJob;
use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProductService
{
    /**
     * Get paginated list of products
     *
     * @return LengthAwarePaginator
     */
    public function getPaginated(): LengthAwarePaginator
    {
        return Product::paginate(config('shop.pagination_size'))
            ->withQueryString();
    }

    /**
     * Check and dispatch low stock action if needed
     *
     * @param Product $product
     * @return void
     */
    public static function lowStockAction($product): void
    {
        if ($product->stock_quantity < config('shop.low_stock_threshold')) {
            LowStockJob::dispatch($product);
        }
    }
}
