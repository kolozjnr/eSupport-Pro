<x-app-layout>

    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->
  <!-- Gridjs Plugin css -->
{{-- <link href="{{ asset('assets/libs/gridjs/theme/mermaid.min.css') }}" rel="stylesheet" type="text/css" > --}}

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <div class="page-content">
        @include('../layouts.top-header')
        <style>
            /* Modal Styles */
            
        /* Modal Styles */
       .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.3);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }

        .modal-content {
        background-color: white;
        padding: 20px;
        border-radius: 10px;
        width: 700px;
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
                  <div class="modal-content bg-white dark:bg-gray-800 rounded-lg p-6 w-full max-w-md mx-auto relative shadow-lg text-gray-800 dark:text-gray-200">
                      <form action="">
                        <span id="closeModal" class="close absolute top-3 right-4 text-2xl cursor-pointer text-gray-500 hover:text-red-500">&times;</span>

                        <h2 class="text-xl font-semibold mb-4 text-center">Create Ticket</h2>
                        <div class="mb-4">
                            <label for="description" class="sr-only">Description</label>
                            <input type="text" class="form-input" id="description"                                                 x-model="ticket.description" placeholder="Description">
                          </div>
                        
                        <button id="confirmPayment" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
                            Send
                        </button>
                      </form>
                  </div>
              </div>

                <!-- Page Title Start -->
                <div class="flex justify-between items-center mb-6">
                    <h4 class="text-slate-900 dark:text-slate-200 text-lg font-medium">Data Table</h4>

                    <div class="md:flex hidden items-center gap-2.5 text-sm font-semibold">
                        <div class="flex items-center gap-2">
                            <a href="#" class="text-sm font-medium text-slate-700 dark:text-slate-400">eSupport</a>
                        </div>

                        <div class="flex items-center gap-2">
                            <i class="mgc_right_line text-lg flex-shrink-0 text-slate-400 rtl:rotate-180"></i>
                            <a href="#" class="text-sm font-medium text-slate-700 dark:text-slate-400">View Drafts</a>
                        </div>

                        <div class="flex items-center gap-2">
                            <i class="mgc_right_line text-lg flex-shrink-0 text-slate-400 rtl:rotate-180"></i>
                            <a href="#" class="text-sm font-medium text-slate-700 dark:text-slate-400" aria-current="page">Drafts</a>
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

                            <div id="all-drafts-table"></div>
                        </div>
                    </div>


                </div>

            </main>

            
   <script src="{{ asset('assets/libs/gridjs/gridjs.umd.js') }}" defer></script>
     
         <!-- Gridjs Demo js -->
         <script src="{{ asset('assets/js/pages/table-gridjs.js') }}" defer></script>
    @include('layouts.footer')

    <script>
    //   document.addEventListener('alpine:init', () => {
    //     Alpine.data('draftTable', () => ({
    //         grid: null,
    //         drafts: [],
    //         isLoading: true,

    //         async fetchDrafts() {
    //             try {
    //                 const response = await fetch('{{ route("tickets.data-drafts") }}', {
    //                     method: 'GET',
    //                     headers: {
    //                         'Accept': 'application/json',
    //                         'X-Requested-With': 'XMLHttpRequest'
    //                     }
    //                 });
                    
    //                 if (!response.ok) {
    //                     throw new Error('Failed to fetch drafts');
    //                 }
                    
    //                 this.drafts = await response.json();
    //                 this.initializeGrid();
    //             } catch (error) {
    //                 console.error('Error fetching drafts:', error);
    //                 // You might want to show an error message to the user
    //             } finally {
    //                 this.isLoading = false;
    //             }
    //         },

    //         initializeGrid() {
    //             if (this.grid) {
    //                 this.grid.updateConfig({
    //                     data: this.formatData(this.drafts)
    //                 }).forceRender();
    //                 return;
    //             }

    //             this.grid = new gridjs.Grid({
    //                 columns: [
    //                     {
    //                         name: 'ID',
    //                         formatter: (cell) => gridjs.html(`<span class="fw-semibold">${cell}</span>`)
    //                     },
    //                     "Name", 
    //                     "Phone Number",
    //                     {
    //                         name: 'Actions',
    //                         width: '120px',
    //                         formatter: (cell, row) => gridjs.html(`
    //                             <div class="flex items-center">
    //                                 <a href="/tickets/${row.cells[0].data}/show" class="text-primary me-2">
    //                                     <i class="mgc_view_line text-xl"></i>
    //                                 </a>
    //                                 <a href="/tickets/${row.cells[0].data}/edit" class="text-warning me-2">
    //                                     <i class="mgc_edit_line text-lg"></i>
    //                                 </a>
    //                                 <a href="javascript:void(0);" @click="deleteDraft(${row.cells[0].data})" class="text-danger">
    //                                     <i class="mgc_delete_line text-xl"></i>
    //                                 </a>
    //                             </div>
    //                         `)
    //                     }
    //                 ],
    //                 pagination: {
    //                     limit: 5
    //                 },
    //                 sort: true,
    //                 search: true,
    //                 data: this.formatData(this.drafts)
    //             }).render(document.getElementById("all-drafts-table"));
    //         },

    //         formatData(drafts) {
    //             return drafts.map(draft => [
    //                 draft.id,
    //                 draft.name,
    //                 draft.phone_numbers.map(pn => pn.number).join(', '),
    //                 '' // Actions column will be handled by the formatter
    //             ]);
    //         },

    //         async deleteDraft(id) {
    //             if (!confirm('Are you sure you want to delete this draft?')) return;
                
    //             try {
    //                 const response = await fetch(`/drafts/${id}`, {
    //                     method: 'DELETE',
    //                     headers: {
    //                         'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
    //                         'Accept': 'application/json'
    //                     }
    //                 });
                    
    //                 if (response.ok) {
    //                     this.drafts = this.drafts.filter(draft => draft.id !== id);
    //                     this.grid.updateConfig({
    //                         data: this.formatData(this.drafts)
    //                     }).forceRender();
    //                 } else {
    //                     throw new Error('Failed to delete draft');
    //                 }
    //             } catch (error) {
    //                 console.error('Error deleting draft:', error);
    //                 alert('Error deleting draft');
    //             }
    //         }
    //     }));
    // });


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


        // Raatings Js starts

        $(".rating-component .star").on("mouseover", function () {
          //alert()
    var onStar = parseInt($(this).data("value"), 10); //
    $(this).parent().children("i.star").each(function (e) {
      if (e < onStar) {
        $(this).addClass("hover");
      } else {
        $(this).removeClass("hover");
      }
    });
  }).on("mouseout", function () {
    $(this).parent().children("i.star").each(function (e) {
      $(this).removeClass("hover");
    });
  });

  $(".rating-component .stars-box .star").on("click", function () {
    var onStar = parseInt($(this).data("value"), 10);
    var stars = $(this).parent().children("i.star");
    var ratingMessage = $(this).data("message");

    var msg = "";
    if (onStar > 1) {
      msg = onStar;
    } else {
      msg = onStar;
    }
    $('.rating-component .starrate .ratevalue').val(msg);
    

  
    $(".fa-smile-wink").show();
    
    $(".button-box .done").show();

    if (onStar === 5) {
      $(".button-box .done").removeAttr("disabled");
    } else {
      $(".button-box .done").attr("disabled", "true");
    }

    for (i = 0; i < stars.length; i++) {
      $(stars[i]).removeClass("selected");
    }

    for (i = 0; i < onStar; i++) {
      $(stars[i]).addClass("selected");
    }

    $(".status-msg .rating_msg").val(ratingMessage);
    $(".status-msg").html(ratingMessage);
    $("[data-tag-set]").hide();
    $("[data-tag-set=" + onStar + "]").show();
  });

  $(".feedback-tags  ").on("click", function () {
    var choosedTagsLength = $(this).parent("div.tags-box").find("input").length;
    choosedTagsLength = choosedTagsLength + 1;

    if ($(this).hasClass("choosed")) {
      $(this).removeClass("choosed");
      choosedTagsLength = choosedTagsLength - 2;
    } else {
      $(this).addClass("choosed");
      $(".button-box .done").removeAttr("disabled");
    }

    console.log(choosedTagsLength);

    if (choosedTagsLength <= 0) {
      $(".button-box .done").attr("enabled", "false");
    }
  });



  $(".compliment-container .fa-smile-wink").on("click", function () {
    $(this).fadeOut("slow", function () {
      $(".list-of-compliment").fadeIn();
    });
  });



  $(".done").on("click", function () {
    $(".rating-component").hide();
    $(".feedback-tags").hide();
    $(".button-box").hide();
    $(".submited-box").show();
    $(".submited-box .loader").show();

    setTimeout(function () {
      $(".submited-box .loader").hide();
      $(".submited-box .success-message").show();
    }, 1500);
  });

    </script>
   
</x-app-layout>