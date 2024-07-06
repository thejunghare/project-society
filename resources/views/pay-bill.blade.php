<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pay Bills') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4"
                            role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <div class="bg-gray-100 rounded-lg p-6 mb-6">
                        <div class="flex justify-between items-center mb-4">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-700">Total Due</h3>
                                <p class="text-4xl font-bold text-green-500">₹{{ number_format($totalDue, 2) }}</p>
                            </div>
                        </div>
                    </div>

                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Your Bills</h3>

                    @if ($bills->isEmpty())
                        <p class="text-gray-500">No unpaid bills at the moment.</p>
                    @else
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                            @foreach ($bills as $bill)
                                <div class="max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                                    <div class="flex justify-between items-center mb-2">
                                        <h5 class="text-xl font-bold text-gray-900 dark:text-white">Total Due</h5>
                                        @if ($bill->is_overdue)
                                            <span class="text-red-500 font-semibold">Overdue</span>
                                        @endif
                                    </div>
                                    <div class="mb-4">
                                        <div class="text-lg font-bold text-gray-900 dark:text-white">
                                            ₹{{ number_format($bill->amount, 2) }}</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">Due Date:
                                            {{ $bill->due_date->format('d-m-Y') }}</div>
                                    </div>
                                    <hr class="my-4 border-gray-200 dark:border-gray-700">
                                    <div class="flex items-center justify-between">
                                        <a href="#" class="text-blue-700 hover:underline">Transaction
                                            History</a>
                                        <form action="{{ route('process.payment') }}" method="POST" class="inline">
                                            @csrf
                                            <input type="hidden" name="bill_id" value="{{ $bill->id }}">
                                            <button type="submit"
                                                class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                                                Pay Now
                                            </button>
                                        </form>
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
