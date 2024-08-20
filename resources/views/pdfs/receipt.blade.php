<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .receipt {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .header-title {
            color: red;
            font-weight: bold;
            font-size: 2.5rem;
        }

        .header-subtitle {
            color: gray;
            font-size: 1.5rem;
        }

        .table-header {
            background-color: #f8f9fa;
        }

        .table-cell {
            border: 1px solid #e9ecef;
            padding: 1rem;
            font-size: 1.125rem;
        }

        .note {
            font-size: 1rem;
            color: #6c757d;
        }

        .footer-note {
            font-size: 0.875rem;
            color: #6c757d;
        }
    </style>
</head>

<body class="bg-gray-100 p-6">
    <div class="receipt my-8">
        <div class="text-center mb-8">
            <h1 class="header-title">{{ $society->name ?? 'Society Name Not Available' }}</h1>
            <p class="header-subtitle">{{ $society->address }}</p>
        </div>

        <hr class="my-8">

            <!-- Receipt number and payment date -->
        <div class="flex justify-between mb-6">
            <div class="text-base font-bold">Receipt No: {{ $currentPayment->id }}</div>
            <div class="text-base font-bold">Received Date: {{ $currentPayment->payment_date ? $currentPayment->payment_date->format('d F Y') : 'N/A' }}</div>
        </div>

        <!-- username/owner name -->
        <div class="mb-6">
            <span class="font-bold text-lg">Received from:</span>
            {{ $member->user->name ?? 'Member Name Not Available' }}
        </div>

        <!-- total amount in words -->
        <div class="mb-6">
            <span class="font-bold text-lg">Sum of Rs:</span> {{ ucwords($amountInWords) }}
        </div>

        <!-- info about payment mode -->
        <div class="mb-6">
            @if ($payment_mode_id)
                @if ($payment_mode_id == 1)
                    <span class="font-bold text-lg">By Online Transaction with reference No:</span>
                    {{ $transaction_id ?? 'N/A' }}
                @elseif($payment_mode_id == 2 || $payment_mode_id == 3)
                    <span class="font-bold text-lg">By
                        @if ($payment_mode_id == 2)
                            Cheque
                        @elseif($payment_mode_id == 3)
                            Cash
                        @endif
                        Transaction with reference No:
                    </span>
                    {{ $reference_no ?? 'N/A' }}
                @endif
            @else
                <span class="font-bold text-lg">Payment information not available</span>
            @endif
        </div>

        <!-- invoice number -->
        <div class="mb-6">
            <span class="font-bold text-lg">Towards Bills/Invoice no:</span> {{ $bill->id }}
        </div>

        <!-- room number -->
        <div class="mb-6">
            <span class="font-bold text-lg">Flat No:</span> {{ $member->room_number }}
        </div>

        <!-- maintenance peroid -->
        <div class="mb-6">
            <span class="font-bold text-lg">Note:</span> Maintenance paid for
            {{ \Carbon\Carbon::createFromDate(null, $bill->billing_month, 1)->format('F Y') }}
        </div>

        <!-- amount -->
        <div class="mb-6">
            <table class="w-full border-collapse">
                <thead class="table-header">
                    <tr>
                        <th class="table-cell">Amount in RS</th>
                        <th class="table-cell">{{ number_format($currentPayment->amount_paid ?? 0, 2) }}</th>
                    </tr>
                </thead>
            </table>
        </div>


        <!-- notes -->
        <div class="mt-8 note">
            <p># This is a computer-generated receipt hence signature is not required.</p>
            <p># Cheque is subject to realization.</p>
        </div>
    </div>
</body>

</html>
