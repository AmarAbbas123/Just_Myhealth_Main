@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100 focus:border-teal-500 focus:ring-teal-500 rounded-xl shadow-sm text-sm']) !!}>
