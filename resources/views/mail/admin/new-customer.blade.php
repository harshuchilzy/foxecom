<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>New Order Notification</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <style>
        body {
            background: #f9f9f9;
            font-family: 'Helvetica Neue', Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: auto;
            background: #ffffff;
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

        .title {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin: 20px 0;
            text-align: center;
        }

        .content {
            padding: 20px 25px;
            color: #333;
        }

        .section-title {
            font-size: 16px;
            font-weight: bold;
            margin: 20px 0 10px;
        }

        table {
            width: 100%;
            border: 1px solid #eee;
            border-collapse: collapse;
            font-size: 14px;
        }

        th, td {
            padding: 10px;
            border: 1px solid #eee;
            text-align: left;
        }

        th {
            background: #f1f1f1;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            color: #575757;
            padding: 20px;
        }
    </style>
</head>

<body>
    <div class="container">

        <!-- Header -->
        <div class="header">
            <img class="logo" src="{{ url('/') .'/images/blacklogo.png' }}" alt="Foxergo Logo" />
        </div>

        <!-- Title -->
        <div class="title">New Wholesale Customer Sign Up</div>

        <!-- Content -->
        <div class="content">

            <!-- Customer Details -->
            <div class="section-title">Customer Details</div>
            <table>
                <tbody>
                    <tr>
                        <th>Full Name</th>
                        <td>{{ $first_name }} {{ $last_name }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $email }}</td>
                    </tr>
                    <tr>
                        <th>Phone</th>
                        <td>{{ $phone }}</td>
                    </tr>
                </tbody>
            </table>

            <p style="margin-top: 30px;">
                You can review the new wholesale customer in the admin dashboard.
            </p>

        </div>

        <!-- Footer -->
        <div class="footer">
            Foxergo Ltd., 24 Sanderling Way, Porthcawl, Wales, CF36 3TD<br />
            Phone: +44 7925 606692 — Email: <a href="mailto:accounts@foxergo.com" style="color:#575757;">accounts@foxergo.com</a>
        </div>
    </div>
</body>

</html>
