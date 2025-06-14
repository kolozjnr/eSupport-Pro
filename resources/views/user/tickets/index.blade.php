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
                    <h4 class="text-slate-900 dark:text-slate-200 text-lg font-medium">Data Table</h4>

                    <div class="md:flex hidden items-center gap-2.5 text-sm font-semibold">
                        <div class="flex items-center gap-2">
                            <a href="#" class="text-sm font-medium text-slate-700 dark:text-slate-400">eSupport</a>
                        </div>

                        <div class="flex items-center gap-2">
                            <i class="mgc_right_line text-lg flex-shrink-0 text-slate-400 rtl:rotate-180"></i>
                            <a href="#" class="text-sm font-medium text-slate-700 dark:text-slate-400">Task</a>
                        </div>

                        <div class="flex items-center gap-2">
                            <i class="mgc_right_line text-lg flex-shrink-0 text-slate-400 rtl:rotate-180"></i>
                            <a href="#" class="text-sm font-medium text-slate-700 dark:text-slate-400" aria-current="page">Task</a>
                        </div>
                    </div>
                </div>
                <!-- Page Title End -->

                <div class="flex flex-col gap-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="flex justify-between items-center">
                                <h4 class="card-title">Basic</h4>
                            </div>
                        </div>
                        <div class="p-6">
                          <div id="loading-indicator" class="hidden fixed inset-0 bg-white dark:bg-slate-900 bg-opacity-75 flex items-center justify-center z-50">
                            <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-primary"></div>
                          </div>
                            <div id="bulk-actions-container" class="mb-3"></div>
                            {{-- <p class="text-sm text-slate-700 dark:text-slate-400 mb-4">The most basic list group is an unordered list with list items and the proper classes. Build upon it with the options that follow, or with your own CSS as needed.</p> --}}
                            @if(auth()->user()->hasRole('customer'))
                            <div id="customer-tickets-table"></div>
                            @elseif(auth()->user()->hasRole('qualitycontrol'))
                            <div id="quality-control-tickets"></div>
                            @elseif(auth()->user()->role == 'support')
                            <div id="support-tickets-table"></div>
                            
                            @endif
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

         <script>
    document.addEventListener('alpine:init', () => {
    Alpine.data('reviewModal', () => ({
        isOpen: false,
        isLoading: false,
        isSuccess: false,
        errorMessage: '',
        ticketId: null,
        rating: 0,
        review: '',
        errors: {
            rating: '',
            review: ''
        },
        
        selectedTickets: new Set(),
        
        open(ticketId) {
            this.resetState();
            this.ticketId = ticketId;
            this.isOpen = true;
            setTimeout(() => {
                const firstStar = document.querySelector('[aria-label="Rating"] button');
                if (firstStar) firstStar.focus();
            }, 100);
        },
        
        close() {
            this.isOpen = false;
            setTimeout(() => {
                if (!this.isOpen) {
                    this.resetState();
                }
            }, 300);
        },
        
        resetState() {
            this.rating = 0;
            this.review = '';
            this.isLoading = false;
            this.isSuccess = false;
            this.errorMessage = '';
            this.errors = { rating: '', review: '' };
        },
        
        validate() {
            let valid = true;
            this.errors = { rating: '', review: '' };
            
            if (this.rating <= 0) {
                this.errors.rating = 'Please select a rating';
                valid = false;
            }
            
            if (!this.review.trim()) {
                this.errors.review = 'Please write your review';
                valid = false;
            } else if (this.review.length < 10) {
                this.errors.review = 'Review must be at least 10 characters';
                valid = false;
            }
            
            return valid;
        },
        
        async submitReview() {
            if (!this.validate()) return;
            
            this.isLoading = true;
            this.isSuccess = false;
            this.errorMessage = '';
            
            try {
                const response = await fetch('/dashboard/tickets/post-review', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        ticket_id: this.ticketId,
                        rating: this.rating,
                        review: this.review
                    })
                });
                
                const data = await response.json();
                
                if (!response.ok) {
                    throw new Error(data.message || 'Failed to submit review');
                }
                
                this.isSuccess = true;
                this.rating = 0;
                this.review = '';
                
                setTimeout(() => {
                    this.close();
                    if (typeof initializeCustomerTicketsTable === 'function') {
                        initializeCustomerTicketsTable();
                    }
                }, 2000);
            } catch (error) {
                console.error('Error submitting review:', error);
                this.errorMessage = error.message || 'An error occurred while submitting your review. Please try again.';
            } finally {
                this.isLoading = false;
            }
        },

         selectedTickets: new Set(),
        
        toggleTicketSelection(ticketId) {
            if (this.selectedTickets.has(ticketId)) {
                this.selectedTickets.delete(ticketId);
            } else {
                this.selectedTickets.add(ticketId);
            }
            this.updateBulkActionButton();
        },
        
        updateBulkActionButton() {
            const bulkActionBtn = document.getElementById('bulk-action-btn');
            if (bulkActionBtn) {
                if (this.selectedTickets.size >= 2) {
                    bulkActionBtn.classList.remove('hidden');
                    bulkActionBtn.innerHTML = `
                        <i class="mgc_check_line me-1"></i> Update Selected (${this.selectedTickets.size})
                    `;
                } else {
                    bulkActionBtn.classList.add('hidden');
                }
            }
        },
        
        async updateSelectedTickets() {
            if (this.selectedTickets.size === 0) {
                alert('Please select at least one ticket');
                return;
            }
            
            if (!confirm(`Are you sure you want to update ${this.selectedTickets.size} selected tickets?`)) {
                return;
            }
            
            try {
                const response = await fetch('/api/tickets/bulk-update', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Authorization': 'Bearer ' + localStorage.getItem('auth_token')
                    },
                    body: JSON.stringify({
                        ticket_ids: Array.from(this.selectedTickets),
                        status: 'completed'
                    })
                });
                
                if (!response.ok) {
                    throw new Error('Failed to update tickets');
                }
                
                alert('Tickets updated successfully!');
                this.selectedTickets.clear();
                initializeQualityControlTicketsTable(); // Refresh table
            } catch (error) {
                console.error('Error:', error);
                alert('Failed to update tickets: ' + error.message);
            }
        },
        
    }));
    



    // Global functions for ticket selection// Global functions for ticket selection
