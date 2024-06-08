<div class="mt-12">
    {{-- Do your work, then step back. --}}
{{--Abckj--}}
    <x-success-toaster />

    @if ($societies->isEmpty())
        <x-alert-no-registered-societies />
    @else
        <div class="flex justify-between items-center">
            <div class="relative mb-4" style="margin-left: 350px">
                <label for="table-search" class="sr-only">Search</label>
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                </div>
                <input type="text" id="table-search"
                    class="block w-80 px-10 py-2 text-sm border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Search for societies">
            </div>

            {{-- Action Button --}}
            <div class="flex justify-end">
                <button id="dropdownActionButton" data-dropdown-toggle="dropdownAction"
                    class="inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-3 py-1.5 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"
                    type="button">
                    <span class="sr-only">Action button</span>
                    Action
                    <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 4 4 4-4" />
                    </svg>
                </button>
                <!-- Dropdown menu -->
                <div id="dropdownAction"
                    class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600 ">
                    <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownActionButton">
                        {{-- Add society manually --}}
                        <li>
                            <button type="button" data-modal-target="add-society-manually-modal"
                                data-modal-toggle="add-society-manually-modal"
                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Add
                                society manually</button>
                        </li>
                        {{-- Add society auto --}}
                        <li>
                            <button type="button" data-modal-target="add-scoiety-auto-modal"
                                data-modal-toggle="add-scoiety-auto-modal"
                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Add
                                society auto</button>
                        </li>

                    </ul>

                </div>

                {{-- add society modal manually --}}
                {{-- <x-add-society-manually-modal-body /> --}}

                {{-- csv, excel upload auto --}}
                <x-add-society-auto-modal-body />
            </div>
        </div>


        <!-- Edit user modal -->
        <div id="editUserModal" tabindex="-1" aria-hidden="true"
            class="fixed top-0 left-0 right-0 z-50 flex items-center justify-center hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full"
            wire:ignore.self>
            <div class="relative w-full max-w-2xl max-h-full">


                <!-- Modal content -->
                <form id="editSocietyForm" class="relative bg-white rounded-lg shadow dark:bg-gray-700"
                    wire:submit.prevent="upData" method="POST" action="/accountant/manage/societies">
                    @csrf <!-- Add this line for CSRF token if you are using Laravel -->

                    <!-- Modal header -->
                    <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            Edit Society
                        </h3>

                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-hide="editUserModal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="p-6 space-y-6">
                        {{-- <div id="success-alert-container" ></div> --}}

                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-6 sm:col-span-3">
                                <label for="society-name"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Society Name:
                                </label>
                                <input type="text" name="society-name" id="society-name" wire:model="name"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Society Name" required value="{{ $name }}">
                            </div>
                            <div class="col-span-6 sm:col-span-3">
                                <label for="society-phone"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Phone Number:
                                </label>
                                <input type="text" name="society-phone" id="society-phone" wire:model="phone"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Phone Number" required value="{{ $phone }}">
                            </div>
                            <div class="col-span-6 sm:col-span-3">
                                <label for="society-address"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Address:
                                </label>
                                <input type="text" name="society-address" id="society-address" wire:model="address"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Address" required value="{{ $address }}">
                            </div>
                            <div class="col-span-6 sm:col-span-3">
                                <label for="bank-name"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Bank Name:
                                </label>
                                <input type="text" name="bank-name" id="bank-name" wire:model="bank_name"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Bank Name" required value="{{ $bank_name }}">
                            </div>
                            <div class="col-span-6 sm:col-span-3">
                                <label for="bank-ifsc-code"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Bank IFSC Code:
                                </label>
                                <input type="text" name="bank-ifsc-code" id="bank-ifsc-code"
                                    wire:model="bank_ifsc_code"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Bank IFSC Code" required value="{{ $bank_ifsc_code }}">
                            </div>
                            <div class="col-span-6 sm:col-span-3">
                                <label for="bank-account-number"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Bank Account Number:
                                </label>
                                <input type="text" name="bank-account-number" id="bank-account-number"
                                    wire:model="bank_account_number"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Bank Account Number" required value="{{ $bank_account_number }}">
                            </div>
                            <div class="col-span-6 sm:col-span-3">
                                <label for="member-count"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Member Count:
                                </label>
                                <input type="text" name="member-count" id="member-count"
                                    wire:model="member_count"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Member Count" required value="{{ $member_count }}">
                            </div>
                            <div class="col-span-6 sm:col-span-3">
                                <label for="president-name"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    President Name:
                                </label>
                                <input type="text" name="president-name" id="president-name"
                                    wire:model="president_name"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="President Name" required value="{{ $president_name }}">
                            </div>
                            <div class="col-span-6 sm:col-span-3">
                                <label for="vice-president-name"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Vice President Name:
                                </label>
                                <input type="text" name="vice-president-name" id="vice-president-name"
                                    wire:model="vice_president_name"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Vice President Name" required value="{{ $vice_president_name }}">
                            </div>
                            <div class="col-span-6 sm:col-span-3">
                                <label for="treasurer-name"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Treasurer Name:
                                </label>
                                <input type="text" name="treasurer-name" id="treasurer-name"
                                    wire:model="treasurer_name"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Treasurer Name" required value="{{ $treasurer_name }}">
                            </div>
                            <div class="col-span-6 sm:col-span-3">
                                <label for="secretary-name"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Secretary Name:
                                </label>
                                <input type="text" name="secretary-name" id="secretary-name"
                                    wire:model="secretary_name"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Secretary Name" required value="{{ $secretary_name }}">
                            </div>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div
                        class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                        <button type="submit"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Save
                            all</button>
                        <button type="button"
                            class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600"
                            data-modal-hide="editUserModal">Cancel</button>
                        <div id="success-alert-container" class="p-4"></div>
                    </div>
                </form>
            </div>
        </div>

        {{-- add-societies-manually --}}
        <div id="add-society-manually-modal" tabindex="-1" aria-hidden="true"
            class="fixed top-0 left-0 right-0 z-50 flex items-center justify-center hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full"
            wire:ignore.self>
            <div class="relative w-full max-w-2xl max-h-full">
                <!-- Modal content -->
                <form id="AddSocietyForm" class="relative bg-white rounded-lg shadow dark:bg-gray-700"
                    wire:submit.prevent="submit" method="POST" action="/accountant/manage/societies">
                    @csrf <!-- Add this line for CSRF token if you are using Laravel -->

                    <!-- Modal header -->
                    <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            Add Society
                        </h3>

                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-hide="add-society-manually-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="p-6 space-y-6">
                        {{-- <div id="success-alert-container" ></div> --}}

                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-6 sm:col-span-3">
                                <label for="society-name"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Society Name:
                                </label>
                                <input type="text" name="society-name" id="society-name" wire:model="name"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Society Name" required value="{{ $name }}">
                                    <span>
                                        @error('name')
                                            <span class="error" style="color: red">Enter valid Society Name!!!</span>
                                        @enderror
                                    </span>
                            </div>
                            <div class="col-span-6 sm:col-span-3">
                                <label for="society-phone"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Phone Number:
                                </label>
                                <input type="text" name="society-phone" id="society-phone" wire:model="phone"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Phone Number" required value="{{ $phone }}">
                                    <span>
                                        @error('phone')
                                            <span class="error" style="color: red">Phone Number should be 10 digits!!!</span>
                                        @enderror
                                    </span>
                            </div>
                            <div class="col-span-6 sm:col-span-3">
                                <label for="society-address"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Address:
                                </label>
                                <input type="text" name="society-address" id="society-address"
                                    wire:model="address"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Address" required value="{{ $address }}">
                                    <span>
                                        @error('address')
                                            <span class="error" style="color: red">Enter valid Address!!!</span>
                                        @enderror
                                    </span>
                            </div>
                            <div class="col-span-6 sm:col-span-3">
                                <label for="bank-name"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Bank Name:
                                </label>
                                <input type="text" name="bank-name" id="bank-name" wire:model="bank_name"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Bank Name" required value="{{ $bank_name }}">
                                    <span>
                                        @error('bank_name')
                                            <span class="error" style="color: red">Enter valid Bank Name!!!</span>
                                        @enderror
                            </div>
                            <div class="col-span-6 sm:col-span-3">
                                <label for="bank-ifsc-code"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Bank IFSC Code:
                                </label>
                                <input type="text" name="bank-ifsc-code" id="bank-ifsc-code"
                                    wire:model="bank_ifsc_code"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Bank IFSC Code" required value="{{ $bank_ifsc_code }}">
                                    <span>
                                        @error('bank_ifsc_code')
                                            <span class="error" style="color: red">Enter valid Bank IFSC Code!!!</span>
                                        @enderror
                                    </span>
                            </div>
                            <div class="col-span-6 sm:col-span-3">
                                <label for="bank-account-number"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Bank Account Number:
                                </label>
                                <input type="text" name="bank-account-number" id="bank-account-number"
                                    wire:model="bank_account_number"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Bank Account Number" required value="{{ $bank_account_number }}">
                                    <span>
                                        @error('bank_account_number')
                                            <span class="error" style="color: red">Enter valid Bank Account Number!!!</span>
                                        @enderror
                                    </span>
                            </div>
                            <div class="col-span-6 sm:col-span-3">
                                <label for="member-count"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Member Count:
                                </label>
                                <input type="text" name="member-count" id="member-count"
                                    wire:model="member_count"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Member Count" required value="{{ $member_count }}">
                                    <span>
                                        @error('member_count')
                                            <span class="error" style="color: red">Enter valid Member Count!!!</span>
                                        @enderror
                                    </span>
                            </div>
                            <div class="col-span-6 sm:col-span-3">
                                <label for="president-name"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    President Name:
                                </label>
                                <input type="text" name="president-name" id="president-name"
                                    wire:model="president_name"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="President Name" required value="{{ $president_name }}">
                                    <span>
                                        @error('president_name')
                                            <span class="error" style="color: red">Enter valid President Name!!!</span>
                                        @enderror
                                    </span>
                            </div>
                            <div class="col-span-6 sm:col-span-3">
                                <label for="vice-president-name"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Vice President Name:
                                </label>
                                <input type="text" name="vice-president-name" id="vice-president-name"
                                    wire:model="vice_president_name"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Vice President Name" required value="{{ $vice_president_name }}">
                                    <span>
                                        @error('vice_president_name')
                                            <span class="error" style="color: red">Enter valid Vice President Name!!!</span>
                                        @enderror
                                    </span>
                            </div>
                            <div class="col-span-6 sm:col-span-3">
                                <label for="treasurer-name"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Treasurer Name:
                                </label>
                                <input type="text" name="treasurer-name" id="treasurer-name"
                                    wire:model="treasurer_name"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Treasurer Name" required value="{{ $treasurer_name }}">
                                    <span>
                                        @error('treasurer_name')
                                            <span class="error" style="color: red">Enter valid Treasurer Name!!!</span>
                                        @enderror   
                                    </span>
                            </div>
                            <div class="col-span-6 sm:col-span-3">
                                <label for="secretary-name"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Secretary Name:
                                </label>
                                <input type="text" name="secretary-name" id="secretary-name"
                                    wire:model="secretary_name"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Secretary Name" required value="{{ $secretary_name }}">
                                    <span>
                                        @error('secretary_name')
                                            <span class="error" style="color: red">Enter valid Secretary Name!!!</span>
                                        @enderror
                                    </span>
                            </div>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div
                        class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                        <button type="submit"
                    class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                            clip-rule="evenodd"></path>
                    </svg>
                    Pay & save society

                    <div wire:loading class="ml-2.5">
                        <div role="status">
                            <svg aria-hidden="true"
                                class="inline w-4 h-4 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600"
                                viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                    fill="currentColor" />
                                <path
                                    d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                    fill="currentFill" />
                            </svg>
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                </button>
                        <button type="button"
                            class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600"
                            data-modal-hide="add-society-manually-modal">Cancel</button>
                        <div id="success-alert-container" class="p-4"></div>
                    </div>
                </form>
            </div>
        </div>

        {{-- add society auto --}}
    @endif
