<x-app-layout>
    <div class="page-content">
        @include('../layouts.top-header')

        <main class="flex-grow p-6">
            <!-- Receipt Container -->
            <div class="max-w-2xl mx-auto bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden transition-colors duration-300">
                <!-- Receipt Header -->
                <div class="bg-primary-600 p-6 text-white">
                    <div class="flex justify-between items-start">
                        <div>
                            <h1 class="text-2xl font-bold">Payment Receipt</h1>
                            <p class="text-primary-100">Thank you for your payment</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-primary-200">Receipt #{{ $data['paymentReference'] }}</p>
                            <p class="text-xs text-primary-200">{{ now()->format('M d, Y h:i A') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Receipt Body -->
                <div class="p-6">
                    <!-- Payment Details -->
                    <div class="mb-8">
                        <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4 border-b border-gray-200 dark:border-gray-700 pb-2">
                            Payment Details
                        </h2>
                        
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Transaction Reference:</span>
                                <span class="font-medium text-gray-800 dark:text-gray-200">{{ $data['transactionReference'] }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Payment Method:</span>
                                <span class="font-medium text-gray-800 dark:text-gray-200">{{ $data['paymentMethod'] ?? 'Card' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Payment Status:</span>
                                <span class="font-medium text-green-600 dark:text-green-400">Successful</span>
                            </div>
                        </div>
                    </div>

                    <!-- Amount Details -->
                    <div class="mb-8">
                        <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4 border-b border-gray-200 dark:border-gray-700 pb-2">
                            Amount Details
                        </h2>
                        
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Amount Paid:</span>
                                <span class="font-medium text-gray-800 dark:text-gray-200">{{ $data['currency'] }} {{ number_format($data['amountPaid'], 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Payment Date:</span>
                                <span class="font-medium text-gray-800 dark:text-gray-200">{{ \Carbon\Carbon::parse($data['paidOn'])->format('M d, Y h:i A') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Customer Details -->
                    <div class="mb-8">
                        <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4 border-b border-gray-200 dark:border-gray-700 pb-2">
                            Customer Details
                        </h2>
                        
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Customer Name:</span>
                                <span class="font-medium text-gray-800 dark:text-gray-200">{{ $data['customer']['name'] ?? 'N/A' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Customer Email:</span>
                                <span class="font-medium text-gray-800 dark:text-gray-200">{{ $data['customer']['email'] ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Summary -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-semibold text-gray-800 dark:text-gray-200">Total Paid</span>
                            <span class="text-2xl font-bold text-primary-600 dark:text-primary-400">
                                {{ $data['currency'] }} {{ number_format($data['amountPaid'], 2) }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Receipt Footer -->
                <div class="bg-gray-100 dark:bg-gray-900 p-6 border-t border-gray-200 dark:border-gray-700">
                    <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                        <p class="text-sm text-gray-600 dark:text-gray-400 text-center sm:text-left">
                            Thank you for choosing our service. For any inquiries, please contact support@esupport.com
                        </p>
                        
                        <!-- Download Button -->
                        <button onclick="downloadReceipt()" class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg transition-colors duration-300 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                            Download Receipt
                        </button>
                    </div>
                </div>
            </div>
        </main>

        @include('layouts.footer')
    </div>

    <!-- HTML2PDF Script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
        function downloadReceipt() {
            const element = document.querySelector('.page-content');
            const opt = {
                margin: 10,
                filename: 'payment_receipt_{{ $data["paymentReference"] }}.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
            };

            // Show loading state
            const button = document.querySelector('button[onclick="downloadReceipt()"]');
            const originalText = button.innerHTML;
            button.innerHTML = `<span class="animate-spin">⏳</span> Generating PDF...`;
            button.disabled = true;

            // Generate PDF
            html2pdf().from(element).set(opt).save().then(() => {
                // Restore button state
                button.innerHTML = originalText;
                button.disabled = false;
            });
        }
    </script>
</x-app-layout>