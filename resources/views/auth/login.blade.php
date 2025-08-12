<x-guest-layout>
      <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- ====== Sign In Section Start -->
    <section
      class="wow fadeInUp pt-[120px] lg:pt-[240px]"
      data-wow-delay=".2s"
    >
      <div class="px-4 xl:container">
        <div
          class="border-b pb-20 dark:border-[#2E333D] lg:pb-[130px]"
        >
          <div class="-mx-4 flex flex-wrap">
            <div class="w-full px-4">
              <div
                class="mx-auto max-w-[920px] rounded border bg-white py-10 px-6 dark:border-transparent dark:bg-[#1D232D] sm:p-[70px]"
              >
                <h3
                  class="mb-3 font-heading text-2xl font-medium text-black dark:text-white sm:text-3xl lg:text-2xl xl:text-[40px] xl:leading-tight"
                >
                  Sign in to your Account
                </h3>
                {{-- <p
                  class="mb-12 text-base font-medium text-dark-text"
                >
                  Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                </p> --}}

                {{-- <h3
                  class="mb-8 font-heading text-xl text-dark dark:text-white"
                >
                  Sign in with Social Media
                </h3>
                <div class="mb-12 flex items-center space-x-4">
                  <button
                    class="flex h-[50px] w-[50px] items-center justify-center rounded border text-base text-dark-text dark:border-transparent dark:bg-[#2C3443] sm:w-auto sm:px-7"
                  >
                    <span class="sm:pr-3">
                      <svg
                        width="18"
                        height="18"
                        viewBox="0 0 18 18"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <g clip-path="url(#clip0_1416_409)">
                          <path
                            d="M18 9.19932C18.0109 8.58059 17.9457 7.96284 17.806 7.35938H9.18372V10.6993H14.2449C14.149 11.2849 13.9333 11.8455 13.6106 12.3473C13.288 12.8491 12.8651 13.2818 12.3674 13.6193L12.3497 13.7311L15.0761 15.8009L15.2649 15.8194C16.9995 14.2493 17.9997 11.9393 17.9997 9.19932"
                            fill="#4285F4"
                          />
                          <path
                            d="M9.18382 18.0003C11.6633 18.0003 13.745 17.2003 15.2655 15.8203L12.3675 13.6202C11.592 14.1503 10.5512 14.5203 9.18382 14.5203C8.02249 14.5137 6.89279 14.1488 5.955 13.4775C5.0172 12.8061 4.31894 11.8624 3.95927 10.7803L3.85164 10.7893L1.01679 12.9392L0.979736 13.0402C1.74323 14.5314 2.91494 15.7851 4.36385 16.661C5.81276 17.537 7.48174 18.0007 9.18417 18.0003"
                            fill="#34A853"
                          />
                          <path
                            d="M3.95921 10.7798C3.75834 10.2069 3.65469 9.60558 3.65239 8.99982C3.65609 8.39505 3.75591 7.79453 3.94828 7.21988L3.94316 7.10057L1.07355 4.91602L0.979681 4.95976C0.335608 6.21294 0.00012207 7.59658 0.00012207 8.99973C0.00012207 10.4029 0.335608 11.7865 0.979681 13.0397L3.95921 10.7798Z"
                            fill="#FBBC05"
                          />
                          <path
                            d="M9.1838 3.47965C10.4997 3.45963 11.7725 3.93991 12.7348 4.81971L15.3267 2.33965C13.6644 0.811346 11.463 -0.0272143 9.1838 -0.000350488C7.48139 -0.000747434 5.81242 0.462942 4.36352 1.33887C2.91461 2.2148 1.74289 3.46843 0.97937 4.95959L3.94902 7.21971C4.31223 6.13773 5.01281 5.19476 5.95199 4.52376C6.89117 3.85275 8.02156 3.48755 9.1838 3.47965Z"
                            fill="#EB4335"
                          />
                        </g>
                        <defs>
                          <clipPath id="clip0_1416_409">
                            <rect width="18" height="18" fill="white" />
                          </clipPath>
                        </defs>
                      </svg>
                    </span>
                    <span class="hidden sm:inline-flex">
                      Sign in with Google
                    </span>
                  </button>
                  <button
                    class="flex h-[50px] w-[50px] items-center justify-center rounded border dark:border-transparent dark:bg-[#2C3443]"
                  >
                    <svg
                      width="28"
                      height="22"
                      viewBox="0 0 28 22"
                      fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        d="M27.0729 2.58824C26.0765 3.04118 25.0024 3.33882 23.8894 3.48118C25.0282 2.79529 25.9082 1.70824 26.3224 0.401176C25.2482 1.04824 24.0576 1.50118 22.8024 1.76C21.78 0.647059 20.3435 0 18.7129 0C15.6718 0 13.1871 2.48471 13.1871 5.55176C13.1871 5.99177 13.2388 6.41882 13.3294 6.82C8.72235 6.58706 4.62 4.37412 1.88941 1.02235C1.41059 1.83765 1.13882 2.79529 1.13882 3.80471C1.13882 5.73294 2.10941 7.44118 3.61059 8.41177C2.69176 8.41177 1.83765 8.15294 1.08706 7.76471C1.08706 7.76471 1.08706 7.76471 1.08706 7.80353C1.08706 10.4953 3.00235 12.7471 5.53882 13.2518C5.07294 13.3812 4.58118 13.4459 4.07647 13.4459C3.72706 13.4459 3.37765 13.4071 3.04118 13.3424C3.74 15.5294 5.77177 17.16 8.21765 17.1988C6.32824 18.7 3.93412 19.58 1.32 19.58C0.88 19.58 0.44 19.5541 0 19.5024C2.45882 21.0812 5.38353 22 8.51529 22C18.7129 22 24.3165 13.5365 24.3165 6.19882C24.3165 5.95294 24.3165 5.72 24.3035 5.47412C25.3906 4.69765 26.3224 3.71412 27.0729 2.58824Z"
                        fill="#00AFED"
                      />
                    </svg>
                  </button>
                  <button
                    class="flex h-[50px] w-[50px] items-center justify-center rounded border dark:border-transparent dark:bg-[#2C3443]"
                  >
                    <svg
                      width="12"
                      height="22"
                      viewBox="0 0 12 22"
                      fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        d="M7.7 12.65H10.45L11.55 8.25H7.7V6.05C7.7 4.917 7.7 3.85 9.9 3.85H11.55V0.154C11.1914 0.1067 9.8373 0 8.4073 0C5.4208 0 3.3 1.8227 3.3 5.17V8.25H0V12.65H3.3V22H7.7V12.65Z"
                        fill="#1877F2"
                      />
                    </svg>
                  </button>
                  <button
                    class="flex h-[50px] w-[50px] items-center justify-center rounded-md border dark:border-transparent dark:bg-[#2C3443]"
                  >
                    <svg
                      width="23"
                      height="22"
                      viewBox="0 0 23 22"
                      fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        d="M11.2731 0C9.7927 0 8.32679 0.291587 6.95907 0.858113C5.59136 1.42464 4.34862 2.25501 3.30182 3.30181C1.1877 5.41593 0 8.28329 0 11.2731C0 16.2558 3.23538 20.4832 7.7108 21.9825C8.27446 22.0727 8.45483 21.7233 8.45483 21.4189C8.45483 21.1596 8.45483 20.4494 8.45483 19.5137C5.33218 20.1901 4.66706 18.0031 4.66706 18.0031C4.1485 16.6955 3.41575 16.346 3.41575 16.346C2.3899 15.6471 3.49466 15.6696 3.49466 15.6696C4.62197 15.7485 5.21945 16.8307 5.21945 16.8307C6.20021 18.5442 7.85735 18.037 8.49992 17.7664C8.60138 17.0336 8.89448 16.5376 9.21013 16.2558C6.7075 15.974 4.08086 15.0045 4.08086 10.7094C4.08086 9.45813 4.50924 8.45482 5.24199 7.65443C5.12926 7.37261 4.7347 6.2002 5.35472 4.67834C5.35472 4.67834 6.30167 4.37396 8.45483 5.82819C9.3454 5.58018 10.3149 5.45618 11.2731 5.45618C12.2313 5.45618 13.2008 5.58018 14.0914 5.82819C16.2445 4.37396 17.1915 4.67834 17.1915 4.67834C17.8115 6.2002 17.4169 7.37261 17.3042 7.65443C18.037 8.45482 18.4653 9.45813 18.4653 10.7094C18.4653 15.0158 15.8274 15.9627 13.3135 16.2445C13.7194 16.594 14.0914 17.2817 14.0914 18.3301C14.0914 19.8407 14.0914 21.0581 14.0914 21.4189C14.0914 21.7233 14.2717 22.084 14.8467 21.9825C19.3221 20.4719 22.5462 16.2558 22.5462 11.2731C22.5462 9.79269 22.2546 8.32678 21.6881 6.95907C21.1216 5.59135 20.2912 4.34862 19.2444 3.30181C18.1976 2.25501 16.9549 1.42464 15.5871 0.858113C14.2194 0.291587 12.7535 0 11.2731 0Z"
                        fill="#79808A"
                      />
                    </svg>
                  </button>
                </div> --}}

                <div
                  class="relative z-10 mb-8 flex items-center justify-center"
                >
                  <span
                    class="absolute top-1/2 left-0 -z-10 hidden h-[1px] w-full -translate-y-1/2 bg-slate-300 dark:bg-[#2E333D] sm:block"
                  ></span>
                  <p
                    class="bg-white text-base font-medium text-dark-text dark:bg-[#1D232D] sm:px-4"
                  >
                    Sign in with your email
                  </p>
                </div>

                <form method="POST" action="{{ route('login') }}">
                  @csrf
                  <div class="-mx-4 flex flex-wrap">
                    <div class="w-full px-4 sm:w-1/2">
                      <div class="mb-10">
                        <label
                          for="login"
                          class="mb-3 block font-heading text-base text-dark dark:text-white"
                        >
                          Email Address or Username
                        </label>
                        <input
                          type="text"
                          name="login"
                          :value="old('login')" 
                          required autofocus autocomplete="login"
                          placeholder=""
                          class="w-full border-b bg-transparent py-5 text-base font-medium text-dark placeholder-dark-text outline-none focus:border-primary dark:border-[#2C3443] dark:text-white dark:focus:border-white"
                        />
                        <x-input-error :messages="$errors->get('login')" class="mt-2 text-red-500" style="color: crimson;" />
                      </div>
                    </div>
                    <div class="w-full px-4 sm:w-1/2">
                      <div class="mb-10">
                        <label
                          for="password"
                          class="mb-3 block font-heading text-base text-dark dark:text-white"
                        >
                          Password
                        </label>
                        <input
                          type="password"
                          name="password"
                          placeholder="**********"
                          class="w-full border-b bg-transparent py-5 text-base font-medium text-dark placeholder-dark-text outline-none focus:border-primary dark:border-[#2C3443] dark:text-white dark:focus:border-white"
                        />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" style="color: crimson;" />
                      </div>
                    </div>

                    <div class="w-full px-4">
                      <div class="flex flex-wrap">
                        <div class="mb-8 mr-10">
                          <label
                            for="supportCheckbox"
                            class="flex cursor-pointer select-none text-dark-text hover:text-primary"
                          >
                            <div class="relative">
                              <input
                                type="checkbox"
                                id="supportCheckbox"
                                name="remember"
                                class="sr-only"
                              />
                              <div
                                class="box mr-4 mt-1 flex h-5 w-5 items-center justify-center rounded border dark:border-[#414652]"
                              >
                                <span class="opacity-0">
                                  <svg
                                    width="11"
                                    height="8"
                                    viewBox="0 0 11 8"
                                    fill="none"
                                    class="stroke-current"
                                  >
                                    <path
                                      d="M10.0915 0.951972L10.0867 0.946075L10.0813 0.940568C9.90076 0.753564 9.61034 0.753146 9.42927 0.939309L4.16201 6.22962L1.58507 3.63469C1.40401 3.44841 1.11351 3.44879 0.932892 3.63584C0.755703 3.81933 0.755703 4.10875 0.932892 4.29224L0.932878 4.29225L0.934851 4.29424L3.58046 6.95832C3.73676 7.11955 3.94983 7.2 4.1473 7.2C4.36196 7.2 4.55963 7.11773 4.71406 6.9584L10.0468 1.60234C10.2436 1.4199 10.2421 1.1339 10.0915 0.951972ZM4.2327 6.30081L4.2317 6.2998C4.23206 6.30015 4.23237 6.30049 4.23269 6.30082L4.2327 6.30081Z"
                                      stroke-width="0.4"
                                    ></path>
                                  </svg>
                                </span>
                              </div>
                            </div>
                            Keep me signed in
                          </label>
                        </div>
                        <div class="mb-8">
                          @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-base text-dark-text hover:text-primary">Forget Password ?</a>
            @endif
                          
                        </div>
                      </div>
                    </div>
                    <div class="w-full px-4">
                      <button
                        class="flex items-center justify-center rounded bg-primary py-[14px] px-14 text-sm font-semibold text-white"
                      >
                        Sign In Now
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- ====== Sign In Section End -->

    
    @include('landing.partials.footer') 
  </x-guest-layout>
