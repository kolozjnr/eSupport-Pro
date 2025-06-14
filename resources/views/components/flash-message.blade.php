@props(['type' => 'info', 'message' => ''])

@php
    $color = match($type) {
        'success' => 'bg-green-600',
        'error' => 'bg-red-600',
        'warning' => 'bg-yellow-500',
        'info' => 'bg-blue-600',
        default => 'bg-gray-600',
    };
@endphp

<div x-data="{ show: true }" x-init="setTimeout(() => show = false, 8000)" x-show="show"
     class="fixed top-4 left-1/2 transform -translate-x-1/2 {{ $color }} text-white px-6 py-3 rounded shadow-lg text-center z-50">
    <p>{{ $message }}</p>
</div>


{{-- @if(session()->has('message'))
<div x-data="{ show: true }" x-init="setTimeout(() => show = false, 8000)" x-show="show" class="fixed top-0 left-1/2 transform -translate-x-1/2 bg-laravel text-white px-48 py-3 rounded text-center">
   <p>
       {{ session('message') }}
    </p>   
</div>
@endif --}}