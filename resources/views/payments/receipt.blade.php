<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Payment Receipt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
        }

        ul>li {
            list-style-type: none;
        }

        .receipt {
            max-width: 800px;
            margin: auto;
            padding: 20px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            color: #555;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            color: #5cb85c;
            font-size: 24px;
            margin: 0;
        }

        .header p {
            margin: 0;
        }

        .details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            grid-gap: 20px;
        }

        .details p {
            margin: 2px 0;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table,
        .table th,
        .table td {
            border: 1px solid #ddd;
        }

        .table th,
        .table td {
            padding: 8px;
            text-align: left;
        }

        .table th {
            background-color: #f2f2f2;
        }

        .total {
            text-align: right;
        }

        .note {
            margin-top: 20px;
            font-size: 12px;
        }
    </style>
</head>

<body>
    <div class="receipt">
        <div class="header">
            <h1>{{ $society->name }} - Payment Receipt</h1>
            <p>{{ $society->address }}</p>
        </div>
        <div class="details">
            <p>Name: {{ $member->user->name }}</p>
            <p>Mobile Number: {{ $member->user->phone }}</p>
            <p>Room Number: {{ $member->room_number }}</p>
            <p>Receipt Number: {{ $payment->id }}</p>
            <p>Payment Date: {{ \Carbon\Carbon::parse($payment->created_at)->format('d/m/Y') }}</p>
            <p>Bill Period: {{ \Carbon\Carbon::createFromDate(null, $maintenanceBill->billing_month, 1)->format('F Y') }}</p>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>Sr. No.</th>
                    <th>Head</th>
                    <th>Description</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Repair and maintenance fund</td>
                    <td></td>
                    <td>{{ $payment->amount_paid }}</td>
                </tr>
                <tr>
                    <td colspan="3" class="total">Total</td>
                    <td>{{ $payment->amount_paid }}</td>
                </tr>
            </tbody>
        </table>
        <div class="note">
            <p>This is a computer-generated receipt hence no signature is required.</p>
            <p>Thank you for your payment.</p>
        </div>
    </div>
</body>

</html>
