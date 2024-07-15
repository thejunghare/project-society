<x-app-layout>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Bills') }}
        </h2>
    </x-slot>
    @section('title', 'Pay Bill')
 
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white dark:bg-gray-800">
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <div class="bg-green-100 rounded-lg p-6 mb-6 shadow-md hover:shadow-lg transition-shadow duration-300 ease-in-out">
                        <div class="flex justify-between items-center mb-4">
                            <div>
                                <h3 class="text-lg font-semibold text-green-700">Total Due</h3>
                                <p class="text-4xl font-bold text-green-500">₹{{ number_format($totalDue, 2) }}</p>
                            </div>
                        </div>
                    </div>

                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Unpaid Bills</h3>

                    @if ($unpaidBills->isEmpty())
                        <p class="text-green-500 mb-6">No unpaid bills at the moment.</p>
                    @else
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                            @foreach ($unpaidBills as $bill)
                                <div class="max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 ease-in-out">
                                    <div class="mb-4">
                                        <div class="text-lg font-bold text-green-900 dark:text-green-100">
                                            ₹{{ number_format($bill->amount, 2) }}
                                        </div>
                                        <div class="text-sm text-green-500 dark:text-green-400">
                                            <i class="fas fa-calendar-alt mr-2"></i>Due Date: {{ $bill->due_date->format('d-m-Y') }}
                                        </div>
                                    </div>
                                    <hr class="my-4 border-gray-200 dark:border-gray-700">
                                    <div class="flex flex-col sm:flex-row items-center justify-between space-y-4 sm:space-y-0 sm:space-x-2">
                                        <a href="{{ route('download.invoice', $bill->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded flex items-center space-x-2 shadow-md hover:shadow-lg transition-shadow duration-300 ease-in-out">
                                            <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 13V4M7 14H5a1 1 0 0 0-1 1v4a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-4a1 1 0 0 0-1-1h-2m-1-5-4 5-4-5m9 8h.01" />
                                            </svg>
                                            <span>Download Invoice</span>
                                        </a>

                                        <form id="payment-form" method="POST" action="{{ route('process.payment') }}" class="w-full sm:w-auto">
                                            @csrf
                                            <input type="hidden" name="bill_id" value="{{ $bill->id }}">
                                            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full sm:w-auto">
                                                Pay Bill
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Paid Bills</h3>

                    @if ($paidBills->isEmpty())
                        <p class="text-green-500">No paid bills to display.</p>
                    @else
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach ($paidBills as $bill)
                                <div class="max-w-sm p-6 bg-gray-100 border border-gray-200 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 ease-in-out">
                                    {{-- <div class="flex justify-between items-center mb-2">
                                        <h5 class="text-xl font-bold text-gray-900 dark:text-gray-100">Bill {{ $bill->id }}</h5>
                                        <span class="text-mygreen-500 font-semibold"><i class="fas fa-check-circle mr-2"></i>Paid</span>
                                    </div> --}}
                                    <div class="mb-4">
                                        <div class="text-lg font-bold text-gray-900 dark:text-gray-100">
                                            ₹{{ number_format($bill->amount, 2) }}
                                        </div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            <i class="fas fa-calendar-check mr-2"></i>Paid Date: {{ $bill->updated_at->format('d-m-Y') }}
                                        </div>
                                    </div>
                                    <hr class="my-4 border-gray-200 dark:border-gray-700">
                                    <div class="flex items-center justify-between">
                                        @if ($bill->payment)
                                            <a href="{{ route('download.receipt', $bill->payment->id) }}" class="bg-mygreen-500 hover:bg-mygreen-600 text-white font-bold py-2 px-4 rounded flex items-center space-x-2 shadow-md hover:shadow-lg transition-shadow duration-300 ease-in-out">
                                                <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 13V4M7 14H5a1 1 0 0 0-1 1v4a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-4a1 1 0 0 0-1-1h-2m-1-5-4 5-4-5m9 8h.01" />
                                                </svg>
                                                <span>Download Receipt</span>
                                            </a>
                                        @else
                                            <p class="text-warning">Receipt not available</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('#payment-form').forEach(function(form) {
            form.addEventListener('submit', function(event) {
                event.preventDefault(); // Prevent the default form submission

                let formData = new FormData(form);

                fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.redirect_url) {
                            window.location.href = data.redirect_url; // Redirect to the payment URL
                        } else {
                            // Handle errors
                            alert('Payment initialization failed.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while processing your request.');
                    });
            });
        });
    });
</script>

<!-- Add FontAwesome -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
