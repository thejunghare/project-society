<div class="mt-16">
    @section('title', 'Society Dashboard')
    <div class="mb-4 border-mygreen-200 dark:border-mygreen-700">
        <ul class="flex flex-wrap text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400">
            <li class="me-2">
                <button class="inline-block p-4 rounded-t-lg hover:text-mygreen-600 hover:bg-mygreen-50 dark:hover:bg-mygreen-800 dark:hover:text-mygreen-300" wire:click="goBack()">Society</button>
            </li>
            <li class="me-2">
                <button aria-current="page" class="inline-block p-4 text-mygreen-600 bg-mygreen-100 rounded-t-lg active dark:bg-mygreen-800 dark:text-mygreen-500">Society Dashboard</button>
            </li>
            <li class="me-2">
                <button class="inline-block p-4 rounded-t-lg hover:text-mygreen-600 hover:bg-mygreen-50 dark:hover:bg-mygreen-800 dark:hover:text-mygreen-300" wire:click="seeMembers({{ $society->id }})">See Members</button>
            </li>
            <li class="me-2">
                <button aria-current="page" class="inline-block p-4 rounded-t-lg hover:text-mygreen-600 hover:bg-mygreen-50 dark:hover:bg-mygreen-800 dark:hover:text-mygreen-300" wire:click="seeMaintenanceBills({{ $society->id }})">Maintenance Bill</button>
            </li>
        </ul>
    </div>

    {{-- <div class="grid grid-cols-1 lg:grid-cols-4 gap-4 mb-4 max-h-max">
        <!-- First div with 25% width on large screens, full width on smaller screens -->
        <div class="lg:col-span-1 flex flex-col items-center justify-center bg-gray-100 dark:bg-gray-700 border shadow-md h-auto">
            <div class="w-32 m-4 mb-2">
                <img src="{{ asset('images/society-icon.jpg') }}" alt="" class="rounded-full w-full h-auto">
            </div>
            <span class="font-bold mt-3 text-gray-800 dark:text-gray-200 text-2xl">{{ $society->name }}</span>
            <span class="font-semibold ml-3 mb-auto text-zinc-500 dark:text-gray-400  text-sm">{{$society->phone}}</span>            
        </div>
        
    
        <!-- Second and third divs occupying 75% combined on large screens, full width on smaller screens -->
        <div class="lg:col-span-3 lg:grid lg:grid-cols-2">
            <div class="flex justify-center items-center bg-gray-100 dark:bg-gray-700 border shadow-md h-auto mb-4 lg:mb-0">
                <span>part 1</span>
            </div>
            <div class="flex justify-center items-center bg-gray-100 dark:bg-gray-700 border shadow-md h-auto">
                <span>part 2</span>
            </div>
        </div>
    
        <!-- New div below second and third divs, full width on smaller screens -->
        <div class="lg:col-span-3 lg:col-start-2 flex justify-center items-center bg-gray-100 dark:bg-gray-700 border shadow-md h-auto mt-4">
            <span>Combined Part</span>
        </div>
    </div> --}}
    
    
    <section class="relative  dark:bg-dark p-3">
        <div class="flex xl:flex-row flex-col    gap-x-3">
          <div class="relative flex-grow  bg-white w-full xl:w-1/3 dark:bg-dark_50  flex flex-col   shadow-lg rounded-md border border-zinc-300 dark:border-zinc-800 dark:text-white">
            <div class="relative flex flex-col items-center p-4 overflow-y-auto no-scrollbar">
              <!-- Society Image and Basic Info -->
              <img src="{{ asset('images/society-icon.jpg') }}" alt=""
                   class="w-28 h-28 rounded-full object-cover">
              <div class="flex flex-col justify-between items-center">
                <span class="font-bold mt-3 text-gray-800 dark:text-gray-200 text-2xl">
                  {{ $society->name }}
                </span>
                <span class="font-semibold ml-3 mb-auto text-zinc-500 dark:text-gray-400 text-sm">
                  {{ $society->phone }}
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
                         class="text-zinc-600" height="20" width="20" xmlns="http://www.w3.org/2000/svg">
                      <path d="M215.7 499.2C267 435 384 279.4 384 192C384 86 298 0 192 0S0 86 0 192c0 87.4 117 243 168.3 307.2c12.3 15.3 35.1 15.3 47.4 0zM192 128a64 64 0 1 1 0 128 64 64 0 1 1 0-128z"></path>
                    </svg>
                  </div>
                  <div class="flex flex-col items-start">
                    <span class="text-xs font-medium text-zinc-600">Address</span>
                    <span class="text-sm font-semibold">{{ $society->address }}</span>
                  </div>
                </div>
            
                <!-- Members Section -->
                <div class="flex gap-x-2 flex-row items-center">
                  <div class="dark:bg-dark bg-[#f0f0f0] p-2 rounded-lg">
                    <img width="20" height="20" src="https://img.icons8.com/ios/50/guest-male.png" alt="guest-male"/>
                  </div>
                  <div class="flex flex-col items-start">
                    <span class="text-xs font-medium text-zinc-600">Members</span>
                    <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                      {{ $registeredMembers }} / {{ $society->member_count }}
                    </span>
                  </div>
                </div>
              </div>
              
              <!-- Divider -->
              <div class="w-full h-[1.5px] bg-gray-200 dark:bg-[#333333] mt-6"></div>
              
              <!-- Society Charges Section -->
              <div class="flex flex-col mt-4 mr-8 gap-y-4">
                <!-- Parking Charges -->
                <div class="flex gap-x-2 items-center">
                  <div class="dark:bg-dark bg-[#f0f0f0] p-2 rounded-lg">
                    <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512"
                         class="text-zinc-600" height="20" width="20" xmlns="http://www.w3.org/2000/svg">
                      <path d="M416 0H96C43 0 0 43 0 96v320c0 53 43 96 96 96h320c53 0 96-43 96-96V96c0-53-43-96-96-96zM368 240c-16.9 0-32.4 7.2-43.5 18.7L256 362.6 187.5 258.7C176.4 247.2 160 240 144 240c-17.7 0-32 14.3-32 32s14.3 32 32 32c8.5 0 16.5-3.4 22.4-8.9l48.6 60.4c7.2 9 21.5 9 28.7 0l48.6-60.4c5.9 5.5 13.9 8.9 22.4 8.9 17.7 0 32-14.3 32-32s-14.3-32-32-32z"></path>
                    </svg>
                  </div>
                  <div class="flex flex-col items-start">
                    <span class="text-xs font-medium text-zinc-600">Parking Charges</span>
                    <span class="text-sm font-semibold">{{ $society->parking_charges }}</span>
                  </div>
                </div>
                
                <!-- Service Rented Charges -->
                <div class="flex gap-x-2 items-center">
                  <div class="dark:bg-dark bg-[#f0f0f0] p-2 rounded-lg">
                    <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512"
                         class="text-zinc-600" height="20" width="20" xmlns="http://www.w3.org/2000/svg">
                      <path d="M256 0C114.6 0 0 114.6 0 256s114.6 256 256 256 256-114.6 256-256S397.4 0 256 0zM368 328c-16.9 0-32.4 7.2-43.5 18.7L256 434.6 187.5 346.7C176.4 335.2 160 328 144 328c-17.7 0-32 14.3-32 32s14.3 32 32 32c8.5 0 16.5-3.4 22.4-8.9l48.6-60.4c7.2-9 21.5-9 28.7 0l48.6 60.4c5.9 5.5 13.9 8.9 22.4 8.9 17.7 0 32-14.3 32-32s-14.3-32-32-32z"></path>
                    </svg>
                  </div>
                  <div class="flex flex-col items-start">
                    <span class="text-xs font-medium text-zinc-600">Service Charges</span>
                    <span class="text-sm font-semibold">{{ $society->service_charges }}</span>
                  </div>
                </div>
            
                <!-- Owner Charges -->
                <div class="flex gap-x-2 items-start">
                  <div class="dark:bg-dark bg-[#f0f0f0] p-2 rounded-lg">
                    <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512"
                         class="text-zinc-600" height="20" width="20" xmlns="http://www.w3.org/2000/svg">
                      <path d="M256 0C114.6 0 0 114.6 0 256s114.6 256 256 256 256-114.6 256-256S397.4 0 256 0zM368 328c-16.9 0-32.4 7.2-43.5 18.7L256 434.6 187.5 346.7C176.4 335.2 160 328 144 328c-17.7 0-32 14.3-32 32s14.3 32 32 32c8.5 0 16.5-3.4 22.4-8.9l48.6-60.4c7.2-9 21.5-9 28.7 0l48.6 60.4c5.9 5.5 13.9 8.9 22.4 8.9 17.7 0 32-14.3 32-32s-14.3-32-32-32z"></path>
                    </svg>
                  </div>
                  <div class="flex flex-col items-start">
                    <span class="text-xs font-medium text-zinc-600">Owner Charges</span>
                    <span class="text-sm font-semibold">{{ $society->maintenance_amount_owner }}</span>
                  </div>
                </div>

                <div class="flex gap-x-2 items-start">
                  <div class="dark:bg-dark bg-[#f0f0f0] p-2 rounded-lg">
                    <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512"
                         class="text-zinc-600" height="20" width="20" xmlns="http://www.w3.org/2000/svg">
                      <path d="M256 0C114.6 0 0 114.6 0 256s114.6 256 256 256 256-114.6 256-256S397.4 0 256 0zM368 328c-16.9 0-32.4 7.2-43.5 18.7L256 434.6 187.5 346.7C176.4 335.2 160 328 144 328c-17.7 0-32 14.3-32 32s14.3 32 32 32c8.5 0 16.5-3.4 22.4-8.9l48.6-60.4c7.2-9 21.5-9 28.7 0l48.6 60.4c5.9 5.5 13.9 8.9 22.4 8.9 17.7 0 32-14.3 32-32s-14.3-32-32-32z"></path>
                    </svg>
                  </div>
                  <div class="flex flex-col items-start">
                    <span class="text-xs font-medium text-zinc-600">Rented Charges</span>
                    <span class="text-sm font-semibold">{{ $society->maintenance_amount_rented }}</span>
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
              <div class="bg-white dark:bg-dark_50 shadow-lg rounded-md border border-zinc-300 dark:border-zinc-800 flex-1">
                <div class="flex flex-col">
                  <header class="px-5 py-4 border-b border-gray-200 dark:border-zinc-700">
                    <h2 class="font-bold text-gray-800 dark:text-gray-200 text-lg">Financial Summary</h2>
                  </header>
                  <div class="px-6 xl:py-0 py-2 overflow-hidden overflow-x-auto no-scrollbar">
                    <div class="flex justify-start sm:justify-center items-center mt-4 gap-x-10">
                      
                      <!-- Total Receivable Section -->
                      <div class="flex flex-col justify-center items-center">
                        <svg width="150" height="150" viewBox="0 0 150 150">
                          <circle cx="75" cy="75" stroke-width="10px" r="60" class="fill-none stroke-[#f6f5f5] dark:stroke-zinc-800"></circle>
                          <circle cx="75" cy="75" stroke-width="10px" r="60" class="fill-none stroke-green-500"
                            stroke-linecap="round" stroke-linejoin="round" transform="rotate(-90 75 75)"
                            style="stroke-dasharray: 376.991; stroke-dashoffset: 0;">
                          </circle>
                          <text x="50%" y="50%" dy="0.3em" text-anchor="middle" class="text-xl fill-green-500 font-semibold">
                            ₹{{ number_format($receivableAmount, 2) }}
                          </text>
                        </svg>
                        <div class="btn-xs mt-6 mb-6 flex gap-2 items-center bg-white dark:bg-zinc-800 text-zinc-500 dark:text-zinc-400 border border-zinc-200 dark:border-zinc-700 shadow-md">
                          <span>Total Receivable</span>
                        </div>
                      </div>
            
                      <!-- Total Payable Section -->
                      <div class="flex flex-col justify-center items-center">
                        <svg width="150" height="150" viewBox="0 0 150 150">
                          <circle cx="75" cy="75" stroke-width="10px" r="60" class="fill-none stroke-[#f6f5f5] dark:stroke-zinc-800"></circle>
                          <circle cx="75" cy="75" stroke-width="10px" r="60" class="fill-none stroke-red-500"
                            stroke-linecap="round" stroke-linejoin="round" transform="rotate(-90 75 75)"
                            style="stroke-dasharray: 376.991; stroke-dashoffset: {{ 376.991 - (376.991 * $totalPayable / $receivableAmount) }};">
                          </circle>
                          <text x="50%" y="50%" dy="0.3em" text-anchor="middle" class="text-xl fill-red-500 font-semibold">
                            ₹{{ number_format($totalPayable, 2) }}
                          </text>
                        </svg>
                        <div class="btn-xs mt-6 mb-6 flex gap-2 items-center bg-white dark:bg-zinc-800 text-zinc-500 dark:text-zinc-400 border border-zinc-200 dark:border-zinc-700 shadow-md">
                          <span>Total Payable</span>
                        </div>
                      </div>
            
                    </div>
                  </div>
                </div>
              </div>
            
              <!-- Leetcode Data Box -->
              <div class="xl:mt-0 w-full mt-4">
                <div class="flex flex-col h-full bg-white dark:border-zinc-800 dark:bg-dark_50 shadow-lg rounded-md border border-zinc-300">
                  <header class="px-5 border-b border-zinc-200 dark:border-zinc-700 flex justify-between items-center py-4">
                    <div class="flex gap-x- items-center">
                      @php
                      $currentMonth = now()->month;
                      $currentYear = now()->year;
                      $financialYearStart = $currentMonth >= 4 ? $currentYear : $currentYear - 1;
                      $financialYearEnd = $financialYearStart + 1;
                  @endphp
                      <h2 class="font-bold text-gray-800 dark:text-gray-200 text-lg">Financial Year: {{ $financialYearStart }}-{{ $financialYearEnd }}</h2>
                    </div>
                  </header>
            
                  <!-- New Section for Advance, Current Bill, Bill Due, Never Paid -->
                  <div class="px-6 py-4">
                    <div class="grid grid-cols-2 gap-4">
                      <div class="bg-gray-100 dark:bg-zinc-800 p-4 rounded-md shadow">
                        <h3 class="text-gray-700 dark:text-gray-300 font-semibold">Advance</h3>
                        <p class="text-xl font-bold text-gray-800 dark:text-white">{{ $advance }}</p>
                      </div>
                      <div class="bg-gray-100 dark:bg-zinc-800 p-4 rounded-md shadow">
                        <h3 class="text-gray-700 dark:text-gray-300 font-semibold">Current Bill</h3>
                        <p class="text-xl font-bold text-gray-800 dark:text-white">{{ $currentBill }}</p>
                      </div>
                      <div class="bg-gray-100 dark:bg-zinc-800 p-4 rounded-md shadow">
                        <h3 class="text-gray-700 dark:text-gray-300 font-semibold">Bill Due</h3>
                        <p class="text-xl font-bold text-gray-800 dark:text-white">{{ $billDues }}</p>
                      </div>
                      <div class="bg-gray-100 dark:bg-zinc-800 p-4 rounded-md shadow">
                        <h3 class="text-gray-700 dark:text-gray-300 font-semibold">Never Paid</h3>
                        <p class="text-xl font-bold text-gray-800 dark:text-white">{{ $neverPaid }}</p>
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
                  <div class="bg-white dark:border-zinc-800 dark:bg-dark_50 shadow-lg rounded-md border border-zinc-300 flex-1">
                    <div class="px-5 py-4 border-b border-zinc-200 dark:border-zinc-700">
                      <h2 class="font-semibold text-gray-800 dark:text-gray-200 text-lg">Society Details</h2>
                    </div>
                    <div class="px-5 py-4 grid grid-cols-1 sm:grid-cols-2 gap-4 text-gray-700 dark:text-gray-300">
                      <div class="space-y-2">
                        <p><strong class="font-medium text-gray-800 dark:text-gray-200">Society Name:</strong> {{ $society->name }}</p>
                        <p><strong class="font-medium text-gray-800 dark:text-gray-200">President Name:</strong> {{ $society->president_name }}</p>
                        <p><strong class="font-medium text-gray-800 dark:text-gray-200">Vice President Name:</strong> {{ $society->vice_president_name }}</p>
                        <p><strong class="font-medium text-gray-800 dark:text-gray-200">Treasurer Name:</strong> {{ $society->treasurer_name }}</p>
                        <p><strong class="font-medium text-gray-800 dark:text-gray-200">Secretary Name:</strong> {{ $society->secretary_name }}</p>
                      </div>
                      <div class="space-y-2">
                        <p><strong class="font-medium text-gray-800 dark:text-gray-200">Bank Name:</strong> {{ $society->bank_name }}</p>
                        <p><strong class="font-medium text-gray-800 dark:text-gray-200">Account Number:</strong> {{ $society->bank_account_number }}</p>
                        <p><strong class="font-medium text-gray-800 dark:text-gray-200">IFSC Code:</strong> {{ $society->bank_ifsc_code }}</p>
                        <p><strong class="font-medium text-gray-800 dark:text-gray-200">UPI ID:</strong> {{ $society->upi_id }}</p>
                      </div>
                    </div>
                  </div>
            
                  <!-- Bank & Summary Box -->
                  <div class="bg-white dark:border-zinc-800 dark:bg-dark_50 shadow-lg rounded-md border border-zinc-300 flex-1">
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
                  </div>
            
                </div>
              </div>
            </div>
            
          </div>
        </div>
      </section>
</div>