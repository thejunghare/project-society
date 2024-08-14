<div class="mt-16">
    <!-- show user info -->
    <div
        class="mt-14 md:mt-12 lg:mt-12 w-full  p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
        <a href="#">
            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                स्वागत आहे, {{Auth::user()->name}}</h5>
        </a>
        <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">You need to register as a member of a society to pay
            bills and use other features. </p>
    </div>

    <!-- maintenance info -->
    <div class="flex flex-wrap lg:flex-nowrap mt-4">
        <!-- <div class="welcome flex flex-col w-full lg:w-1/2 p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700"
            style="border-radius: 9px;">
            <h3 class="text-2xl font-semibold text-gray-900 dark:text-white mb-2">स्वागत आहे, </h3>
            <p class="text-lg text-gray-700 dark:text-gray-400 mb-1">{{ Auth::user()->name }}</p>
            <h5 class="mb-3 text-xl font-bold tracking-tight text-gray-900 dark:text-white">
                {{-- You are member of {{ $member->society->name }} society --}}
            </h5>
            <div class="flex flex-row items-center w-full justify-between">
                <div class="text-gray-700 dark:text-gray-400 mb-2">
                    <span class="font-semibold">फ्लॅट क्रमांक:</span> {{ $member->room_number }}
                </div>
                <div class="text-gray-700 dark:text-gray-400">
                    <span class="font-semibold">Status:</span> {{ $member->is_rented ? 'भाड्याने' : 'स्वतःचा' }}
                </div>
            </div>
        </div> -->

        <div class="welcome flex flex-col w-full lg:w-1/2 p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 ">
            <h3 class="text-lg font-semibold mb-1">वर्ष आणि महिना निवडा</h3>

            <div class="flex space-x-4">
                <div>
                    <label for="year-select" class="block mb-1">वर्ष:</label>
                    <select id="year-select" wire:model="selectedYear" wire:change="calculateTotalPayable"
                        class="form-select rounded-md shadow-sm bg-gray-100 text-gray-800">
                        @foreach (range(date('Y') - 5, date('Y')) as $year)
                            <option value="{{ $year }}" {{ $year == $selectedYear ? 'selected' : '' }}>
                                {{ $year }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="month-select" class="block mb-1">महिना:</label>
                    <select id="month-select" wire:model="selectedMonth" wire:change="calculateTotalPayable"
                        class="form-select rounded-md shadow-sm bg-gray-100 text-gray-800">
                        @foreach (range(1, 12) as $month)
                        <option value="{{ $month }}" {{ $month == $selectedMonth ? 'selected' : '' }}>
                            {{ date('F', mktime(0, 0, 0, $month, 1)) }}
                        </option>
                    @endforeach
                    </select>
                </div>
                <div class="self-end">
                    <button wire:click="resetSelection" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                        Reset to Current
                    </button>
                </div>
            </div>
        </div>

        <div class="amount w-full lg:w-1/2 flex flex-col justify-center lg:ml-4">
            <div class="flex flex-col space-y-4">
                <div
                    class="flex flex-col items-center justify-center h-24 w-full rounded bg-gray-100 dark:bg-gray-700 border shadow-md hover:bg-gray-200 dark:hover:bg-gray-600">
                    <div class="text-center p-3">
                        <p class="text-xl font-medium text-gray-900 dark:text-white">एकूण प्राप्ती</p>
                    </div>
                    <div class="text-center pb-2">
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">Rs
                            {{ number_format($receivableAmount, 2) }} /-</p>
                    </div>
                </div>
                <div
                    class="flex flex-col items-center justify-center h-24 w-full rounded bg-gray-100 dark:bg-gray-700 border shadow-md hover:bg-gray-200 dark:hover:bg-gray-600">
                    <div class="text-center p-3">
                        <p class="text-xl font-medium text-gray-900 dark:text-white">एकूण प्राप्त</p>
                    </div>
                    <div class="text-center pb-2">
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">Rs
                            {{ number_format($totalPayable, 2) }}/-</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- society info -->
    <!-- <div class="mt-4 p-0">
        <div class="">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-4">
                <div class="flex-col items-center justify-center bg-gray-100 dark:bg-gray-700 border shadow-md hover:shadow-lg hover:bg-gray-200 dark:hover:bg-gray-600 h-auto"
                    style="border-radius: 9px;">
                    <div class="align-center flex flex-col items-center bg-mygreen dark:bg-mygreen rounded-t-lg">
                        <p class="text-lg font-bold text-gray-900 dark:text-white p-3">Society Details</p>
                    </div>
                    <div
                        class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-4 border-b dark:bg-gray-800 dark:border-gray-700">
                        <div class="p-3 flex-row">
                            <p class="text-lg text-gray-900 dark:text-white"><span class="font-medium">Society
                                    Name:</span> {{ $member->society->name }}</p>
                        </div>
                        <div class="p-3 flex-row">
                            <p class="text-lg text-gray-900 dark:text-white"><span class="font-medium">Phone
                                    Number:</span> {{ $member->society->phone }}</p>
                        </div>
                    </div>
                    <div
                        class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-4 border-b dark:bg-gray-800 dark:border-gray-700">
                        <div class="p-3 flex-row">
                            <p class="text-base text-gray-900 dark:text-white"><span class="font-medium">Address:</span>
                                {{ $member->society->address }}</p>
                        </div>
                        <div class="p-3 flex-row">
                            <p class="text-lg text-gray-900 dark:text-white"><span class="font-medium">Bank
                                    Name:</span> {{ $member->society->bank_name }}</p>
                        </div>
                    </div>
                    <div
                        class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-4 border-b dark:bg-gray-800 dark:border-gray-700">
                        <div class="p-3 flex-row">
                            <p class="text-lg text-gray-900 dark:text-white"><span class="font-medium">Bank IFSC
                                    Code:</span> {{ $member->society->bank_ifsc_code }}</p>
                        </div>
                        <div class="p-3 flex-row">
                            <p class="text-lg text-gray-900 dark:text-white"><span class="font-medium">Bank
                                    Account
                                    Number:</span> {{ $member->society->bank_account_number }}</p>
                        </div>
                    </div>
                    <div
                        class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-4 border-b dark:bg-gray-800 dark:border-gray-700">
                        <div class="p-3 flex-row">
                            <p class="text-base text-gray-900 dark:text-white"><span class="font-medium">President
                                    Name:</span> {{ $member->society->president_name }}</p>
                        </div>
                        <div class="p-3 flex-row">
                            <p class="text-base text-gray-900 dark:text-white"><span class="font-medium">Vice
                                    President
                                    Name:</span> {{ $member->society->vice_president_name }}</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-4">
                        <div class="p-3 flex-row">
                            <p class="text-base text-gray-900 dark:text-white"><span class="font-medium">Treasurer
                                    Name:</span> {{ $member->society->treasurer_name }}</p>
                        </div>
                        <div class="p-3 flex-row">
                            <p class="text-base text-gray-900 dark:text-white"><span class="font-medium">Secretary
                                    Name:</span> {{ $member->society->secretary_name }}</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-4">
                        <div class="p-3 flex-row">
                            <p class="text-base text-gray-900 dark:text-white"><span class="font-medium">UPI
                                    ID:</span>
                                {{ $member->society->upi_id }}</p>
                        </div>
                        <div class="p-3 flex-row">
                            <p class="text-base text-gray-900 dark:text-white"><span class="font-medium">UPI
                                    number:</span> {{ $member->society->upi_number }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->

    <!-- charges description -->
    <div class="mt-14 md:mt-12 lg:mt-12 w-full p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
        <div class="relative overflow-hidden bg-white  dark:bg-gray-800 sm:rounded-lg">
          <div class="flex-row items-center justify-between p-4 sm:flex sm:space-y-0 sm:space-x-4">
            <div>
              <h5 class="mr-3 font-semibold dark:text-white">शुल्क</h5>
              <p class="text-gray-500 dark:text-gray-400">Manage all your existing users or add a new one</p>
            </div>
          </div>
        </div>

        <div class="relative overflow-x-auto">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            मेन्टेनन्स शुल्क
                        </th>
                        <th scope="col" class="px-6 py-3">
                            मेन्टेनन्स उशीर शुल्क
                        </th>
                        <th scope="col" class="px-6 py-3">
                            पार्किंग शुल्क
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ number_format($maintenance, 2) }}
                        </th>
                        <td class="px-6 py-4">
                       {{  number_format($member->society->late_fee, 2) }}
                        </td>
                        <td class="px-6 py-4">
                        {{ number_format($member->society->parking_charges, 2) }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
