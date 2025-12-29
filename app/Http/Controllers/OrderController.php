<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class OrderController extends Controller
{
    /**
     * Order service dependency
     *
     * @var OrderService
     */
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * Display the Order checkout page
     *
     * @return Response
     */
    public function index(): Response
    {
        $cartDetails = $this->orderService->cartDetails();
        return Inertia::render('Checkout/Index', [
            'cartSummary' => $cartDetails
        ]);
    }

    /**
     * Display the Order page
     *
     * @return Response
     */
    public function show(Order $order): Response
    {
        return Inertia::render('Order/Index', [
            'order' => $order->load('items.product')
        ]);
    }

    /**
     * Handle the checkout process - creating an order
     *
     * @return RedirectResponse
     */
    public function store(): RedirectResponse
    {
        try {
            $order = $this->orderService->checkout();
        } catch (\Throwable $e) {
            return redirect()->route('order.show', ['order' => $order])
                ->with('error', $e->getMessage());
        }

        return redirect()->route('order.show', ['order' => $order])
            ->with('success', 'Order is placed successfully!');
    }
}
