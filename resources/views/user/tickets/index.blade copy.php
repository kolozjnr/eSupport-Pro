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

            /*Ratings css start here  */
            /* .wrapper {
  margin: 0 auto;
  max-width: 960px;
  width: 100%;
} */

.master {
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-orient: vertical;
  -webkit-box-direction: normal;
  -ms-flex-direction: column;
  flex-direction: column;
  -webkit-box-pack: start;
  -ms-flex-pack: start;
  justify-content: flex-start;
  -webkit-box-align: center;
  -ms-flex-align: center;
  align-items: center;
  padding-top: 40px;
}

h1 {
  font-size: 20px;
  margin-bottom: 20px;
}

h2 {
  line-height: 160%;
  margin-bottom: 20px;
  text-align: center;
}

.rating-component {
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-orient: vertical;
  -webkit-box-direction: normal;
  -ms-flex-direction: column;
  flex-direction: column;
  -webkit-box-pack: center;
  -ms-flex-pack: center;
  justify-content: center;
  margin-bottom: 10px;
}

.rating-component .status-msg {
  margin-bottom: 10px;
  text-align: center;
}

.rating-component .status-msg strong {
  display: block;
  font-weight: bold;
  margin-bottom: 10px;
}

.rating-component .stars-box {
  -ms-flex-item-align: center;
  align-self: center;
  margin-bottom: 15px;
}

.rating-component .stars-box .star {
  color: #ccc;
  cursor: pointer;
}

.rating-component .stars-box .star.hover {
  color: #ff5a49;
}

.rating-component .stars-box .star.selected {
  color: #ff5a49;
}

.feedback-tags {
  min-height: 119px;
}

.feedback-tags .tags-container {
  display: none;
}

.feedback-tags .tags-container .question-tag {
  text-align: center;
  margin-bottom: 40px;
}

.feedback-tags .tags-box {
  display: -webkit-box;
  display: -ms-flexbox;
  text-align: center;
  display: flex;
  -webkit-box-pack: center;
  -ms-flex-pack: center;
  justify-content: center;
  -webkit-box-orient: horizontal;
  -webkit-box-direction: normal;
  -ms-flex-direction: row;
  flex-direction: row;
  -ms-flex-wrap: wrap;
  flex-wrap: wrap;
}

.feedback-tags .tags-container .make-compliment {
  padding-bottom: 20px;
}

.feedback-tags .tags-container .make-compliment .compliment-container {
  -webkit-box-align: center;
  -ms-flex-align: center;
  align-items: center;
  color: #000;
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-orient: vertical;
  -webkit-box-direction: normal;
  -ms-flex-direction: column;
  flex-direction: column;
  -webkit-box-pack: center;
  -ms-flex-pack: center;
  justify-content: center;
}

.feedback-tags
  .tags-container
  .make-compliment
  .compliment-container
  .fa-smile-wink {
  color: #ff5a49;
  cursor: pointer;
  font-size: 40px;
  margin-top: 15px;
  -webkit-animation-name: compliment;
  animation-name: compliment;
  -webkit-animation-duration: 2s;
  animation-duration: 2s;
  -webkit-animation-iteration-count: 1;
  animation-iteration-count: 1;
}

.feedback-tags
  .tags-container
  .make-compliment
  .compliment-container
  .list-of-compliment {
  display: none;
  margin-top: 15px;
}

.feedback-tags .tag {
  /* border: 1px solid #ff5a49; */
  border-radius: 5px;
  /* color: #ff5a49; */
  cursor: pointer;
  margin-bottom: 10px;
  margin-left: 10px;
  padding: 10px;
}

.feedback-tags .tag.choosed {
  background-color: #060606;
  color: #fff;
}

.list-of-compliment ul {
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-orient: horizontal;
  -webkit-box-direction: normal;
  -ms-flex-direction: row;
  flex-direction: row;
  -ms-flex-wrap: wrap;
  flex-wrap: wrap;
  -webkit-box-pack: center;
  -ms-flex-pack: center;
  justify-content: center;
}

.list-of-compliment ul li {
  -webkit-box-align: center;
  -ms-flex-align: center;
  align-items: center;
  cursor: pointer;
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-orient: vertical;
  -webkit-box-direction: normal;
  -ms-flex-direction: column;
  flex-direction: column;
  -webkit-box-pack: center;
  -ms-flex-pack: center;
  justify-content: center;
  margin-bottom: 10px;
  margin-left: 20px;
  min-width: 90px;
}

.list-of-compliment ul li:first-child {
  margin-left: 0;
}

.list-of-compliment ul li .icon-compliment {
  -webkit-box-align: center;
  -ms-flex-align: center;
  align-items: center;
  border: 2px solid #ff5a49;
  border-radius: 50%;
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-orient: vertical;
  -webkit-box-direction: normal;
  -ms-flex-direction: column;
  flex-direction: column;
  -webkit-box-pack: center;
  -ms-flex-pack: center;
  justify-content: center;
  height: 70px;
  margin-bottom: 15px;
  overflow: hidden;
  padding: 0 10px;
  -webkit-transition: 0.5s;
  transition: 0.5s;
  width: 70px;
}

.list-of-compliment ul li .icon-compliment i {
  color: #ff5a49;
  font-size: 30px;
  -webkit-transition: 0.5s;
  transition: 0.5s;
}

