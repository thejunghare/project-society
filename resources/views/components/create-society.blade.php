<div wire:ignore.self id="crud-modal" tabindex="-1" aria-hidden="true"
            class="fixed top-0 left-0 right-0 z-50 items-center justify-center hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
            @csrf <!-- Add this line for CSRF token if you are using Laravel -->
            <div class="relative w-full max-w-4xl max-h-full">
                <!-- Modal content -->
                <form wire:submit.prevent="save" method="POST" action="App\Models\User" class="relative bg-white rounded-lg shadow dark:bg-gray-700">

                    <!-- Modal header -->
                    <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            Create New Society
                        </h3>
                        <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-toggle="crud-modal" id="close-button">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                    </div>
                    <!-- Modal body -->
                    {{-- @foreach ($users as $user) --}}
                    <div class="p-4 space-y-6">
                        <div class="grid grid-cols-9 gap-4">

                            {{-- name --}}
                            <div class="col-span-6 sm:col-span-3">
                                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                                <input type="text" name="name" id="name" wire:model="name"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required >
                                    @error('name')
                                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                                    role="alert">
                                    <span class="font-medium">{{ $message }}</span>
                                </div>
                                @enderror
                            </div>

                            {{-- phone --}}
                            <div class="col-span-6 sm:col-span-3">
                                <label for="phone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Phone</label>
                                <input type="number" name="phone" id="phone" wire:model="phone"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required >
                                    @error('phone')
                                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                                    role="alert">
                                    <span class="font-medium">{{ $message }}</span>
                                </div>
                                @enderror
                            </div>

                            {{-- address --}}
                            <div class="col-span-6 sm:col-span-3">
                                <label for="address" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Address</label>
                                <input type="text" name="address" id="address" wire:model="address"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required >
                                    @error('address')
                                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                                    role="alert">
                                    <span class="font-medium">{{ $message }}</span>
                                </div>
                                @enderror
                            </div>

                            {{-- member_count --}}
                            <div class="col-span-6 sm:col-span-3">
                                <label for="member_count" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Member Count</label>
                                <input type="number" name="member_count" id="member_count" wire:model="member_count"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required>
                                    @error('member_count')
                                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                                    role="alert">
                                    <span class="font-medium">{{ $message }}</span>
                                </div>
                                @enderror
                            </div>


                            {{-- bank_name --}}
                            <div class="col-span-6 sm:col-span-3">
                                <label for="bank_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Bank Name</label>
                                <input type="text" name="bank_name" id="bank_name" wire:model="bank_name"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required >
                                    @error('bank_name')
                                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                                    role="alert">
                                    <span class="font-medium">{{ $message }}</span>
                                </div>
                                @enderror
                            </div>

                            {{-- bank_account_number --}}
                            <div class="col-span-6 sm:col-span-3">
                                <label for="bank_account_number" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Bank Account Number</label>
                                <input type="number" name="bank_account_number" id="bank_account_number" wire:model="bank_account_number"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required>
                                    @error('bank_account_number')
                                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                                    role="alert">
                                    <span class="font-medium">{{ $message }}</span>
                                </div>
                                @enderror
                            </div>

                            {{-- bank_ifsc_code --}}
                            <div class="col-span-6 sm:col-span-3">
                                <label for="bank_ifsc_code" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Bank IFSC Code</label>
                                <input type="text" name="bank_ifsc_code" id="bank_ifsc_code" wire:model="bank_ifsc_code"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required >
                                    @error('bank_ifsc_code')
                                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                                    role="alert">
                                    <span class="font-medium">{{ $message }}</span>
                                </div>
                                @enderror
                            </div>

                            {{-- accountant_id --}}
                            <div class="col-span-6 sm:col-span-3">
                                <label for="accountant_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Accountant ID</label>
                                <input type="number" name="accountant_id" id="accountant_id" wire:model="accountant_id"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required >
                                    @error('accountant_id')
                                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                                    role="alert">
                                    <span class="font-medium">{{ $message }}</span>
                                </div>
                                @enderror
                            </div>

                            {{-- renews_at --}}
                            <div class="col-span-6 sm:col-span-3">
                                <label for="renews_at" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Renews At</label>
                                <input type="date" name="renews_at" id="renews_at" wire:model="renews_at"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required>
                                    @error('renews_at')
                                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                                    role="alert">
                                    <span class="font-medium">{{ $message }}</span>
                                </div>
                                @enderror
                            </div>

                                {{-- upi_id --}}
                                <div class="col-span-6 sm:col-span-3">
                                <label for="upi_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">UPI ID</label>
                                <input type="text" name="upi_id" id="upi_id" wire:model="upi_id"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required >
                                    @error('upi_id')
                                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                                    role="alert">
                                    <span class="font-medium">{{ $message }}</span>
                                </div>
                                @enderror
                            </div>

                                {{-- upi_number --}}
                                <div class="col-span-6 sm:col-span-3">
                                <label for="upi_number" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">UPI Number</label>
                                <input type="text" name="upi_number" id="upi_number" wire:model="upi_number"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required >
                                    @error('upi_number')
                                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                                    role="alert">
                                    <span class="font-medium">{{ $message }}</span>
                                </div>
                                @enderror
                            </div>


                                {{-- parking_charges --}}
                                <div class="col-span-6 sm:col-span-3">
                                <label for="parking_charges" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Parking Charges</label>
                                <input type="number" name="parking_charges" id="parking_charges" wire:model="parking_charges"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required >
                                    @error('parking_charges')
                                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                                    role="alert">
                                    <span class="font-medium">{{ $message }}</span>
                                </div>
                                @enderror
                            </div>

                                {{-- service_charges --}}
                                <div class="col-span-6 sm:col-span-3">
                                <label for="service_charges" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Service Charges</label>
                                <input type="number" name="service_charges" id="service_charges" wire:model="service_charges"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required >
                                    @error('service_charges')
                                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                                    role="alert">
                                    <span class="font-medium">{{ $message }}</span>
                                </div>
                                @enderror
                            </div>

                                {{-- maintenance_amount_owner --}}
                                <div class="col-span-6 sm:col-span-3">
                                <label for="maintenance_amount_owner" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Maintenance Amount Owner</label>
                                <input type="number" name="maintenance_amount_owner" id="maintenance_amount_owner" wire:model="maintenance_amount_owner"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required >
                                    @error('maintenance_amount_owner')
                                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                                    role="alert">
                                    <span class="font-medium">{{ $message }}</span>
                                </div>
                                @enderror
                            </div>

                                {{-- maintenance_amount_rented --}}
                                <div class="col-span-6 sm:col-span-3">
                                <label for="maintenance_amount_rented" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Maintenance Amount Rented</label>
                                <input type="number" name="maintenance_amount_rented" id="maintenance_amount_rented" wire:model="maintenance_amount_rented"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required >
                                    @error('maintenance_amount_rented')
                                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                                    role="alert">
                                    <span class="font-medium">{{ $message }}</span>
                                </div>
                                @enderror
                            </div>

                                {{-- registered_balance --}}
                                <div class="col-span-6 sm:col-span-3">
                                <label for="registered_balance" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Registered Balance</label>
                                <input type="number" name="registered_balance" id="registered_balance" wire:model="registered_balance"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required ">
                                    @error('registered_balance')
                                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                                    role="alert">
                                    <span class="font-medium">{{ $message }}</span>
                                </div>
                                @enderror
                            </div>

                                {{-- updated_balance --}}
                                <div class="col-span-6 sm:col-span-3">
                                <label for="updated_balance" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Updated Balance</label>
                                <input type="number" name="updated_balance" id="updated_balance" wire:model="updated_balance"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required >
                                    @error('updated_balance')
                                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                                    role="alert">
                                    <span class="font-medium">{{ $message }}</span>
                                </div>
                                @enderror
                            </div>
                            
                                                        
                            
                        </div>
                    </div>
                    
                    {{-- @endforeach --}}
                    <!-- Modal footer -->
                    <div
                        class="flex items-center p-6 space-x-3 rtl:space-x-reverse border-t border-gray-200 rounded-b dark:border-gray-600">
                        <button type="submit" wire:loading.attr="disabled" wire:loading.class="hidden"
                    class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                            clip-rule="evenodd"></path>
                    </svg>
                    Add new user
                </button>

                <button wire:loading disabled type="button"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 inline-flex items-center">
                    <svg aria-hidden="true" role="status" class="inline w-4 h-4 me-3 text-white animate-spin"
                        viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                            fill="#E5E7EB" />
                        <path
                            d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                            fill="currentColor" />
                    </svg>
                    adding...
                </button>
            
                    </div>
                </form>
            </div>
        </div>