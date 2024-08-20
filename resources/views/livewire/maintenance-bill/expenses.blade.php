<div class="mt-14">
    @section('title', 'Expense Management')
    <div class="mb-4 border-mygreen-200 dark:border-mygreen-700">
        <ul class="flex flex-wrap text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400">
            <li class="me-2">
                <a href="{{ route('societyDetails', ['society' => $societyId]) }}" class="inline-block p-4 rounded-t-lg hover:text-mygreen-600 hover:bg-mygreen-50 dark:hover:bg-mygreen-800 dark:hover:text-mygreen-300">Society Dashboard</a>
            </li>
              <button aria-current="page" class="inline-block p-4 text-mygreen-600 bg-mygreen-100 rounded-t-lg active dark:bg-mygreen-800 dark:text-mygreen-500" >Expense Management</button>
          </li>
        </ul>
    </div>
    
    <div class="w-full flex flex-row items-center mb-5 ">
  
        {{-- month select --}}
        <div class='w-1/4 pr-4'>  
            <label for="months" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select
                month</label>
            <select id="months" wire:model.live="selected_month"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-mygreen-500 focus:border-mygreen-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:mygreen-500 dark:focus:border-mygreen-500">
                <option value="">Select Month</option>
                @foreach ($months as $index => $month)
                    <option value="{{ $index + 1 }}">{{ $month }}</option>
                @endforeach
            </select>
        </div>

        {{-- year select --}}
        <div class='w-1/4'>
            <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select
                Year</label>
            <select id="yaer" wire:model.live="selected_year"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-mygreen-500 focus:border-mygreen-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-mygreen-500 dark:focus:border-mygreen-500">

                <option value="">Select Year</option>
                @for ($year = now()->year; $year >= 2000; $year--)
                    <option value="{{ $year }}">{{ $year }}</option>
                @endfor
            </select>
        </div>

        {{-- generate bill button --}}
        <div class="w-1/4">
                <button type="submit" data-modal-target="crud-modal" data-modal-toggle="crud-modal"
                   class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-1.5 text-center inline-flex items-center mr-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Add Expenses
                    <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                    </svg>
                </button>
                {{-- <span wire:loading>Saving...</span> --}}
        </div>
    </div>

  
  <!-- Main modal -->
  <div id="crud-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed inset-0 z-50 flex justify-center items-center w-full h-full bg-black bg-opacity-50">
    <div class="relative p-4 w-full max-w-md">
      <!-- Modal content -->
      <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
        <!-- Modal header -->
        <div class="flex items-center justify-between p-4 border-b rounded-t dark:border-gray-600">
          <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
            Add the Expenses
          </h3>
          <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="crud-modal">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
              <path d="M6 18L18 6M6 6l12 12"></path>
            </svg>
            <span class="sr-only">Close modal</span>
          </button>
        </div>
        <!-- Modal body -->
        <form wire:submit.prevent="submitExpense" onsubmit="handleSubmit(event)" class="p-4 space-y-4" >
          <div>
            <label for="price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Amount</label>
            <input type="text" wire:model="price" id="price" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="$2999" required>
            @error('price') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
          </div>
  
          <div>
            <label for="category" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Expense Type</label>
            <select wire:model="selectedExpenseType" id="category" class="...">
                <option value="">Select category</option>
                @foreach($expenseTypes as $expenseType)
                    <option value="{{ $expenseType->id }}">{{ $expenseType->name }}</option>
                @endforeach
            </select>
            @error('selectedExpenseType') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
          </div>

          <div>
            <label for="reference_number" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Reference Number</label>
            <input type="text" wire:model="reference_number" id="reference_number" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="$2999" required>
            @error('reference_number') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
          </div>
  
          <div>
            <label for="remark" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Remark</label>
            <textarea wire:model="remark" id="remark" rows="4" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="Write expense remark here"></textarea>
            @error('remark') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
          </div>


  
          <button type="submit" class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-800">
            <svg class="w-5 h-5 inline-block mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
            Add new expense
          </button>
        </form>
  
        @if (session()->has('message'))
          <div class="p-4 mt-4 text-sm text-green-800 bg-green-50 rounded-lg dark:bg-gray-800 dark:text-green-400" role="alert">
            {{ session('message') }}
          </div>
        @endif
      </div>
    </div>
  </div>



  <table class="min-w-full bg-white border border-gray-300">
    <thead>
        <tr>
            <th class="px-4 py-2 bg-gray-100 border-b">Date</th>
            <th class="px-4 py-2 bg-gray-100 border-b">Expense Type</th>
            <th class="px-4 py-2 bg-gray-100 border-b">Amount</th>
            <th class="px-4 py-2 bg-gray-100 border-b">Description</th>
            {{-- <th class="px-4 py-2 bg-gray-100 border-b">Description</th> --}}
        </tr>
    </thead>
    <tbody>
      @forelse($expenses as $expense)
          <tr>
              <td class="px-4 py-2 border-b">{{ $expense->created_at->format('Y-m-d') }}</td>
              <td class="px-4 py-2 border-b">{{ $expense->expense_type_name }}</td>
              <td class="px-4 py-2 border-b">{{ number_format($expense->amount, 2) }}</td>
              <td class="px-4 py-2 border-b">{{ $expense->remark }}</td>
              {{-- <td class="px-6 py-4 whitespace-nowrap">
                <button onclick="downloadBill({{ $expense->id }})">Download Bill</button>
              </td> --}}
          </tr>
      @empty
          <tr>
              <td colspan="5" class="px-4 py-2 text-center border-b">No expenses found for the selected period.</td>
          </tr>
      @endforelse
  </tbody>
  
</table>


<script>
  function handleSubmit(event) {
      event.preventDefault();  // Prevent the default form submission

      // Perform form submission via AJAX or similar method here

      // Refresh the page after successful submission
      window.location.reload();
  }
</script>

<script>
  Livewire.on('expenseAdded', () => {
      alert('Expense added successfully!');
  });

  @if (session()->has('error'))
      alert('{{ session('error') }}');
  @endif
</script>

@if (session()->has('success'))
    <x-toast type="success" :message="session('success')" />
@endif

@if (session()->has('error'))
    <x-toast type="error" :message="session('error')" />
@endif

@if (session()->has('info'))
    <x-toast type="info" :message="session('info')" />
@endif

   
  
    
</div>
