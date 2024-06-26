<div class="mt-12">
    <div class="flex items-center mb-4">
        {{-- Action Button --}}
        <div class="">
            <button id="dropdownActionButton" data-dropdown-toggle="dropdownAction"
                wire:click="seeMembers({{ $society->id }})"
                class="inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-3 py-1.5 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"
                type="button">
                <span class="sr-only">See Society Members</span>
                See Society Members
            </button>
        </div>

        <div class=" p-3 pl-10">
            <button id="dropdownActionButton" data-dropdown-toggle="dropdownAction" wire:click="seeMaintenanceBills({{ $society->id }})"
                class="inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-3 py-1.5 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"
                type="button">
                <span class="sr-only">Maintenance Bill</span>
                Maintenance Bill
            </button>
        </div>
    </div>

    <div class="mt-2">
        <h1
            class="mb-4 text-4xl font-extrabold leading-none tracking-tight text-gray-900 md:text-5xl lg:text-3xl dark:text-white">
            Society Details</h1>
        <hr class="h-px my-8 bg-gray-200 border-0 dark:bg-gray-700 mt-0">
    </div>
    <div>

        <form wire:submit.prevent="updateSociety">
            <div>
                <div class="grid gap-6 mb-6 md:grid-cols-2">
                    <div>
                        <label for="name"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Society Name</label>
                        <input type="text" id="name" value="{{ $society->name }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            readonly />
                    </div>
                    <div>
                        <label for="phone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Phone
                            Number</label>
                        <input type="text" id="phone" value="{{ $society->phone }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            readonly />
                    </div>
                    <div>
                        <label for="address"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Address</label>
                        <textarea id="address" rows="2"
                            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            readonly>{{ $society->address }}</textarea>
                    </div>
                    <div>
                        <label for="bank_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Bank
                            Name</label>
                        <input type="text" id="bank_name" value="{{ $society->bank_name }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            readonly />
                    </div>
                    <div>
                        <label for="bank_ifsc" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Bank
                            IFSC Code</label>
                        <input type="text" id="bank_ifsc" value="{{ $society->bank_ifsc_code }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            readonly />
                    </div>
                    <div>
                        <label for="bank_account_number"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Bank Account
                            Number</label>
                        <input type="text" id="bank_account_number" value="{{ $society->bank_account_number }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            readonly />
                    </div>
                    <div>
                        <label for="member_count"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Member Count</label>
                        <input type="text" id="member_count" value="{{ $society->member_count }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            readonly />
                    </div>
                    <div>
                        <label for="president_name"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">President Name</label>
                        <input type="text" id="president_name" value="{{ $society->president_name }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            readonly />
                    </div>
                    <div>
                        <label for="vice_president_name"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Vice President
                            Name</label>
                        <input type="text" id="vice_president_name" value="{{ $society->vice_president_name }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            readonly />
                    </div>
                    <div>
                        <label for="treasurer_name"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Treasurer Name</label>
                        <input type="text" id="treasurer_name" value="{{ $society->treasurer_name }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            readonly />
                    </div>
                    <div>
                        <label for="secretary_name"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Secretary Name</label>
                        <input type="text" id="secretary_name" value="{{ $society->secretary_name }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            readonly />
                    </div>
                </div>
            </div>



        </form>

        <div class="mt-3 flex">
            <a wire:click="goBack"
                class="flex items-center justify-center px-3 h-8 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                <svg class="w-3.5 h-3.5 me-2 rtl:rotate-180" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 5H1m0 0 4 4M1 5l4-4" />
                </svg>
                Previous
            </a>
        </div>

    </div>
</div>
