@props(['type' => 'info', 'message' => ''])

@php
    $color = match($type) {
        'success' => 'bg-green-500',
        'error' => 'bg-red-500',
        'warning' => 'bg-yellow-500',
        'info' => 'bg-blue-500',
        default => 'bg-gray-500',
    };
    
    $icon = match($type) {
        'success' => '✓',
        'error' => '✕',
        'warning' => '⚠',
        'info' => 'ℹ',
        default => '',
    };
@endphp

<div x-data="{ show: true }" 
     x-init="setTimeout(() => show = false, 80000)" 
     x-show="show"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 translate-y-2"
     x-transition:enter-end="opacity-100 translate-y-0"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100 translate-y-0"
     x-transition:leave-end="opacity-0 translate-y-2"
     class="fixed top-6 right-6 {{ $color }} text-white px-6 py-4 rounded-lg shadow-xl z-50 max-w-md w-full flex items-start space-x-3">
    <span class="font-bold text-lg flex-shrink-0">{{ $icon }}</span>
    <p class="flex-grow text-sm">{{ $message }}</p>
    <button @click="show = false" class="text-white hover:text-gray-200 focus:outline-none">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
        </svg>
    </button>
</div>



{{-- 
@php
    $color = match($type) {
        'success' => 'bg-green-600',
        'error' => 'bg-red-600',
        'warning' => 'bg-yellow-500',
        'info' => 'bg-blue-600',
        default => 'bg-gray-600',
    };
@endphp

<div x-data="{ show: true }" x-init="setTimeout(() => show = false, 80000)" x-show="show"
     class="fixed top-4 left-1/2 transform -translate-x-1/2 {{ $color }} text-white px-6 py-3 rounded shadow-lg text-center z-50">
    <p>{{ $message }}</p>
</div> --}}


{{-- @if(session()->has('message'))
<div x-data="{ show: true }" x-init="setTimeout(() => show = false, 8000)" x-show="show" class="fixed top-0 left-1/2 transform -translate-x-1/2 bg-laravel text-white px-48 py-3 rounded text-center">
   <p>
       {{ session('message') }}
    </p>   
</div>
@endif --}}