<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Invoice #{{ $invoice->invoice_id }}</title>
<style>
    body {
        font-family: DejaVu Sans, sans-serif;
        font-size: 14px;
        color: #333;
        padding: 30px;
        background-color: #f9fafb;
    }
    .invoice-box {
        max-width: 800px;
        margin: auto;
        background: white;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(67, 185, 178, 0.2);
        padding: 40px 50px;
        border: 1px solid #c1f0ed;
    }
    .header {
        width: 100%;
        overflow: hidden;
        padding-bottom: 20px;
        border-bottom: 2px solid #43b9b2;
        margin-bottom: 30px;
    }
    .header:before, .header:after {
        content: "";
        display: table;
        clear: both;
    }
    .header h2 {
        float: left;
        width: 48%;
        margin: 0;
        font-size: 2.25rem;
        color: #43b9b2;
        letter-spacing: 2px;
    }
    .company-details {
        float: right;
        width: 48%;
        text-align: right;
    }
    .company-details p {
        margin: 2px 0;
        font-weight: 600;
        color: #43b9b2;
    }

    .info-table {
        width: 100%;
        margin-bottom: 40px;
        background: #e0f7f6;
        border-radius: 10px;
        box-shadow: inset 0 0 15px rgba(67, 185, 178, 0.1);
        padding: 20px;
        border-collapse: separate;
        border-spacing: 0 0;
    }
    .info-table td {
        width: 50%;
        vertical-align: top;
        padding: 0 25px;
    }
    .info-table td:first-child {
        padding-right: 25px;
    }
    .info-table td:last-child {
        padding-left: 25px;
        border-left: 2px solid #43b9b2;
    }
    .info-table h3 {
        color: #43b9b2;
        font-weight: 700;
        border-bottom: 2px solid #43b9b2;
        padding-bottom: 8px;
        margin-top: 0;
        margin-bottom: 15px;
        font-size: 1.125rem;
    }

    table.invoice-items {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
    }
    table.invoice-items th,
    table.invoice-items td {
        padding: 15px 12px;
        border-bottom: 1px solid #d4f1ef;
    }
    table.invoice-items th {
        background-color: #c7f0ef;
        color: #167873;
        font-weight: 700;
        text-align: left;
        letter-spacing: 0.03em;
    }
    table.invoice-items tbody tr:hover {
        background-color: #f0fdfa;
    }
    td.text-right {
        text-align: right;
    }
    tfoot td {
        font-weight: 700;
        font-size: 15px;
        border-top: 2px solid #43b9b2;
    }
    tfoot tr:last-child td {
        font-size: 18px;
        color: #43b9b2;
    }

    .footer {
        margin-top: 30px;
        font-size: 13px;
        color: #6b7280;
        text-align: center;
        font-style: italic;
    }
</style>
</head>
<body>
    <div class="invoice-box">
        <!-- Header -->
        <div class="header">
            <h2>INVOICE</h2>

            <div class="company-details">
                <p>{{ $setting->site_name }}</p>
                <p>{{ $setting->site_address }}</p>
                <p>{{ $setting->site_email }}</p>
            </div>
        </div>

        <!-- Invoice info and Customer info -->
        <table class="info-table">
            <tr>
                <td>
                    <h3>Invoice Details</h3>
                    <p><strong>Invoice ID:</strong> #{{ $invoice->invoice_id }}</p>
                    <p><strong>Date:</strong> {{ $invoice->created_at->format('d M, Y') }}</p>
                </td>
                <td>
                    <h3>Customer Info</h3>
                    <p><strong>Name:</strong> {{ $invoice->customer->name }}</p>
                    @if (!empty($invoice->customer->phone))
                        <p><strong>Phone:</strong> {{ $invoice->customer->phone }}</p>
                    @endif
                    @if (!empty($invoice->customer->email))
                        <p><strong>Email:</strong> {{ $invoice->customer->email }}</p>
                    @endif
                    @if (!empty($invoice->transaction_number))
                        <p><strong>Transaction Id:</strong> {{ $invoice->transaction_number }}</p>
                    @endif
                </td>
            </tr>
        </table>

        <!-- Invoice Table -->
        <table class="invoice-items">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Item</th>
                    <th class="text-right">Qty</th>
                    <th class="text-right">Price</th>
                    <th class="text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoice->orderDetails as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->product->product_name }}</td>
                        <td class="text-right">{{ $item->qty }}</td>
                        <td class="text-right">${{ number_format($item->price, 2) }}</td>
                        <td class="text-right">${{ number_format($item->subtotal, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" class="text-right">Subtotal:</td>
                    <td class="text-right">${{ number_format($invoice->subtotal, 2) }}</td>
                </tr>
                <tr>
                    <td colspan="4" class="text-right">Discount:</td>
                    <td class="text-right">${{ number_format($invoice->discount, 2) }}</td>
                </tr>
                <tr>
                    <td colspan="4" class="text-right">Grand Total:</td>
                    <td class="text-right">${{ number_format($invoice->total, 2) }}</td>
                </tr>
            </tfoot>
        </table>

        <!-- Footer -->
        <div class="footer">
            <p>Thank you for your business.</p>
            <p>If you have any questions, contact us at {{ $setting->site_email }}</p>
        </div>
    </div>
</body>
</html>
