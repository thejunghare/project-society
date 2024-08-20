<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Combined Bills</title>
    <style>
        /* Add your CSS styles here */
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }

        .page-break {
            page-break-after: always;
        }

        /* Add more styles as needed */
    </style>
</head>

<body>
    @foreach ($data as $item)
        @if ($item['type'] == 'invoice')
            <h2>Invoice</h2>
            @include('pdfs.invoice', $item)
        @else
            <h2>Receipt</h2>
            @include('pdfs.receipt', $item)
        @endif
        @if (!$loop->last)
            <div class="page-break"></div>
        @endif
    @endforeach
</body>

</html>
