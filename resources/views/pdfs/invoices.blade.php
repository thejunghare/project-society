{{-- Not working --}}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
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
    @foreach ($members as $member)
        <div class="invoice">
            <div class="header">
                <h1>{{ $society->name }}</h1>
                <p>{{ $society->address }}</p>
            </div>
            <div class="details">
                <p>Name: {{ $member->user->name }}</p>
                <p>Mobile Number: {{ $member->user->phone }}</p>
                <p>Room Number: {{ $member->room_number }}</p>
                @php
                    $bill = $bills->firstWhere('member_id', $member->id);
                @endphp
                <p>Bill Number: {{ $bill->id }}</p>
                <p>Bill Date: {{ \Carbon\Carbon::parse($bill->created_at)->format('d/m/Y') }}</p>
                <p>Due Date: {{ \Carbon\Carbon::parse($bill->due_date)->format('d/m/Y') }}</p>
                <p>Bill Period: {{ \Carbon\Carbon::createFromDate(null, $bill->billing_month, 1)->format('F Y') }}</p>
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
                        <td>{{ $bill->amount }}</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="total">Total</td>
                        <td>{{ $bill->amount }}</td>
                    </tr>
                </tbody>
            </table>
            <div class="note">
                <p>This is a computer-generated bill hence no signature is required.</p>
                <p>Please write your flat number and mobile number on the backside of cheque for cheque payments.</p>
                <p>Online payment accepted on society's bank account.</p>
            </div>
        </div>
        <div style="page-break-after: always;"></div>
    @endforeach

</body>

</html>
