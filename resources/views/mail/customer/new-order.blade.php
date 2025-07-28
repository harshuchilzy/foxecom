<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml"
    xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
    <title></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            margin: 0;
            padding: 0;
            background: #f9f9f9;
            font-family: 'Helvetica Neue', Arial, sans-serif;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        .container {
            max-width: 600px;
            margin: auto;
            background: #fff;
            border: 1px solid #ddd;
        }

        .header {
            border-bottom: 5px solid #333957;
            padding: 20px;
            text-align: center;
        }

        .logo {
            width: 64px;
        }

        .content {
            padding: 20px 25px;
        }

        .title {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }

        .order-summary {
            margin-top: 30px;
        }

        .order-summary table {
            width: 100%;
            font-size: 14px;
            border: 1px solid #eee;
        }

        .order-summary th,
        .order-summary td {
            padding: 10px;
            border: 1px solid #eee;
            text-align: left;
        }

        .order-summary th {
            background-color: #f1f1f1;
        }

        .total-row td {
            font-weight: bold;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            color: #575757;
            padding: 20px;
        }

        .btn {
            background-color: #2F67F6;
            color: white;
            padding: 12px 20px;
            text-decoration: none;
            border-radius: 4px;
            display: inline-block;
            margin: 30px auto;
        }
    </style>
</head>

<body>
    <div class="container">

        <!-- Header -->
        <div class="header">
            <img src="{{ url('/') .'/images/blacklogo.png' }}" width="64" style="display:block;" />
        </div>

        <!-- Content -->
        <div class="content">
            <div class="title">Order Confirmation</div>

            <p>Hello <strong>{{ $first_name }} {{ $last_name }}</strong>,</p>

            <p>Thank you for your order with <strong>Foxergo</strong>! We’ve received your order and will start processing it shortly.</p>

            <!-- Order Summary -->
            <div class="order-summary">
                <h3>Order Summary</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Qty</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->lines as $line)
                            @if($line->type == 'physical')
                                @php
                                    $product = $line->purchasable->product;
                                @endphp
                                <tr>
                                    <td style="padding:10px; border:1px solid #eee;">
                                        <img src="{{ $product->thumbnail?->getUrl('small') }}" alt="{{ $product->translateAttribute('name') }}" width="50" style="display:block; max-width:50px;">
                                    {{-- </td>
                                    <td style="padding:10px; border:1px solid #eee;"> --}}
                                        {{ $product->translateAttribute('name') }}
                                        @if($line->purchasable_type == 'product_variant')
                                            <br><small><strong>Flavour:</strong> {{ $line->option }}</small>
                                        @endif
                                    </td>
                                    <td style="padding:10px; border:1px solid #eee;">
                                        {{ $line->unit_quantity }}
                                    </td>
                                     <td style="padding:10px; border:1px solid #eee;">
                                        {{ $line->total->formatted() }}
                                     </td>
                                </tr>
                            @endif
                        @endforeach

                        <!-- Repeat this row for each item -->
                    
                        <!-- End repeat -->
                        @if ($order->discount_total)
                            <tr class="total-row">
                                <td colspan="2">Discounts</td>
                                <td>{{$order->discount_total->formatted()}}</td>
                            </tr>
                        @endif
                        
                        @if ($order->tax_total)
                           <tr class="total-row">
                                <td colspan="2">Tax</td>
                                <td>{{$order->tax_total->formatted()}}</td>
                            </tr> 
                        @endif
                        
                        @if ($order->shipping_total)
                           <tr class="total-row">
                                <td colspan="2">Shipping</td>
                                <td>{{$order->shipping_total->formatted()}}</td>
                            </tr> 
                        @endif
                        
                        <tr class="total-row">
                            <td colspan="2">Total</td>
                            <td>{{$order->total->formatted()}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Button -->
            <div style="text-align:center;">
                <a href="{{ $order_link }}" class="btn">View Your Order</a>
            </div>

            <p>If you have any questions, feel free to reply to this email or contact our support team.</p>

            <p>Best regards,<br>The Foxergo Team</p>
        </div>

        <!-- Footer -->
        <div class="footer">
            Foxergo Ltd., 24 Sanderling Way, Porthcawl, Wales, CF36 3TD<br>
            Phone: +44 7925 606692 — Email: <a href="mailto:accounts@foxergo.com" style="color:#575757;">accounts@foxergo.com</a><br>
            <a href="{{ $unsubscribe_url }}" style="color:#575757;">Unsubscribe</a> from our emails
        </div>
    </div>
</body>

</html>