</div>


<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
    @foreach ($societies as $society)
        <div class="max-w-sm rounded overflow-hidden shadow-lg border border-black-300 society-item">
            <div class="px-6 py-4">
                <div class="font-bold text-xl mb-2 society-name">{{ $society->name }}</div>
                <p class="text-gray-700 text-base society-address">
                    Address : {{ $society->address }}
                </p>
            </div>
            <div class="px-6 pt-4 pb-2">
                <span
                    class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2 society-phone">
                    Contact Number: {{ $society->phone }}
                </span>
            </div>
            <div class="px-6 py-4">
                <button
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-flex items-center"
                    data-modal-target="editUserModal" data-modal-show="editUserModal"
                    wire:click="updateSociety({{ $society->id }})">
                    View Details
                    <svg class="w-4 h-4 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7-7 7M5 12h16" />
                    </svg>
                </button>
            </div>
        </div>
    @endforeach
</div>

<script>
    // Get the input element
    var input = document.getElementById('table-search');

    // Add event listener
    input.addEventListener('input', function() {
        var filter = input.value.toLowerCase();
        var societies = document.querySelectorAll('.society-item');

        societies.forEach(function(society) {
            var name = society.querySelector('.society-name').textContent.toLowerCase();
            var address = society.querySelector('.society-address').textContent.toLowerCase();
            var phone = society.querySelector('.society-phone').textContent.toLowerCase();

            if (name.includes(filter) || address.includes(filter) || phone.includes(filter)) {
                society.style.display = 'block';
            } else {
                society.style.display = 'none';
            }
        });
    });
</script>

{{-- <script>
    window.addEventListener('close-model',event->{
        $('#add-society-manually-modal').modal('hide');
    })
</script> --}}

{{-- <script>
    // Get the form element
    var editForm = document.getElementById('editSocietyForm');

    // Variable to store the success alert reference
    var successAlertRef = null;

    // Add event listener for form submission
    editForm.addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the default form submission behavior

        // Get the success alert container
        var successAlertContainer = document.getElementById('success-alert-container');

        // Create the success alert
        var successAlert = document.createElement('div');
        successAlert.innerHTML =
            '<div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="success"><span class="font-medium">Society details updated successfully</span></div>';

        // Append the new success alert to the container
        successAlertContainer.appendChild(successAlert);

        // Store the reference to the success alert
        successAlertRef = successAlert;

        // Optional: Reset the form fields if needed

        // Set a timeout to remove the alert after 5 seconds
        setTimeout(function() {
            if (successAlertRef) {
                successAlertRef.remove();
                successAlertRef = null;
            }
        }, 5000); // 5000 milliseconds = 5 seconds
    });
</script> --}}
