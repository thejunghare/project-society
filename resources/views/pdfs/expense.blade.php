<!DOCTYPE html>
<html>
<head>
    <title>Expense Receipt</title>
    <style>
        /* Add your CSS styles here */
        body { font-family: Arial, sans-serif; }
        .container { width: 100%; margin: 0 auto; padding: 20px; }
        .header, .footer { text-align: center; }
        .content { margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Expense Receipt</h1>
        </div>
        <div class="content">
            <p><strong>Expense ID:</strong> {{ $expense->id }}</p>
            <p><strong>Expense Type:</strong> {{ $expense->expenseType->name }}</p>
            <p><strong>Amount:</strong> ${{ number_format($expense->amount, 2) }}</p>
            <p><strong>Reference Number:</strong> {{ $expense->reference_number }}</p>
            <p><strong>Remark:</strong> {{ $expense->remark }}</p>
            <p><strong>Society:</strong> {{ $society->name }}</p>
            <p><strong>Amount in Words:</strong> {{ $amountInWords }}</p>
        </div>
        <div class="footer">
            <p>Thank you for your payment!</p>
        </div>
    </div>
</body>
</html>
