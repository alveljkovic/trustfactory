<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Low Stock Notification</title>
    </head>
    <body style="font-family: Arial, sans-serif; background-color: #f9fafb; padding: 20px;">
        <div style="max-width: 600px; margin: auto; background: #ffffff; padding: 20px; border-radius: 6px;">
            <h2 style="color: #dc2626;">⚠️ Low Stock Alert</h2>

            <p>The following product is running low on stock:</p>

            <table style="width: 100%; border-collapse: collapse; margin-top: 16px;">
                <tr>
                    <td style="padding: 8px; font-weight: bold;">Product</td>
                    <td style="padding: 8px;">{{ $product->name }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px; font-weight: bold;">Price</td>
                    <td style="padding: 8px;">
                        ${{ number_format($product->price, 2) }}
                    </td>
                </tr>
                <tr>
                    <td style="padding: 8px; font-weight: bold;">Stock left</td>
                    <td style="padding: 8px; color: #dc2626;">
                        {{ $product->stock_quantity }}
                    </td>
                </tr>
            </table>

            <p style="margin-top: 20px;">
                Please consider restocking this product as soon as possible.
            </p>

            <p style="font-size: 12px; color: #6b7280; margin-top: 30px;">
                This is an automated notification.
            </p>
        </div>
    </body>
</html>