.list-of-compliment ul li.actived .icon-compliment {
  background-color: #ff5a49;
  -webkit-transition: 0.5s;
  transition: 0.5s;
}

.list-of-compliment ul li.actived .icon-compliment i {
  color: #fff;
  -webkit-transition: 0.5s;
  transition: 0.5s;
}

.button-box .done {
  background-color: #289b5a;
  border: 1px solid #d4cdcd;
  border-radius: 3px;
  color: #fff;
  cursor: pointer;
  display: none;
  min-width: 100px;
  padding: 10px;
}

.button-box .done:disabled,
.button-box .done[disabled] {
  /* border: 1px solid #ff9b95;
  background-color: #ff9b95; */
  color: #fff;
  cursor: initial;
}

.submited-box {
  display: none;
  padding: 20px;
}

.submited-box .loader,
.submited-box .success-message {
  display: none;
}

.submited-box .loader {
  border: 5px solid transparent;
  border-top: 5px solid #4dc7b7;
  border-bottom: 5px solid #ff5a49;
  border-radius: 50%;
  width: 60px;
  height: 60px;
  -webkit-animation: spin 0.8s linear infinite;
  animation: spin 0.8s linear infinite;
}

@-webkit-keyframes compliment {
  1% {
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
  }

  25% {
    -webkit-transform: rotate(-30deg);
    transform: rotate(-30deg);
  }

  50% {
    -webkit-transform: rotate(30deg);
    transform: rotate(30deg);
  }

  75% {
    -webkit-transform: rotate(-30deg);
    transform: rotate(-30deg);
  }

  100% {
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
  }
}

@keyframes compliment {
  1% {
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
  }

  25% {
    -webkit-transform: rotate(-30deg);
    transform: rotate(-30deg);
  }

  50% {
    -webkit-transform: rotate(30deg);
    transform: rotate(30deg);
  }

  75% {
    -webkit-transform: rotate(-30deg);
    transform: rotate(-30deg);
  }

  100% {
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
  }
}

@-webkit-keyframes spin {
  0% {
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
  }

  100% {
    -webkit-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}

@keyframes spin {
  0% {
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
  }

  100% {
    -webkit-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}

        </style>
    <!-- Modal -->
                <div id="modal" class="modal">
                    <div class="modal-content">
                    <span id="closeModal" class="close">&times;</span>
                    <div class="wrapper">
                    <div class="master">
                        <h1>Review And rating</h1>
                        <h2>How was your experience with this customer?</h2>

                        <div class="rating-component">
                        <div class="status-msg">
                            <label>
                                            <input  class="rating_msg" type="hidden" name="rating_msg" value=""/>
                                        </label>
                        </div>
                        <div class="stars-box">
                            <i class="star fa fa-star" title="1 star" data-message="Poor" data-value="1"></i>
                            <i class="star fa fa-star" title="2 stars" data-message="Too bad" data-value="2"></i>
                            <i class="star fa fa-star" title="3 stars" data-message="Average quality" data-value="3"></i>
                            <i class="star fa fa-star" title="4 stars" data-message="Nice" data-value="4"></i>
                            <i class="star fa fa-star" title="5 stars" data-message="very good qality" data-value="5"></i>
                        </div>
                        <div class="starrate">
                            <label>
                                            <input  class="ratevalue" type="hidden" name="rate_value" value=""/>
                                        </label>
                        </div>
                        </div>

                        <div class="feedback-tags">
                        <div class="tags-container" data-tag-set="1">
                            <div class="question-tag">
                            Why was your experience so bad?
                            </div>
                        </div>
                        <div class="tags-container" data-tag-set="2">
                            <div class="question-tag">
                            Why was your experience so bad?
                            </div>

                        </div>

                        <div class="tags-container" data-tag-set="3">
                            <div class="question-tag">
                            Why was your average rating experience ?
                            </div>
                        </div>
                        <div class="tags-container" data-tag-set="4">
                            <div class="question-tag">
                            Why was your experience good?
                            </div>
                        </div>

                        <div class="tags-container" data-tag-set="5">
                            <div class="make-compliment">
                            <div class="compliment-container">
                                Give a compliment
                                <i class="far fa-smile-wink"></i>
                            </div>
                            </div>
                        </div>
                        
                        <div class="tags-box">
                            <input type="text" class="tag form-control" name="comment" id="inlineFormInputName" placeholder="Comment">
                            <input type="hidden" name="product_id" value="1" />
                        </div>
                        
                        </div>

                        <div class="button-box">
                        <input type="submit" class=" done btn bg-blue-500 text-white flex items-center justify-center" disabled="disabled" value="Add review" />
                        </div>

                        <div class="submited-box">
                        <div class="loader"></div>
                        <div class="success-message">
                            Thank you!
                        </div>
                        </div>
                    </div>

                    </div>
                    </div>
                </div>
   
                   


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
                            {{-- <p class="text-sm text-slate-700 dark:text-slate-400 mb-4">The most basic list group is an unordered list with list items and the proper classes. Build upon it with the options that follow, or with your own CSS as needed.</p> --}}

                            <div id="customer-tickets-table"></div>
                        </div>
                    </div>


                </div>

            </main>

            
            
   <script src="{{ asset('assets/libs/gridjs/gridjs.umd.js') }}" defer></script>
     
         <!-- Gridjs Demo js -->
         <script src="{{ asset('assets/js/pages/table-gridjs.js') }}" defer></script>
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

        
        function openModal(id) {
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