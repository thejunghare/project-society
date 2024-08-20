<div class="mt-16">
    <div class="flex flex-col sm:flex-row items-center justify-between">
        {{-- <div class="text-lg font-bold text-transparent bg-clip-text bg-gradient-to-r from-green-400 to-green-600 mb-4 sm:mb-0 transition-transform duration-300 ease-in-out transform hover:scale-105">
            <span class="text-base">Welcome</span>, <span class="text-xl">{{ Auth::user()->name }}</span>!
        </div> --}}


    </div>

    <div class="p-3 mb-2 mt-2 text-sm text-mygreen-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-mygreen-400"
        role="alert">
        <span class="font-medium">You are a member of </span> <span class="font-bold ">
            {{ $member->society->name }}</span>
    </div>


    <section class="relative  dark:bg-dark p-3">
        <div class="flex xl:flex-row flex-col    gap-x-3">
            <div
                class="relative flex-grow  bg-white w-full xl:w-1/3 dark:bg-dark_50  flex flex-col   shadow-lg rounded-md border border-zinc-300 dark:border-zinc-800 dark:text-white">
                <div class="relative flex flex-col items-center p-4 overflow-y-auto no-scrollbar">
                    <!-- Society Image and Basic Info -->
                    <svg class="w-[35px] h-[35px] text-gray-800 dark:text-white" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                        viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M12 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm-2 9a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-1a4 4 0 0 0-4-4h-4Z"
                            clip-rule="evenodd" />
                    </svg>

                    <div class="flex flex-col justify-between items-center">
                        <span class="font-semibold mt-3 text-gray-800 dark:text-gray-200 text-2xl">
                            {{ Auth::user()->name }}
                        </span>
                        <span class="font-semibold ml-3 mb-auto text-zinc-500 dark:text-gray-400 text-sm">
                            {{ Auth::user()->phone }}
                        </span>
                    </div>

                    <!-- Divider -->
                    <div class="w-full h-px bg-gray-200 dark:bg-[#333333] mt-6"></div>

                    <!-- Address and Members Section -->
                    <div class="flex flex-col gap-y-4 mt-4 items-start xl:mb-0 mb-8">
                        <!-- Address Section -->
                        <div class="flex gap-x-2 flex-row items-center">
                            <div class="dark:bg-dark bg-[#f0f0f0] p-2 rounded-lg">
                                <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 384 512"
                                    class="text-zinc-600" height="20" width="20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M215.7 499.2C267 435 384 279.4 384 192C384 86 298 0 192 0S0 86 0 192c0 87.4 117 243 168.3 307.2c12.3 15.3 35.1 15.3 47.4 0zM192 128a64 64 0 1 1 0 128 64 64 0 1 1 0-128z">
                                    </path>
                                </svg>
                            </div>
                            <div class="flex flex-col items-start">
                                <span class="text-xs font-medium text-zinc-600">Society Address</span>
                                <span class="text-sm font-semibold">{{ $society->address }}</span>
                            </div>
                        </div>

                        <!-- Members Section -->
                        <div class="flex gap-x-2 flex-row items-center">
                            <div class="dark:bg-dark bg-[#f0f0f0] p-2 rounded-lg">
                                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                    viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="m4 12 8-8 8 8M6 10.5V19a1 1 0 0 0 1 1h3v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h3a1 1 0 0 0 1-1v-8.5" />
                                </svg>
                            </div>
                            <div class="flex flex-col items-start">
                                <span class="text-xs font-medium text-zinc-600">फ्लॅट क्रमांक:</span>
                                <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                                    {{ $member->room_number }}
                                </span>
                            </div>
                        </div>

                        <div class="flex gap-x-2 flex-row items-center">
                            <div class="dark:bg-dark bg-[#f0f0f0] p-2 rounded-lg">
                                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                    viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="m4 12 8-8 8 8M6 10.5V19a1 1 0 0 0 1 1h3v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h3a1 1 0 0 0 1-1v-8.5" />
                                </svg>
                            </div>
                            <div class="flex flex-col items-start">
                                <span class="text-xs font-medium text-zinc-600">Ownership Status</span>
                                <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                                    {{ $member->is_rented ? 'भाड्याने' : 'स्वतःचा' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Divider -->
                    <div class="w-full h-[1.5px] bg-gray-200 dark:bg-[#333333] mt-6"></div>

                    <!-- Society Charges Section -->
                    <div class="flex flex-col mt-4 gap-y-4 align-start text-lg">
                        <!-- Parking Charges -->
                        <div class="flex gap-x-2 items-center">
                            <div class="dark:bg-dark bg-[#f0f0f0] p-2 rounded-lg">
                                <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512"
                                    class="text-zinc-600" height="20" width="20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M416 0H96C43 0 0 43 0 96v320c0 53 43 96 96 96h320c53 0 96-43 96-96V96c0-53-43-96-96-96zM368 240c-16.9 0-32.4 7.2-43.5 18.7L256 362.6 187.5 258.7C176.4 247.2 160 240 144 240c-17.7 0-32 14.3-32 32s14.3 32 32 32c8.5 0 16.5-3.4 22.4-8.9l48.6 60.4c7.2 9 21.5 9 28.7 0l48.6-60.4c5.9 5.5 13.9 8.9 22.4 8.9 17.7 0 32-14.3 32-32s-14.3-32-32-32z">
                                    </path>
                                </svg>
                            </div>
                            <div class="flex flex-col items-start">
                                <span class="text-xs font-medium text-zinc-600">Bank Account Number</span>
                                <span class="text-sm font-semibold">{{ $member->society->bank_account_number }}</span>
                            </div>
                        </div>

                        <!-- Service Rented Charges -->
                        <div class="flex gap-x-2 items-center">
                            <div class="dark:bg-dark bg-[#f0f0f0] p-2 rounded-lg">
                                <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512"
                                    class="text-zinc-600" height="20" width="20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M256 0C114.6 0 0 114.6 0 256s114.6 256 256 256 256-114.6 256-256S397.4 0 256 0zM368 328c-16.9 0-32.4 7.2-43.5 18.7L256 434.6 187.5 346.7C176.4 335.2 160 328 144 328c-17.7 0-32 14.3-32 32s14.3 32 32 32c8.5 0 16.5-3.4 22.4-8.9l48.6-60.4c7.2-9 21.5-9 28.7 0l48.6 60.4c5.9 5.5 13.9 8.9 22.4 8.9 17.7 0 32-14.3 32-32s-14.3-32-32-32z">
                                    </path>
                                </svg>
                            </div>
                            <div class="flex flex-col items-start">
                                <span class="text-xs font-medium text-zinc-600">Bank IFSC Code</span>
                                <span class="text-sm font-semibold">{{ $member->society->bank_ifsc_code }}</span>
                            </div>
                        </div>

                        <!-- Owner Charges -->
                        <div class="flex gap-x-2 items-start">
                            <div class="dark:bg-dark bg-[#f0f0f0] p-2 rounded-lg">
                                <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512"
                                    class="text-zinc-600" height="20" width="20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M256 0C114.6 0 0 114.6 0 256s114.6 256 256 256 256-114.6 256-256S397.4 0 256 0zM368 328c-16.9 0-32.4 7.2-43.5 18.7L256 434.6 187.5 346.7C176.4 335.2 160 328 144 328c-17.7 0-32 14.3-32 32s14.3 32 32 32c8.5 0 16.5-3.4 22.4-8.9l48.6-60.4c7.2-9 21.5-9 28.7 0l48.6 60.4c5.9 5.5 13.9 8.9 22.4 8.9 17.7 0 32-14.3 32-32s-14.3-32-32-32z">
                                    </path>
                                </svg>
                            </div>
                            <div class="flex flex-col items-start">
                                <span class="text-xs font-medium text-zinc-600">UPI ID</span>
                                <span class="text-sm font-semibold">{{ $member->society->upi_id }}</span>
                            </div>
                        </div>

                        <div class="flex gap-x-2 items-start">
                            <div class="dark:bg-dark bg-[#f0f0f0] p-2 rounded-lg">
                                <svg stroke="currentColor" fill="currentColor" stroke-width="0"
                                    viewBox="0 0 512 512" class="text-zinc-600" height="20" width="20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M256 0C114.6 0 0 114.6 0 256s114.6 256 256 256 256-114.6 256-256S397.4 0 256 0zM368 328c-16.9 0-32.4 7.2-43.5 18.7L256 434.6 187.5 346.7C176.4 335.2 160 328 144 328c-17.7 0-32 14.3-32 32s14.3 32 32 32c8.5 0 16.5-3.4 22.4-8.9l48.6-60.4c7.2-9 21.5-9 28.7 0l48.6 60.4c5.9 5.5 13.9 8.9 22.4 8.9 17.7 0 32-14.3 32-32s-14.3-32-32-32z">
                                    </path>
                                </svg>
                            </div>
                            <div class="flex flex-col items-start">
                                <span class="text-xs font-medium text-zinc-600">UPI Number</span>
                                <span class="text-sm font-semibold">{{ $member->society->upi_number }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Bottom Padding -->
                    <div class="flex flex-col mt-4 items-end px-4">
                        <div class="flex flex-wrap mt-2 gap-3"></div>
                    </div>
                </div>


            </div>
            <div class="w-full h-full flex-grow flex flex-col gap-y-3">


                <div class="flex xl:h-2/5 xl:mt-0 mt-4 flex-col xl:flex-row gap-x-3">
                    <!-- Financial Summary Box -->
                    <div
                        class="bg-white dark:bg-dark_50 shadow-lg rounded-md border border-zinc-300 dark:border-zinc-800 flex-1">
                        <div class="flex flex-col ">
                            <header class="px-5 py-4 border-b border-gray-200 dark:border-zinc-700">
                                <h2 class="font-bold text-gray-800 dark:text-gray-200 text-lg">Financial Summary</h2>
                            </header>
                            <div class="flex items-center space-x-4 m-3">
                                <div>
                                    <select id="year-select" wire:model="selectedYear"
                                        wire:change="calculateTotalPayable"
                                        class="h-10 w-24 rounded-lg border-gray-300 shadow-md focus:border-mygreen-500 focus:ring-mygreen-500 bg-gray-50 text-gray-700 hover:bg-white transition duration-150 ease-in-out text-xs">
                                        @foreach (range(date('Y') - 5, date('Y')) as $year)
                                            <option value="{{ $year }}"
                                                {{ $year == $selectedYear ? 'selected' : '' }}>
                                                {{ $year }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <select id="month-select" wire:model="selectedMonth"
                                        wire:change="calculateTotalPayable"
                                        class="h-10 w-28 rounded-lg border-gray-300 shadow-md focus:border-mygreen-500 focus:ring-mygreen-500 bg-gray-50 text-gray-700 hover:bg-white transition duration-150 ease-in-out text-xs">
                                        @foreach (range(1, 12) as $month)
                                            <option value="{{ $month }}"
                                                {{ $month == $selectedMonth ? 'selected' : '' }}>
                                                {{ date('F', mktime(0, 0, 0, $month, 1)) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="flex items-end">
                                    <button wire:click="resetSelection"
                                        class="px-3 py-2 text-white rounded-md bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:from-green-500 hover:via-green-600 hover:to-green-700 transition ease-in-out duration-300 transform hover:scale-105 shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 text-xs">
                                        Reset to Current
                                    </button>
                                </div>
                            </div>
                            <div class="px-6 xl:py-0 py-2 overflow-hidden overflow-x-auto no-scrollbar">
                                <div class="flex justify-start sm:justify-center items-center mt-4 gap-x-10">

                                    <!-- Total Receivable Section -->
                                    <div class="flex flex-col justify-center items-center">
                                        <svg width="150" height="150" viewBox="0 0 150 150">
                                            <circle cx="75" cy="75" stroke-width="10px" r="60"
                                                class="fill-none stroke-[#f6f5f5] dark:stroke-zinc-800"></circle>
                                            <circle cx="75" cy="75" stroke-width="10px" r="60"
                                                class="fill-none stroke-green-500" stroke-linecap="round"
                                                stroke-linejoin="round" transform="rotate(-90 75 75)"
                                                style="stroke-dasharray: 376.991; stroke-dashoffset: 0;">
                                            </circle>
                                            <text x="50%" y="50%" dy="0.3em" text-anchor="middle"
                                                class="text-xl fill-green-500 font-semibold">
                                                ₹{{ number_format($receivableAmount, 2) }}
                                            </text>
                                        </svg>
                                        <div class="btn-xs mt-6 mb-6 flex gap-2 items-center ">
                                            <span>एकूण प्राप्ती</span>
                                        </div>
                                    </div>

                                    <!-- Total Payable Section -->
                                    <div class="flex flex-col justify-center items-center">
                                        <svg width="150" height="150" viewBox="0 0 150 150">
                                            <circle cx="75" cy="75" stroke-width="10px" r="60"
                                                class="fill-none stroke-[#f6f5f5] dark:stroke-zinc-800"></circle>
                                            <circle cx="75" cy="75" stroke-width="10px" r="60"
                                                class="fill-none stroke-red-500" stroke-linecap="round"
                                                stroke-linejoin="round" transform="rotate(-90 75 75)"
                                                style="stroke-dasharray: 376.991; stroke-dashoffset: {{ 376.991 - (376.991 * $totalPayable) / $receivableAmount }};">
                                            </circle>
                                            <text x="50%" y="50%" dy="0.3em" text-anchor="middle"
                                                class="text-xl fill-red-500 font-semibold">
                                                ₹{{ number_format($totalPayable, 2) }}
                                            </text>
                                        </svg>
                                        <div class="btn-xs mt-6 mb-6 flex gap-2 items-center ">
                                            <span>एकूण प्राप्त</span>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 xl:mt-0 w-full">
                        <div
                            class="flex flex-col h-full bg-white dark:bg-dark_50 shadow-lg rounded-md border border-zinc-300 dark:border-zinc-800">
                            <header
                                class="px-5 py-4 border-b border-zinc-200 dark:border-zinc-700 flex justify-between items-center">
                                <div>
                                    <h2 class="font-bold text-gray-800 dark:text-gray-200 text-lg">शुल्क</h2>
                                </div>

                            </header>

                            <!-- Section for Charges and Totals -->
                            <div class="px-6 py-4 ">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-6">
                                    <div class="bg-gray-100 dark:bg-zinc-800 p-4 rounded-md shadow">
                                        <h3 class="text-gray-700 dark:text-gray-300 font-semibold">पार्किंग शुल्क</h3>
                                        <p class="text-xl font-bold text-gray-800 dark:text-white">
                                            {{ number_format($member->society->parking_charges, 2) }}</p>
                                    </div>
                                    <div class="bg-gray-100 dark:bg-zinc-800 p-4 rounded-md shadow">
                                        <h3 class="text-gray-700 dark:text-gray-300 font-semibold"> सेवा शुल्क</h3>
                                        <p class="text-xl font-bold text-gray-800 dark:text-white">
                                            {{ number_format($member->society->service_charges, 2) }}</p>
                                    </div>
                                    <div class="bg-gray-100 dark:bg-zinc-800 p-4 rounded-md shadow">
                                        <h3 class="text-gray-700 dark:text-gray-300 font-semibold">मेन्टेनन्स शुल्क
                                        </h3>
                                        <p class="text-xl font-bold text-gray-800 dark:text-white">
                                            {{ number_format($maintenance, 2) }}</p>
                                    </div>
                                    <div class="bg-gray-100 dark:bg-zinc-800 p-4 rounded-md shadow">
                                        <h3 class="text-gray-700 dark:text-gray-300 font-semibold">संपूर्ण</h3>
                                        <p class="text-xl font-bold text-gray-800 dark:text-white">
                                            {{ number_format($member->society->parking_charges + $member->society->service_charges + $maintenance, 2) }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>



                <div class="h-full">
                    <div class="flex flex-col gap-4">

                        <div class="flex flex-wrap gap-4">

                            <!-- Society Details Box -->
                            <div
                                class="bg-white dark:border-zinc-800 dark:bg-dark_50 shadow-lg rounded-md border border-zinc-300 flex-1">
                                <div class="px-5 py-4 border-b border-zinc-200 dark:border-zinc-700">
                                    <h2 class="font-semibold text-gray-800 dark:text-gray-200 text-lg">Society Details
                                    </h2>
                                </div>
                                <div
                                    class="px-5 py-4 grid grid-cols-1 sm:grid-cols-2 gap-4 text-gray-700 dark:text-gray-300">
                                    <div class="space-y-2">
                                        <p><strong class="font-medium text-gray-800 dark:text-gray-200">Society
                                                Name:</strong> {{ $member->society->name }}</p>
                                        <p><strong class="font-medium text-gray-800 dark:text-gray-200">President
                                                Name:</strong> {{ $member->society->president_name }}</p>
                                        <p><strong class="font-medium text-gray-800 dark:text-gray-200">Vice President
                                                Name:</strong> {{ $member->society->vice_president_name }}</p>
                                        <p><strong class="font-medium text-gray-800 dark:text-gray-200">Treasurer
                                                Name:</strong> {{ $member->society->treasurer_name }}</p>
                                        <p><strong class="font-medium text-gray-800 dark:text-gray-200">Secretary
                                                Name:</strong> {{ $member->society->secretary_name }}</p>
                                        <p><strong class="font-medium text-gray-800 dark:text-gray-200">Phone
                                                Number:</strong> {{ $member->society->phone }}</p>
                                    </div>
                                    <div class="space-y-2">
                                        <p><strong class="font-medium text-gray-800 dark:text-gray-200">Bank
                                                Name:</strong> {{ $member->society->bank_name }}</p>
                                        <p><strong class="font-medium text-gray-800 dark:text-gray-200">Account
                                                Number:</strong> {{ $member->society->bank_account_number }}</p>
                                        <p><strong class="font-medium text-gray-800 dark:text-gray-200">IFSC
                                                Code:</strong> {{ $member->society->bank_ifsc_code }}</p>
                                        <p><strong class="font-medium text-gray-800 dark:text-gray-200">UPI
                                                ID:</strong> {{ $member->society->upi_id }}</p>
                                        <p><strong class="font-medium text-gray-800 dark:text-gray-200">UPI
                                                Number:</strong> {{ $member->society->upi_number }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Bank & Summary Box -->
                            {{-- <div class="bg-white dark:border-zinc-800 dark:bg-dark_50 shadow-lg rounded-md border border-zinc-300 flex-1">
                    <div class="px-5 py-4 border-b border-zinc-200 dark:border-zinc-700">
                      <h2 class="font-semibold text-gray-800 dark:text-gray-200 text-lg">Bank & Summary</h2>
                    </div>
                    <div class="px-5 py-4">
                      <p class="mb-4">
                        <strong class="font-medium text-gray-800 dark:text-gray-200">Total Balance as of {{ now()->format('d F Y') }}:</strong>
                        <span class="text-green-500 text-lg font-semibold">₹{{ number_format($this->society->registered_balance + $this->society->updated_balance, 2) }}/-</span>
                      </p>
                      <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                          <thead class="bg-gray-50 dark:bg-gray-800">
                            <tr>
                              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Payment Method
                              </th>
                              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Amount
                              </th>
                            </tr>
                          </thead>
                          <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-900 dark:divide-gray-700">
                            <tr>
                              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                Cash
                              </td>
                              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                ₹{{ $payCash }}
                              </td>
                            </tr>
                            <tr>
                              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                Phone-pay
                              </td>
                              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                ₹{{ $payOnline }}
                              </td>
                            </tr>
                            <tr>
                              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                Cheque
                              </td>
                              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                ₹{{ $payCheque }}
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div> --}}

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>


</div>
