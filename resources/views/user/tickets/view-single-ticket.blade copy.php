<x-app-layout>

    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->
<link rel="stylesheet" href="https://cdnjs.cloudflare./ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <div class="page-content">
        @include('../layouts.top-header')
     
            <main class="flex-grow p-6"> 
                <!-- Page Title Start -->
                <div class="flex justify-between items-center mb-6">
                    <h4 class="text-slate-900 dark:text-slate-200 text-lg font-medium">Ticket single</h4>

                    <div class="md:flex hidden items-center gap-2.5 text-sm font-semibold">
                        <div class="flex items-center gap-2">
                            <a href="#" class="text-sm font-medium text-slate-700 dark:text-slate-400">eSupport</a>
                        </div>

                        <div class="flex items-center gap-2">
                            <i class="mgc_right_line text-lg flex-shrink-0 text-slate-400 rtl:rotate-180"></i>
                            <a href="#" class="text-sm font-medium text-slate-700 dark:text-slate-400">Ticket</a>
                        </div>

                        <div class="flex items-center gap-2">
                            <i class="mgc_right_line text-lg flex-shrink-0 text-slate-400 rtl:rotate-180"></i>
                            <a href="#" class="text-sm font-medium text-slate-700 dark:text-slate-400" aria-current="page">Single Ticket</a>
                        </div>
                    </div>
                </div>
                <!-- Page Title End -->

                <div class="flex flex-col gap-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="flex justify-between items-center">
                                <h4 class="card-title">Preview Ticket</h4>
                            </div>
                        </div>
                        <div class="mt-6">
                            <div class="card">
                                {{-- <div class="flex flex-wrap justify-between items-center gap-2 p-6">
                                    <a href="javascript:void(0);" class="btn bg-danger/20 text-sm font-medium text-danger hover:text-white hover:bg-danger"><i class="mgc_add_circle_line me-3"></i> Add Customers</a>
                                    <div class="flex flex-wrap gap-2">
                                        <button type="button" class="btn bg-success/25 text-lg font-medium text-success hover:text-white hover:bg-success"><i class="mgc_settings_3_line"></i></button>
                                        <button type="button" class="btn bg-dark/25 text-sm font-medium text-slate-900 dark:text-slate-200/70 hover:text-white hover:bg-dark/90">Import</button>
                                        <button type="button" class="btn bg-dark/25 text-sm font-medium text-slate-900 dark:text-slate-200/70 hover:text-white hover:bg-dark/90">Export</button>
                                    </div>
                                </div> --}}
                                <div class="relative overflow-x-auto">
                                    <table class="w-full divide-y divide-gray-300 dark:divide-gray-700">
                                        <thead class="bg-slate-300 bg-opacity-20 border-t dark:bg-slate-800 divide-gray-300 dark:border-gray-700">
                                            <tr>
                                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-gray-200">Requested By</th>
                                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-gray-200">Description</th>
                                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-gray-200">Assignee</th>
                                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-gray-200">Review</th>
                                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-gray-200">Status</th>
                                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-gray-200">Created Date</th>
                                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-gray-200">Due Date</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700 ">
                                            <tr>
                                                <td class="whitespace-nowrap py-4 pe-3 text-sm">
                                                    <div class="flex items-center">
                                                        <div class="h-10 w-10 flex-shrink-0">
                                                           {{-- <p class="text-sm text-gray-500 dark:text-gray-400"></p> --}}
                                                        </div>
                                                        {{-- <div class="font-medium text-gray-900 dark:text-gray-200 ms-4">{{$ticket->customer->user->fname .' ' . $ticket->customer->user->lname ?? ''}}</div> --}}
                                                    </div>
                                                </td>
                                                <td class="whitespace-nowrap py-4 pe-3 text-sm font-medium text-gray-900 dark:text-gray-200">{{$ticket->description ?? ''}}</td>
                                                
                                                {{-- <td class="whitespace-nowrap py-4 pe-3 text-sm font-medium text-gray-900 dark:text-gray-200">{{$ticket->support->user->fname .' ' . $ticket->support->user->lname ?? ''}}</td> --}}
                                                {{-- <td class="whitespace-nowrap py-4 px-3 text-sm">
                                                    <img class="h-10 w-10 rounded-full" src="assets/images/users/avatar-9.jpg" alt="">
                                                </td> --}}
                                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                    <div class="whitespace-nowrap py-4 pe-3 text-sm font-medium text-gray-900 dark:text-gray-200">{{$ticket->comments}}</div>
                                                </td>
                                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                    <div class="inline-flex items-center gap-1.5 py-1 px-3 rounded text-xs font-medium bg-dark/80 text-white"></div>
                                                </td>
                                                <td class="whitespace-nowrap py-4 pe-3 text-sm font-medium text-gray-900 dark:text-gray-200">{{ $ticket->status }}</td>
                                                <td class="whitespace-nowrap py-4 pe-3 text-sm font-medium text-gray-900 dark:text-gray-200">{{$ticket->created_at}}</td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>

            </main>


            
    <!-- Review Modal -->
