<!DOCTYPE html>
<html>

<head>
    <title>Maintenance Bill</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
        }

        ul>li {
            list-style-type: none;
        }

        .invoice {
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
            color: #d9534f;
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
    <div class="invoice">
        <div class="header">
            <h1>{{ $society->name }}</h1>
            <p>{{ $society->address }}</p>
        </div>
        <div class="details">
            <div>
                <ul>
                    <li>Name: {{ $member->user->name }}</li>
                    <li>Phone: {{ $member->user->phone }}</li>
                    <li>Room Number: {{ $member->room_number }}</li>
                </ul>
            </div>
            <div>
                <ul>
                    <li>Bill Number: {{ $bill->id }}</li>
                    <li>Bill Date: {{ \Carbon\Carbon::parse($bill->created_at)->format('d/m/Y') }}</li>
                    <li>Bill Due Date: {{ \Carbon\Carbon::parse($bill->due_date)->format('d/m/Y') }}</li>
                    <li>Bill Peroid: {{ \Carbon\Carbon::createFromDate(null, $bill->billing_month, 1)->format('F Y') }}
                    </li>
                </ul>
            </div>
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
                    <td>{{ number_format($bill->amount, 2) }}</td>
                </tr>
                <tr>
                    <td colspan="3" class="total">Total</td>
                    <td>{{ number_format($bill->amount, 2) }}</td>
                </tr>
            </tbody>
        </table>
        @if ($previousPayment)
            <div class="previous-payment">
                <h3>Most Recent Previous Payment</h3>
                <p>Date: {{ $previousPayment->payment_date->format('d/m/Y') }}</p>
                <p>Amount: Rs {{ number_format($previousPayment->amount_paid, 2) }}</p>
                <p>Bill ID: {{ $previousPayment->maintenance_bills_id }}</p>
            </div>
        @endif
        <div class="note">
            <ol>
                <li>This is a computer-generated bill hence no signature is required.</li>
                <li>Please write your flat number and mobile number on the backside of cheque for cheque payments.</li>
                <li>Online payment accepted on society's bank account.</li>
            </ol>
        </div>
    </div>
</body>

</html>
