@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-mygreen-500 dark:focus:border-mygreen-600 focus:ring-mygreen-500 dark:focus:ring-mygreen-600 rounded-md shadow-sm']) !!}>
