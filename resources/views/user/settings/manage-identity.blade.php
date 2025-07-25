<x-app-layout>

    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->
    
    <link href="{{ asset('assets/libs/gridjs/theme/mermaid.min.css')}}" rel="stylesheet" type="text/css" >
    <div class="page-content">
        @include('../layouts.top-header')
        <main class="flex-grow p-6">

    

                <!-- Page Title Start -->
                <div class="flex justify-between items-center mb-6">
                    <h4 class="text-slate-900 dark:text-slate-200 text-lg font-medium">Layout</h4>

                    <div class="md:flex hidden items-center gap-2.5 text-sm font-semibold">
                        <div class="flex items-center gap-2">
                            <a href="#" class="text-sm font-medium text-slate-700 dark:text-slate-400">eSupport</a>
                        </div>

                        <div class="flex items-center gap-2">
                            <i class="mgc_right_line text-lg flex-shrink-0 text-slate-400 rtl:rotate-180"></i>
                            <a href="#" class="text-sm font-medium text-slate-700 dark:text-slate-400">Users</a>
                        </div>

                        <div class="flex items-center gap-2">
                            <i class="mgc_right_line text-lg flex-shrink-0 text-slate-400 rtl:rotate-180"></i>
                            <a href="#" class="text-sm font-medium text-slate-700 dark:text-slate-400" aria-current="page">Create User</a>
                        </div>
                    </div>
                </div>
                <!-- Page Title End -->

                <div class="grid lg:grid-cols-2 grid-cols-1 gap-6">


                    <div class="col-span-2">
                        <div class="card">
                            <div class="card-header">
                                <div class="flex justify-between items-center">
                                    <h4 class="card-title">User Creation Form</h4>
                                    
                                </div>
                            </div>
                            <div x-data="updateIdentity()" class="p-6">
                                <form method="POST" action="{{ route('support.update-identity') }}"
                                         x-on:submit="isSubmitting = true">
                                         @csrf
                                         
                                    <div class="grid grid-cols-4 gap-2 mb-6">
                                        <div class="">
                                            <label for="support_staff" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Support Staffs</label>
                                            <select id="search-select" x-model="formData.support_staff" @change="getSupportStaff(formData.support_staff)" name="support_staff" id="support_staff" class="search-select">
                                                <option selected>Choose</option>
                                                @foreach ($supports as $support)
                                                <option value="{{ $support->id }}">{{ $support->user->fname }} {{ $support->user->lname }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-4 gap-4 mb-6" x-show="showSupportStaff">
                                        <div>
                                            <label for="mname" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Current Identities</label>
                                            <input type="text" class="form-input" x-model="formData.current_identities" name="current_identities" id="current_identities" readonly>
                                            <p class="text-sm text-gray-500 mt-1" x-text="'Current identities: ' + formData.current_identity_count + '/' + maxIdentities"></p>
                                            <p class="text-sm text-red-500 mt-1" x-show="formData.current_identity_count >= maxIdentities">
                                                Maximum identities reached. Please update existing identities.
                                            </p>
                                        </div>
                                    </div>
                                    
                                    <!-- Identity Fields Section -->
                                    <div class="mb-6">
                                        <template x-for="(identity, index) in identities" :key="index">
                                            <div class="grid grid-cols-4 gap-2 mb-2 items-end">
                                                <div>
                                                    <label :for="'inputidentity_' + index" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Identity</label>
                                                    {{-- <input type="text" class="form-input" x-model="identity.name" :id="'inputidentity_' + index" placeholder="Enter identity"> --}}
                                                    <input type="text" class="form-input" x-model="identity.name" :name="'identities[]'" :id="'inputidentity_' + index" placeholder="Enter identity">

                                                </div>
                                                <div>
                                                    <button type="button" 
                                                            @click="removeIdentity(index)"
                                                            class="btn bg-red-500 text-white px-3 py-2"
                                                            x-show="identities.length > 1">
                                                        Remove
                                                    </button>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                    
                                    <div class="flex gap-4 mt-4">
                                        <span>
                                            <button type="button" 
                                                @click="addIdentity()"
                                                class="btn bg-blue-500 text-white flex items-center"
                                                :disabled="!canAddMoreIdentities()"
                                                :class="{ 'opacity-50 cursor-not-allowed': !canAddMoreIdentities() }">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                            </svg>
                                            Add Identity
                                        </button>
                                        </span>
                                        {{-- <button type="submit"
                                                :disabled="isSubmitting"
                                                class="btn bg-primary text-white flex items-center"
                                                :class="{ 'opacity-50 cursor-not-allowed': isSubmitting }">
                                            <span x-show="!isSubmitting">Submit</span>
                                            <span x-show="isSubmitting">Submitting...</span>
                                        </button> --}}

                                         <button type="submit" class="btn bg-primary text-white w-40" :disabled="isSubmitting">
                                            <span x-show="!isSubmitting">Submit</span>
                                            <span x-show="isSubmitting">Submitting...</span>
                                        </button>
                                        {{-- <button type="submit" class="btn bg-primary text-white">Submit</button> --}}
                                    </div>
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                </form>
                            </div>
                        </div> <!-- end card -->
                    </div> <!-- end col -->
                </div>
            </main>

        <script src="{{ asset('assets/libs/nice-select2/js/nice-select2.js') }}" defer></script>
         <!-- Choices Demo js -->
         <script src="{{ asset('assets/js/pages/form-select.js') }}" defer></script> 

            <script>
                document.addEventListener('alpine:init', () => {
                    Alpine.data('updateIdentity', () => ({
                        isSubmitting: false,
                        formData: {
                            support_staff: '',
                            current_identities: '',
                            current_identity_count: 0
                        },
                        identities: [],
                        showSupportStaff: false,
                        maxIdentities: 3,
                        
                        init() {
                            // Initialize with one empty identity field if needed
                            if (this.identities.length === 0) {
                                this.identities.push({ name: '' });
                            }
                        },
                        
                        async getSupportStaff(supportId) {
                            if (!supportId) return;
                            
                            try {
                                const response = await fetch(`/dashboard/support/get-support-identity/${supportId}`);
                                const data = await response.json();
                                console.log('Identities:', data);
                                
                                this.formData.current_identities = data.map(i => i.name).join(', ');
                                this.formData.current_identity_count = data.length;
                                this.showSupportStaff = true;
                                
                                // Reset identities array
                                this.identities = [];
                                
                                // If we have less than 3 identities, allow adding more
                                if (data.length < this.maxIdentities) {
                                    // Add existing identities to the form
                                    data.forEach(identity => {
                                        this.identities.push({ name: identity.name });
                                    });
                                    
                                    // Add one empty field if we have space
                                    if (data.length < this.maxIdentities) {
                                        this.identities.push({ name: '' });
                                    }
                                }
                            } catch (error) {
                                console.error('Error fetching identities:', error);
                            }
                        },
                        
                        addIdentity() {
                            // Only allow adding if we're under the limit and have space left
                            const totalIdentities = this.formData.current_identity_count + this.identities.length;
                            if (totalIdentities < this.maxIdentities) {
                                this.identities.push({ name: '' });
                            } else {
                                alert(`Maximum of ${this.maxIdentities} identities allowed. Please update existing ones.`);
                            }
                        },
                        
                        removeIdentity(index) {
                            if (this.identities.length > 1) {
                                this.identities.splice(index, 1);
                            }
                        },
                        
                        canAddMoreIdentities() {
                            const totalIdentities = this.formData.current_identity_count + this.identities.length;
                            return totalIdentities < this.maxIdentities;
                        }
                    }));
                });
                
            </script>
    @include('layouts.footer')
</x-app-layout>