<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Daily Sales Report</title>
    </head>
    <body style="font-family: Arial; background:#f9fafb; padding:20px;">
        <div style="max-width:800px; margin:auto; background:#fff; padding:20px; border-radius:6px;">

            <h2>Daily Sales Report</h2>
            <p>Date: <strong>{{ $date }}</strong></p>

            @forelse($orders as $order)
                <hr>

                <h3>
                    Order #{{ $order->id }}
                </h3>

                <p>
                    Customer:
                    <strong>{{ $order->user->name }}</strong>
                    ({{ $order->user->email }})
                </p>

                <table width="100%" cellpadding="6" cellspacing="0" style="border-collapse: collapse;">
                    <thead>
                        <tr style="border-bottom:1px solid #ddd;">
                            <th align="left">Product</th>
                            <th align="right">Qty</th>
                            <th align="right">Price</th>
                            <th align="right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                            <tr>
                                <td>{{ $item->product_name }}</td>
                                <td align="right">{{ $item->quantity }}</td>
                                <td align="right">${{ number_format($item->price, 2, '.', ',') }}</td>
                                <td align="right">
                                    {{ \Illuminate\Support\Number::currency($item->price * $item->quantity, 'USD') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <p style="text-align:right; margin-top:8px;">
                    <strong>Order total:</strong>
                    {{ \Illuminate\Support\Number::currency($order->total, 'USD') }}
                </p>

            @empty
                <p>No orders for this day.</p>
            @endforelse

            <hr>

            <h2 style="text-align:right;">
                Daily Total:
                {{ \Illuminate\Support\Number::currency($dailyTotal, 'USD') }}
            </h2>

            <p style="font-size:12px; color:#6b7280;">
                This report was generated automatically.
            </p>
        </div>
    </body>
</html>