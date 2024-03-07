<link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />


<!-- Your Livewire component view -->
<div>
    @if($invoice)
        <p>Member Name: {{ $invoice->user->name }}</p>
        <p>Society Name: {{ $invoice->society->name }}</p>
    @endif

    <!-- Rest of your view -->
</div>

