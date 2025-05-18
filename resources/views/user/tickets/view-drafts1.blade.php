<x-app-layout>

    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <div class="page-content">
        @include('../layouts.top-header')
        <style>
            /* Modal Styles */
            .modal {
            display: none; /* Hidden by default */
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            z-index: 9999;
            }

            .modal-content {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            width: 300px;
            text-align: center;
            position: relative;
            transform: scale(0); /* Start small */
            animation: blowUp 0.3s ease-out forwards; /* Animation for opening */
            }

            /* Close Button */
            .close {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 24px;
            cursor: pointer;
            }

            /* Keyframes for Blow Up Animation */
            @keyframes blowUp {
            from {
                transform: scale(0);
            }
            to {
                transform: scale(1);
            }
            }

            /* Keyframes for Go Back Animation */
            @keyframes goBack {
            from {
                transform: scale(1);
            }
            to {
                transform: scale(0);
            }
            }

        </style>

   
                   


            <main class="flex-grow p-6"> 
                 <!-- Modal -->
                <div id="modal" class="modal">
                    <div class="modal-content">
                    <span id="closeModal" class="close">&times;</span>
                    <div class="wrapper">
                    <div class="master">
                    
                    </div>
                    </div>
                </div>

                <!-- Page Title Start -->
                <div class="flex justify-between items-center mb-6">
                    <h4 class="text-slate-900 dark:text-slate-200 text-lg font-medium">View Draft</h4>

                    <div class="md:flex hidden items-center gap-2.5 text-sm font-semibold">
                        <div class="flex items-center gap-2">
                            <a href="#" class="text-sm font-medium text-slate-700 dark:text-slate-400">eSupport</a>
                        </div>

                        <div class="flex items-center gap-2">
                            <i class="mgc_right_line text-lg flex-shrink-0 text-slate-400 rtl:rotate-180"></i>
                            <a href="#" class="text-sm font-medium text-slate-700 dark:text-slate-400">Draft</a>
                        </div>

                        <div class="flex items-center gap-2">
                            <i class="mgc_right_line text-lg flex-shrink-0 text-slate-400 rtl:rotate-180"></i>
                            <a href="#" class="text-sm font-medium text-slate-700 dark:text-slate-400" aria-current="page">All Draft</a>
                        </div>
                    </div>
                </div>
                <!-- Page Title End -->

                <div class="flex flex-col gap-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="flex justify-between items-center">
                                <h4 class="card-title">All Drafts</h4>
                            </div>
                        </div>
                        <div class="p-6">
                            {{-- <p class="text-sm text-slate-700 dark:text-slate-400 mb-4">The most basic list group is an unordered list with list items and the proper classes. Build upon it with the options that follow, or with your own CSS as needed.</p> --}}

                            <div id="drafts"></div>
                        </div>
                    </div>


                </div>

            </main>

            

    @include('layouts.footer')

    <script>
        // script.js
        const openModalButton = document.getElementById("openModal");
        const closeModalButton = document.getElementById("closeModal");
        const modal = document.getElementById("modal");

        // Open Modal
        // openModalButton.addEventListener("click", () => {
        // modal.style.display = "flex"; // Show the modal
        // const modalContent = modal.querySelector(".modal-content");
        // modalContent.style.animation = "blowUp 0.3s ease-out forwards"; // Blow up animation
        // });

        // Close Modal
        closeModalButton.addEventListener("click", () => {
        const modalContent = modal.querySelector(".modal-content");
        modalContent.style.animation = "goBack 0.3s ease-out forwards"; // Go back animation

        // Hide the modal after the animation completes
        setTimeout(() => {
            modal.style.display = "none";
        }, 300); // Match the duration of the animation
        });

        
        function openModal() {
            //alert("Modal opened!");
            modal.style.display = "flex";
            const modalContent = modal.querySelector(".modal-content");
            modalContent.style.animation = "blowUp 0.3s ease-out forwards"; 
        }
    </script>
</x-app-layout>