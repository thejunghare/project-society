<!DOCTYPE html>
<html>

<head>
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.4.1/dist/flowbite.min.css" rel="stylesheet" />

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

        .table {
            margin-top: 150px;
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

        .float-container {
            /* border: 3px solid #000; */
            margin: 20px;
        }

        .float-child {
            width: 50%;
            float: left;
            padding: 20px;
            /* border: 2px solid red; */
        }
    </style>
</head>

<body>
    <div class="invoice">
        {{-- society details --}}
        <div class="header">
            <h1>{{ $society->name }}</h1>
            <p>{{ $society->address }}</p>
        </div>

        {{-- member details --}}
        <div class="float-container">
            <div class="float-child">
                <ul>
                    <li>Name: {{ $member->user->name }}</li>
                    <li>Phone: +91{{ $member->user->phone }}</li>
                    <li>Unit Number: {{ $member->room_number }}</li>
                </ul>
            </div>
            <div class="float-child">
                <ul>
                    <li>Bill Number: {{ $bill->id }}</li>
                    {{-- <li>Bill Date: {{ \Carbon\Carbon::parse($bill->created_at)->format('d/m/Y') }}</li> --}}
                    <li>Due Date: {{ \Carbon\Carbon::parse($bill->due_date)->format('d/m/Y') }}</li>
                    <li>Billing Period:
                        {{ \Carbon\Carbon::createFromDate(null, $bill->billing_month, 1)->format('F Y') }}
                    </li>
                </ul>
            </div>
        </div>

        {{-- bill detials --}}
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
                    <td>Maintenance fund</td>
                    <td></td>
                    <td>{{ number_format($maintenance_amount) }}</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Service Charge</td>
                    <td></td>
                    <td>{{number_format($society->service_charges,2)}}</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Parking Charge</td>
                    <td></td>
                    <td>{{number_format($society->parking_charges,2)}}</td>
                </tr>
                {{-- TODO: make it dynamic --}}
                <tr>
                    <td>4</td>
                    <td>Late Fees</td>
                    <td></td>
                    {{-- TODO: Replace with actuall amount from socities --}}
                    <td>{{number_format($late_fee,2)}}</td>
                </tr>
                <tr>
                    <td colspan="3" class="total">Total</td>
                    {{-- TODO: Should be total of all amount --}}
                    <td>{{ number_format($maintenance_amount + $society->parking_charges + $society->service_charges + $late_fee, 2) }}</td>
                </tr>
            </tbody>
        </table>

        {{-- logically showing details of pervious bill --}}
        @if ($previousPayment)
            <div class="previous-payment">
                <h3>Most Recent Previous Payment</h3>
                <p>Date: {{ $previousPayment->payment_date->format('d/m/Y') }}</p>
                <p>Amount: Rs {{ number_format($previousPayment->amount_paid, 2) }}</p>
                <p>Bill ID: {{ $previousPayment->maintenance_bills_id }}</p>
            </div>
        @else
            <div style="margin-top: 5px"><span>No previous payment found!!</span></div>
        @endif

        {{-- notes --}}
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