window.selectedTickets = new Set();

window.toggleTicketSelection = function(ticketId) {
    if (window.selectedTickets.has(ticketId)) {
        window.selectedTickets.delete(ticketId);
    } else {
        window.selectedTickets.add(ticketId);
    }
    window.updateBulkActionButton();
}

window.updateBulkActionButton = function() {
    const bulkActionBtn = document.getElementById('bulk-action-btn');
    if (bulkActionBtn) {
        if (window.selectedTickets.size >= 1) {
            bulkActionBtn.classList.remove('hidden');
            bulkActionBtn.innerHTML = `
                <i class="mgc_check_line me-1"></i> 
                Assign Tickets (${window.selectedTickets.size})
            `;
        } else {
            bulkActionBtn.classList.add('hidden');
        }
    }
}

window.fetchSupportStaff = async function() {
    try {
        const response = await fetch('users/support', {
            headers: {
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + localStorage.getItem('auth_token')
            }
        });
        
        if (!response.ok) {
            throw new Error('Failed to fetch support staff');
        }
        
        return await response.json();
    } catch (error) {
        console.error('Error fetching support staff:', error);
        return [];
    }
}

window.showTailwindModal = function(modalHTML) {
    // Remove existing modal if any
    const existingModal = document.getElementById('bulkAssignModal');
    if (existingModal) existingModal.remove();
    
    // Create backdrop
    const backdrop = document.createElement('div');
    backdrop.id = 'bulkAssignBackdrop';
    backdrop.className = 'fixed inset-0 bg-black bg-opacity-50 z-40 transition-opacity';
    
    // Add modal to body
    document.body.insertAdjacentHTML('beforeend', modalHTML);
    document.body.appendChild(backdrop);
    
    // Show modal with animation
    setTimeout(() => {
        const modal = document.getElementById('bulkAssignModal');
        if (modal) {
            modal.classList.remove('opacity-0', 'translate-y-4');
            modal.classList.add('opacity-100', 'translate-y-0');
        }
        backdrop.classList.remove('opacity-0');
        backdrop.classList.add('opacity-50');
    }, 10);
    
    // Close modal when clicking backdrop
    backdrop.addEventListener('click', () => {
        window.hideTailwindModal();
    });
}

window.hideTailwindModal = function() {
    const modal = document.getElementById('bulkAssignModal');
    const backdrop = document.getElementById('bulkAssignBackdrop');
    
    if (modal) {
        modal.classList.remove('opacity-100', 'translate-y-0');
        modal.classList.add('opacity-0', 'translate-y-4');
    }
    
    if (backdrop) {
        backdrop.classList.remove('opacity-50');
        backdrop.classList.add('opacity-0');
    }
    
    // Remove elements after animation
    setTimeout(() => {
        if (modal) modal.remove();
        if (backdrop) backdrop.remove();
    }, 200);
}

