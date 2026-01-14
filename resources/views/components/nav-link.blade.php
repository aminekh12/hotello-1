@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-orange-400 dark:border-orange-600 text-sm font-medium leading-5 text-gray-900 dark:text-orange-100 focus:outline-none focus:border-orange-700 transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 dark:text-orange-300 hover:text-gray-700 dark:hover:text-orange-200 hover:border-orange-300 dark:hover:border-orange-700 focus:outline-none focus:text-gray-700 dark:focus:text-orange-200 focus:border-orange-300 dark:focus:border-orange-700 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
