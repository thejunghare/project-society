<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Members Bills - {{ $month }} {{ $year }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
    </style>
</head>
<body>
    <h1 class="text-center">Members Bills - {{ $month }} {{ $year }}</h1>

    <table>
        <thead>
            <tr>
                <th>Sr No.</th>
                <th>Room No.</th>
                <th>Name</th>
                <th>Bill Amount (₹)</th>
                <th>Status</th>
                <th>Total Received This Year (₹)</th>
                <th>Total Received To Date (₹)</th>
                <th>Total Receivable This Year (₹)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $item)
            <tr>
                <td>{{ $item['sr_no'] }}</td>
                <td>{{ $item['room_no'] }}</td>
                <td>{{ $item['name'] }}</td>
                <td class="text-right">{{ $item['bill_amount'] }}</td>
                <td>{{ $item['status'] }}</td>
                <td class="text-right">{{ $item['total_received_this_year'] }}</td>
                <td class="text-right">{{ $item['total_received_to_date'] }}</td>
                <td class="text-right">{{ $item['total_receivable_this_year'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- <p><strong>Grand Total Receivable This Year:</strong> ₹{{ number_format($grandTotalReceivable, 2) }}</p>
    <p><strong>Grand Total Received This Year:</strong> ₹{{ number_format($grandTotalThisYear, 2) }}</p>
    <p><strong>Grand Total Received To Date:</strong> ₹{{ number_format($grandTotalToDate, 2) }}</p> --}}
</body>
</html>
