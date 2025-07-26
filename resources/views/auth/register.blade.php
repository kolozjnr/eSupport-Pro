<x-guest-layout>

    <!-- ====== Sign Up Section Start -->
    <section
      class="wow fadeInUp pt-[120px] lg:pt-[240px]"
      data-wow-delay=".2s"
    >
      <div class="px-4 xl:container">
        <div class="border-b pb-24 dark:border-[#2E333D]">
          <div class="-mx-4 flex flex-wrap">
            <div class="w-full px-4">
              <div
                class="mx-auto max-w-[920px] rounded border bg-white py-10 px-6 dark:border-transparent dark:bg-[#1D232D] sm:p-[70px]"
              >
                <h3
                  class="mb-3 font-heading text-2xl font-medium text-black dark:text-white sm:text-3xl lg:text-2xl xl:text-[40px] xl:leading-tight"
                >
                  Create your Account
                </h3>
                <p
                  class="mb-12 text-base font-medium text-dark-text"
                >
                  Create an account with us to start exploring
                </p>

              

                <div
                  class="relative z-10 mb-8 flex items-center justify-center"
                >
                  <span
                    class="absolute top-1/2 left-0 -z-10 hidden h-[1px] w-full -translate-y-1/2 bg-slate-300 dark:bg-[#2E333D] sm:block"
                  ></span>
                  <p
                    class="bg-white text-base font-medium text-dark-text dark:bg-[#1D232D] sm:px-4"
                  >
                    create account with email
                  </p>
                </div>

                
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                  <div class="-mx-4 flex flex-wrap">
                    <div class="w-full px-4 sm:w-1/2">
                      <div class="mb-10">
                        <label
                          for="fname"
                          class="mb-3 block font-heading text-base text-dark dark:text-white"
                        >
                          Full Name
                        </label>
                          <input type="hidden" id="user_type" name="user_type" value="customer" />
                        <input
                          type="text"
                          name="fname"
                          :value="old('fname')" required autofocus autocomplete="fname"
                          placeholder="Jhon Andrio"
                          class="w-full border-b bg-transparent py-5 text-base font-medium text-dark placeholder-dark-text outline-none focus:border-primary dark:border-[#2C3443] dark:text-white dark:focus:border-white"
                        />
                        <x-input-error :messages="$errors->get('fname')" class="mt-2" />
                      </div>
                    </div>
                    <div class="w-full px-4 sm:w-1/2">
                      <div class="mb-10">
                        <label
                          for="email"
                          class="mb-3 block font-heading text-base text-dark dark:text-white"
                        >
                          Email Address
                        </label>
                        <input
                          type="email"
                          name="email"
                          placeholder="jhonandrio@domain.com"
                          class="w-full border-b bg-transparent py-5 text-base font-medium text-dark placeholder-dark-text outline-none focus:border-primary dark:border-[#2C3443] dark:text-white dark:focus:border-white"
                        />
                      </div>
                    </div>

                    <div class="w-full px-4 sm:w-1/2">
                      <div class="mb-10">
                        <label
                          for="fname"
                          class="mb-3 block font-heading text-base text-dark dark:text-white"
                        >
                          Referral Code (Optional)
                        </label>
                        <input
                          type="text"
                          name="fname"
                          :value="old('referral_code')" autofocus autocomplete="referral_code"
                          placeholder="Referral Code (Optional)"
                          class="w-full border-b bg-transparent py-5 text-base font-medium text-dark placeholder-dark-text outline-none focus:border-primary dark:border-[#2C3443] dark:text-white dark:focus:border-white"
                        />
                        <x-input-error :messages="$errors->get('referral_code')" class="mt-2" /> 
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
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                      </div>
                    </div>
                    <div class="w-full px-4 sm:w-1/2">
                      <div class="mb-10">
                        <label
                          for="password_confirmation"
                          class="mb-3 block font-heading text-base text-dark dark:text-white"
                        >
                          Retype Password
                        </label>
                        <input
                          type="password"
                          name="password_confirmation"
                          placeholder="**********"
                          class="w-full border-b bg-transparent py-5 text-base font-medium text-dark placeholder-dark-text outline-none focus:border-primary dark:border-[#2C3443] dark:text-white dark:focus:border-white"
                        />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                      </div>
                    </div>

                    <div class="w-full px-4">
                      <div class="mb-8">
                        <label
                          for="supportCheckbox"
                          class="flex max-w-[425px] cursor-pointer select-none text-dark-text hover:text-primary"
                        >
                          <div class="relative">
                            <input
                              type="checkbox"
                              id="supportCheckbox"
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
                          By creating account means you agree to the Terms and
                          Conditions and our Privacy Policy
                        </label>
                      </div>
                    </div>
                    <div class="w-full px-4">
                      <button
                        class="flex items-center justify-center rounded bg-primary py-[14px] px-14 text-sm font-semibold text-white"
                      >
                        Create Account
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
    <!-- ====== Sign Up Section End -->


    @include('landing.partials.footer') 
    <!-- ====== Back To Top End ===== -->
  </x-guest-layout>