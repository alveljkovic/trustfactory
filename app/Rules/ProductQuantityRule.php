<?php

namespace App\Rules;

use App\Models\Product;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ProductQuantityRule implements ValidationRule
{
    protected int $productId;

    /**
     * @param int $productId
     * @param int|null $existingQuantity
     */
    public function __construct(int $productId)
    {
        $this->productId = $productId;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $product = Product::find($this->productId);

        if (! $product) {
            $fail('Selected product does not exist.', null);
            return;
        }

        $requestedQty = (int) $value;
        $currentQty = $this->existingQuantity ?? 0;
        $diff = $requestedQty - $currentQty;

        if ($diff <= 0) {
            return;
        }

        if ($product->stock_quantity < $diff) {
            $fail($this->message(), null);
        }
    }

    public function message(): string
    {
        return 'Requested quantity exceeds available stock.';
    }
}
