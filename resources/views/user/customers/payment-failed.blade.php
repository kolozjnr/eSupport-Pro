<x-app-layout>
    <div class="page-content">
        @include('../layouts.top-header')

        <main class="flex-grow p-6">
            <!-- Failed Transaction Container -->
            <div class="max-w-2xl mx-auto bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden transition-colors duration-300">
                <!-- Error Header -->
                <div class="bg-red-600 p-6 text-white">
                    <div class="flex justify-between items-start">
                        <div>
                            <h1 class="text-2xl font-bold">Payment Failed</h1>
                            <p class="text-red-100">We couldn't process your payment</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-red-200">Reference #{{ $data['paymentReference'] ?? 'N/A' }}</p>
                            <p class="text-xs text-red-200">{{ now()->format('M d, Y h:i A') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Error Body -->
                <div class="p-6">
                    <!-- Error Details -->
                    <div class="mb-8">
                        <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4 border-b border-gray-200 dark:border-gray-700 pb-2">
                            Transaction Details
                        </h2>
                        
                        <div class="space-y-4">
                            <div class="flex flex-col sm:flex-row justify-between gap-2">
                                <span class="text-gray-600 dark:text-gray-400">Transaction Reference:</span>
                                <span class="font-medium text-gray-800 dark:text-gray-200 break-all">{{ $data['transactionReference'] ?? 'N/A' }}</span>
                            </div>
                            
                            <div class="flex flex-col sm:flex-row justify-between gap-2">
                                <span class="text-gray-600 dark:text-gray-400">Payment Status:</span>
                                <span class="font-medium text-red-600 dark:text-red-400">Failed</span>
                            </div>
                            
                            <div class="bg-red-50 dark:bg-red-900/20 rounded-lg p-4 mt-4">
                                <div class="flex items-start gap-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <div>
                                        <h3 class="font-medium text-red-800 dark:text-red-200">Payment Unsuccessful</h3>
                                        <p class="text-sm text-red-700 dark:text-red-300 mt-1">
                                            We were unable to process your payment. Please try again or contact support if the problem persists.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-3 mt-8">
                        <a href="{{ route('payment.retry') }}" class="px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white rounded-lg transition-colors duration-300 text-center font-medium">
                            Try Payment Again
                        </a>
                        <a href="{{ route('support.contact') }}" class="px-6 py-3 border border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-lg transition-colors duration-300 text-center font-medium text-gray-800 dark:text-gray-200">
                            Contact Support
                        </a>
                    </div>
                </div>

                <!-- Footer -->
                <div class="bg-gray-100 dark:bg-gray-900 p-6 border-t border-gray-200 dark:border-gray-700">
                    <p class="text-sm text-gray-600 dark:text-gray-400 text-center">
                        For assistance, please email support@esupport.com or call +1 (234) 567-8900
                    </p>
                </div>
            </div>
        </main>

        @include('layouts.footer')
    </div>
</x-app-layout>