window.updateSelectedTickets = async function() {
    const selectedIds = Array.from(window.selectedTickets);
    if (selectedIds.length === 0) {
        alert('Please select at least one ticket');
        return;
    }

    try {
        // Show loading state
        const bulkActionBtn = document.getElementById('bulk-action-btn');
        if (bulkActionBtn) {
            bulkActionBtn.disabled = true;
            bulkActionBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...';
        }

        // Fetch support staff before showing modal
        const supportStaff = await window.fetchSupportStaff();
        
        if (supportStaff.length === 0) {
            throw new Error('No support staff available');
        }

        console.log("support staffs", supportStaff)

        // Create modal HTML with Tailwind classes
        const modalHTML = `
            <div id="bulkAssignModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 opacity-0 translate-y-4 transition-all duration-200">
                <div class="relative w-full max-w-md bg-white dark:bg-gray-800 rounded-lg shadow-xl border border-gray-200 dark:border-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Assign ${selectedIds.length} Ticket(s)
                        </h3>
                        <button type="button" onclick="hideTailwindModal()" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">
                            <span class="sr-only">Close</span>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <!-- Modal body -->
                    <div class="p-4">
                        <form id="bulkUpdateForm">
                            <input type="hidden" name="ticket_ids" value="${selectedIds.join(',')}">
                            
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Support Staff</label>
                                <select name="staff_id" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white" required>
                                    <option value="">Select Support Staff</option>
                                    ${supportStaff.map(staff => `
                                        <option value="${staff.id}" class="dark:bg-gray-700">${staff.user.fname + ' '  + staff.user.lname}   (${staff.assigned_tickets_count})</option>
                                    `).join('')}
                                </select>
                            </div>
                            
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Assignment Notes</label>
                                <textarea name="notes" rows="3" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white" placeholder="Optional notes about this assignment"></textarea>
                            </div>
                        </form>
                    </div>
                    
                    <!-- Modal footer -->
                    <div class="flex items-center justify-end p-4 border-t border-gray-200 dark:border-gray-700">
                        <button type="button" onclick="hideTailwindModal()" class="mr-2 px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-600 rounded-md hover:bg-gray-200 dark:hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-indigo-400">
                            Cancel
                        </button>
                        <button type="button" onclick="submitBulkUpdate()" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-indigo-500 dark:hover:bg-indigo-600">
                            Assign Tickets
                        </button>
                    </div>
                </div>
            </div>
        `;
        
        // Show the modal
        window.showTailwindModal(modalHTML);
        
    } catch (error) {
        alert('Error: ' + error.message);
    } finally {
        // Reset button state
        const bulkActionBtn = document.getElementById('bulk-action-btn');
        if (bulkActionBtn) {
            bulkActionBtn.disabled = false;
            bulkActionBtn.innerHTML = `
                <i class="mgc_check_line me-1"></i> 
                Assign Tickets (${window.selectedTickets.size})
            `;
        }
    }
}

window.submitBulkUpdate = async function() {
    const form = document.getElementById('bulkUpdateForm');
    if (!form) {
        alert('Form not found');
        return;
    }

    const formData = new FormData(form);
    const staffId = formData.get('staff_id');
    if (!staffId) {
        alert('Please select a support staff member');
        return;
    }

    // Convert FormData to JSON
    const jsonData = {
        ticket_ids: formData.get('ticket_ids').split(',').map(id => parseInt(id)),
        staff_id: parseInt(staffId),
        notes: formData.get('notes') || ''
    };

    // Show loading state
    const submitBtn = document.querySelector('#bulkAssignModal button[onclick="submitBulkUpdate()"]');
    if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = `
            <span class="inline-block animate-spin rounded-full h-4 w-4 border-2 border-white border-r-transparent"></span>
            Assigning...
        `;
    }

    try {
        // Send request to server
        const response = await fetch('tickets/bulk-assign-ticket', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(jsonData)
        });
        
        if (!response.ok) {
            throw new Error(await response.text() || 'Failed to assign tickets');
        }

        // Close modal
        window.hideTailwindModal();

        // Show success message
        alert('Tickets assigned successfully!');
        
        // Refresh the table
        if (typeof initializeQualityControlTicketsTable === 'function') {
            initializeQualityControlTicketsTable();
        }

        // Clear selections
        window.selectedTickets.clear();
        window.updateBulkActionButton();

    } catch (error) {
        console.error(error.message);
        alert('Error: ' + error.message);
    } finally {
        // Reset button state
        const submitBtn = document.querySelector('#bulkAssignModal button[onclick="submitBulkUpdate()"]');
        if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.innerHTML = 'Assign Tickets';
        }
    }
}

// Initialize when page loads
document.addEventListener('DOMContentLoaded', function() {
    if (typeof initializeQualityControlTicketsTable === 'function') {
        initializeQualityControlTicketsTable();
    }
});
    
    // Make the open function globally available
    window.openReviewModal = function(ticketId) {
        const modalElement = document.querySelector('[x-data="reviewModal"]');
        if (modalElement) {
            const modal = Alpine.$data(modalElement);
            modal.open(ticketId);
        }
    };
});





         </script>
    @include('layouts.footer')

</x-app-layout>