<div x-data="reviewModal" x-show="isOpen" @keydown.escape="close" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
    <!-- Overlay -->
    <div x-show="isOpen" 
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-gray-500 dark:bg-gray-900 bg-opacity-75 transition-opacity"></div>

    <!-- Modal Container -->
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Modal Content -->
        <div x-show="isOpen"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             class="inline-block align-bottom bg-white dark:bg-slate-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
             role="dialog" aria-modal="true" aria-labelledby="modal-headline">
            
            <!-- Header -->
            <div class="bg-gray-50 dark:bg-slate-700 px-4 py-3 sm:px-6 sm:flex sm:items-center sm:justify-between">
                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white" id="modal-headline">
                    Write a Review
                </h3>
                <button @click="close" type="button" class="text-gray-400 hover:text-gray-500 dark:text-gray-300 dark:hover:text-gray-200">
                    <span class="sr-only">Close</span>
                    <i class="mgc_close_line text-xl"></i>
                </button>
            </div>
            
            <!-- Body -->
            <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <form @submit.prevent="submitReview">
                    <!-- Rating -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Your Rating
                        </label>
                        <div class="flex items-center">
                            <template x-for="i in 5" :key="i">
                                <button type="button" @click="rating = i" class="focus:outline-none">
                                    <i class="text-2xl" 
                                       :class="{
                                           'mgc_star_fill text-yellow-400': i <= rating,
                                           'mgc_star_line text-gray-300 dark:text-gray-500': i > rating
                                       }"></i>
                                </button>
                            </template>
                            <span x-text="rating" class="ml-2 text-sm font-medium text-gray-500 dark:text-gray-400"></span>
                        </div>
                        <p x-show="errors.rating" x-text="errors.rating" class="mt-1 text-sm text-red-600 dark:text-red-500"></p>
                    </div>
                    
                    <!-- Review Text -->
                    <div class="mb-6">
                        <label for="review" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Your Review
                        </label>
                        <textarea id="review" x-model="review" rows="4"
                                  class="shadow-sm focus:ring-primary-500 focus:border-primary-500 block w-full sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-slate-700 dark:text-white rounded-md"></textarea>
                        <p x-show="errors.review" x-text="errors.review" class="mt-1 text-sm text-red-600 dark:text-red-500"></p>
                    </div>
                    
                    <!-- Loading Indicator -->
                    <div x-show="isLoading" class="flex justify-center mb-4">
                        <div class="animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-primary"></div>
                    </div>
                    
                    <!-- Success Message -->
                    <div x-show="isSuccess" class="mb-4 p-4 bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-200 rounded-md">
                        <div class="flex items-center">
                            <i class="mgc_check_line text-lg mr-2"></i>
                            <span>Review submitted successfully!</span>
                        </div>
                    </div>
                    
                    <!-- Error Message -->
                    <div x-show="errorMessage" class="mb-4 p-4 bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-200 rounded-md">
                        <div class="flex items-center">
                            <i class="mgc_error_warning_line text-lg mr-2"></i>
                            <span x-text="errorMessage"></span>
                        </div>
                    </div>
                </form>
            </div>
            
            <!-- Footer -->
            <div class="bg-gray-50 dark:bg-slate-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" @click="submitReview"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-primary text-base font-medium text-white hover:bg-primary-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:ml-3 sm:w-auto sm:text-sm">
                    Submit Review
                </button>
                <button type="button" @click="close"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-slate-600 text-base font-medium text-gray-700 dark:text-white hover:bg-gray-50 dark:hover:bg-slate-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>
            
            
   <script src="{{ asset('assets/libs/gridjs/gridjs.umd.js') }}" defer></script>
     
         <!-- Gridjs Demo js -->
         <script src="{{ asset('assets/js/pages/table-gridjs.js') }}" defer></script>


         
<script src="https://unpkg.com/gridjs/dist/gridjs.umd.js"></script>
<script src="https://unpkg.com/gridjs-plugins/dist/gridjs-plugins.umd.js"></script>

       

    @include('layouts.footer')

</x-app-layout>