<div>
    {{-- The whole world belongs to you. --}}
  
    <label for="societies" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select a society</label>
    <select id="societies" wire:model.live="selectedSociety"
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
        <option selected>Choose a society</option>
        @foreach ($societyName as $key => $value)
            <option value="{{ $key }}">{{ $value }}</option>
        @endforeach
    </select>
</div>
   