<!DOCTYPE html>
<html>
<head>
    <title>Receipt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background: #f4f4f4;
            color: #333;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
        }

        .header h1 {
            margin: 0;
            color: #d9534f;
        }

        .header h2 {
            margin: 10px 0 0;
            color: #555;
        }

        .details {
            margin-bottom: 20px;
        }

        .details p {
            margin: 5px 0;
            font-size: 16px;
        }

        .table-container {
            margin-bottom: 20px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
            font-size: 16px;
        }

        .table th {
            background: #f2f2f2;
            font-weight: bold;
        }

        .total {
            text-align: right;
            font-weight: bold;
        }

        .footer {
            text-align: center;
            margin-top: 40px;
            font-size: 14px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>{{ $society->name ?? 'Society Name Not Available' }}</h1>
            <h2>Payment Receipt</h2>
        </div>

        <div class="details">
            <p><strong>Receipt for:</strong> {{ $member->user->name ?? 'Member Name Not Available' }}</p>
            <p><strong>Payment Date:</strong> {{ $payment->payment_date ? $payment->payment_date->format('d/m/Y') : 'N/A' }}</p>
            <p><strong>Amount Paid:</strong> Rs {{ number_format($payment->amount_paid ?? 0, 2) }}</p>
        </div>

        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Bill ID</th>
                        <th>Bill Date</th>
                        <th>Due Date</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $bill->id ?? 'N/A' }}</td>
                        <td>{{ $bill->created_at ? $bill->created_at->format('d/m/Y') : 'N/A' }}</td>
                        <td>{{ $bill->due_date ? $bill->due_date->format('d/m/Y') : 'N/A' }}</td>
                        <td>Rs {{ number_format($bill->amount ?? 0, 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="footer">
            <p>Thank you for your payment!</p>
        </div>
    </div>
</body>
</html>
