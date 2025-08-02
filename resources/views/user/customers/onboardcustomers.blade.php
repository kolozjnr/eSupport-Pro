<x-app-layout>

    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->
    
    <link href="{{ asset('assets/libs/gridjs/theme/mermaid.min.css')}}" rel="stylesheet" type="text/css" >
    <div class="page-content">
        @include('../layouts.top-header')
        <div x-data="onboardCustomers()">
            <main class="flex-grow p-6">

                    <!-- Page Title Start -->
                    <div class="flex justify-between items-center mb-6">
                        {{-- <h4 class="text-slate-900 dark:text-slate-200 text-lg font-medium">Layout</h4> --}}

                        <div class="md:flex hidden items-center gap-2.5 text-sm font-semibold">
                            <div class="flex items-center gap-2">
                                <a href="#" class="text-sm font-medium text-slate-700 dark:text-slate-400">eSupport</a>
                            </div>

                            <div class="flex items-center gap-2">
                                <i class="mgc_right_line text-lg flex-shrink-0 text-slate-400 rtl:rotate-180"></i>
                                <a href="#" class="text-sm font-medium text-slate-700 dark:text-slate-400">Customer</a>
                            </div>

                            <div class="flex items-center gap-2">
                                <i class="mgc_right_line text-lg flex-shrink-0 text-slate-400 rtl:rotate-180"></i>
                                <a href="#" class="text-sm font-medium text-slate-700 dark:text-slate-400" aria-current="page">Customer onboarding</a>
                            </div>
                        </div>
                    </div>
                    <!-- Page Title End -->

                    <div class="grid lg:grid-cols-2 grid-cols-1 gap-6">
                    
                        <!-- Single Customer Onboarding -->
                        <div class="col-span-2">
                            <div class="card">
                                <div class="card-header">
                                    <div class="flex justify-between items-center">
                                        <h4 class="card-title">Single Customer Onboarding</h4>
                                    </div>
                                </div>
                                <div class="p-6">
                                    <form method="POST" action="{{ route('customers.single-customer') }}" enctype="multipart/form-data" @submit="singleFormSubmitting = true">
                                        @csrf
                                        
                                        <!-- Basic Information -->
                                        <div class="mb-6">
                                            <h5 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-4">Basic Information</h5>
                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                <div>
                                                    <label for="fname" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">First name *</label>
                                                    <input type="text" name="fname" class="form-input" x-model="formData.fname" id="fname" required>
                                                </div>
                                                <div>
                                                    <label for="mname" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Middle name</label>
                                                    <input type="text" name="mname" class="form-input" x-model="formData.mname" id="mname">
                                                </div>
                                                <div>
                                                    <label for="lname" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Last name *</label>
                                                    <input type="text" name="lname" class="form-input" x-model="formData.lname" id="lname" required>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Contact Information -->
                                        <div class="mb-6">
                                            <h5 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-4">Contact Information</h5>
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                <div>
                                                    <label for="email" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Email *</label>
                                                    <input type="email" name="email" class="form-input" x-model="formData.email" id="email" required>
                                                </div>
                                                <div>
                                                    <label for="phone_number" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Phone Number</label>
                                                    <input type="tel" name="phone_number" class="form-input" x-model="formData.phone_number" id="phone_number">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Personal Details -->
                                        <div class="mb-6">
                                            <h5 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-4">Personal Details</h5>
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                <div>
                                                    <label for="nin" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">NIN</label>
                                                    <input type="text" name="nin" class="form-input" x-model="formData.nin" id="nin" maxlength="11">
                                                </div>
                                                <div>
                                                    <label for="display_picture" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Display Picture</label>
                                                    <input type="file" name="display_picture" class="form-input" id="display_picture" accept="image/*">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Address Information -->
                                        <div class="mb-6">
                                            <h5 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-4">Address Information</h5>
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                <div>
                                                    <label for="address" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Address</label>
                                                    <textarea name="address" class="form-input" x-model="formData.address" id="address" rows="3"></textarea>
                                                </div>
                                                <div>
                                                    <label for="land_mark" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Landmark</label>
                                                    <input type="text" name="land_mark" class="form-input" x-model="formData.land_mark" id="land_mark">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Next of Kin Information -->
                                        <div class="mb-6">
                                            <h5 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-4">Next of Kin Information</h5>
                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                <div>
                                                    <label for="nok_name" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Next of Kin Name</label>
                                                    <input type="text" name="nok_name" class="form-input" x-model="formData.nok_name" id="nok_name">
                                                </div>
                                                <div>
                                                    <label for="nok_phone" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Next of Kin Phone</label>
                                                    <input type="tel" name="nok_phone" class="form-input" x-model="formData.nok_phone" id="nok_phone">
                                                </div>
                                                <div>
                                                    <label for="nok_address" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Next of Kin Address</label>
                                                    <textarea name="nok_address" class="form-input" x-model="formData.nok_address" id="nok_address" rows="3"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                
                                        <div class="flex gap-4 mt-6">
                                            <button 
                                                type="submit" 
                                                class="btn bg-primary text-white flex items-center gap-2 min-w-[120px] justify-center"
                                                :disabled="singleFormSubmitting"
                                                :class="{ 'opacity-75 cursor-not-allowed': singleFormSubmitting }"
                                            >
                                                <div x-show="singleFormSubmitting" class="animate-spin rounded-full h-4 w-4 border-b-2 border-white"></div>
                                                <span x-text="singleFormSubmitting ? 'Submitting...' : 'Submit'"></span>
                                            </button>
                                            <button 
                                                type="button" 
                                                class="btn bg-gray-500 text-white"
                                                @click="resetSingleForm()"
                                                :disabled="singleFormSubmitting"
                                            >
                                                Reset
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Multiple Customer Onboarding -->
                        <div class="col-span-2">
                            <div class="card">
                                <div class="card-header">
                                    <div class="flex justify-between items-center">
                                        <h4 class="card-title">Multiple customer onboarding</h4>
                                        <div class="flex items-center gap-2">
                                            <a href="{{route('customers.download-onboarding-template')}}" class="btn-code flex items-center gap-2">
                                                <i class="mgc_download_line text-lg"></i>
                                                <span>Download Template</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="p-6">
                                    <p class="text-sm text-slate-700 dark:text-slate-400 mb-4">
                                        Upload multiple customers using the CSV template. The template includes fields for: 
                                        <strong>First Name, Last Name, Middle Name, Email, Phone, NIN, Address, Landmark, Next of Kin details</strong>.
                                    </p>

                                    <form method="POST" action="{{ route('customers.bulk-customer-upload') }}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="grid grid-cols-1 gap-6">
                                            <div>
                                                <label for="customer_file" class="text-gray-800 dark:text-gray-300 text-sm font-medium inline-block mb-2">
                                                    Upload CSV File *
                                                </label>
                                                <input 
                                                    type="file" 
                                                    name="customer_file" 
                                                    class="form-input" 
                                                    id="customer_file" 
                                                    accept=".csv,.txt"
                                                    required
                                                    :disabled="bulkFormSubmitting"
                                                >
                                                <p class="text-xs text-gray-500 mt-1">Only CSV files are allowed. Maximum file size: 5MB</p>
                                            </div>

                                            <div class="flex gap-4">
                                                <button 
                                                    type="submit" 
                                                    class="btn bg-primary text-white flex items-center gap-2 min-w-[140px] justify-center"
                                                    :disabled="bulkFormSubmitting"
                                                    :class="{ 'opacity-75 cursor-not-allowed': bulkFormSubmitting }"
                                                >
                                                    <div x-show="bulkFormSubmitting" class="animate-spin rounded-full h-4 w-4 border-b-2 border-white"></div>
                                                    <i x-show="!bulkFormSubmitting" class="mgc_upload_line text-lg"></i>
                                                    <span x-text="bulkFormSubmitting ? 'Uploading...' : 'Upload CSV'"></span>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
            </main>

    @include('layouts.footer')

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('onboardCustomers', () => ({
                singleFormSubmitting: false,
                bulkFormSubmitting: false,
                formData: {
                    fname: '',
                    mname: '',
                    lname: '',
                    email: '',
                    phone_number: '',
                    nin: '',
                    address: '',
                    land_mark: '',
                    nok_name: '',
                    nok_phone: '',
                    nok_address: ''
                },

                resetSingleForm() {
                    this.formData = {
                        fname: '',
                        mname: '',
                        lname: '',
                        email: '',
                        phone_number: '',
                        nin: '',
                        address: '',
                        land_mark: '',
                        nok_name: '',
                        nok_phone: '',
                        nok_address: ''
                    };
                    
                    // Reset file inputs
                    document.getElementById('display_picture').value = '';
                },

                init() {
                    // Reset loading states when page loads (in case of validation errors)
                    this.singleFormSubmitting = false;
                    this.bulkFormSubmitting = false;
                }
                // handleBulkSubmit(event) {
                //     this.bulkFormSubmitting = true;
                //     setTimeout(() => {
                //         event.target.submit();
                //     }, 100);
                // }
            }));
        });

        // Additional form validation and user feedback
        document.addEventListener('DOMContentLoaded', function() {
            // Add some basic client-side validation feedback
            const ninInput = document.getElementById('nin');
            if (ninInput) {
                ninInput.addEventListener('input', function(e) {
                    // Remove non-numeric characters
                    this.value = this.value.replace(/\D/g, '');
                    
                    // Limit to 11 characters
                    if (this.value.length > 11) {
                        this.value = this.value.slice(0, 11);
                    }
                });
            }

            // Phone number formatting (basic)
            const phoneInputs = document.querySelectorAll('input[type="tel"]');
            phoneInputs.forEach(input => {
                input.addEventListener('input', function(e) {
                    // Basic phone number validation can be added here
                    let value = this.value.replace(/\D/g, '');
                    if (value.startsWith('234')) {
                        // Nigerian format
                        this.value = '+' + value;
                    } else if (value.startsWith('0')) {
                        // Convert local to international
                        this.value = '+234' + value.slice(1);
                    }
                });
            });
        });
    </script>

    <style>
        /* Custom spinner animation */
        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }
        
        .animate-spin {
            animation: spin 1s linear infinite;
        }

        /* Form sections styling */
        .form-input:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        /* Button hover effects */
        .btn:hover:not(:disabled) {
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn:disabled {
            transform: none;
            box-shadow: none;
        }
    </style>
</x-app-layout>