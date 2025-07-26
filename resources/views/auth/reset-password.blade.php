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
                  Password Reset
                </h3>
                <p
                  class="mb-12 text-base font-medium text-dark-text"
                >
                
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
                    Reset your password
                  </p>
                </div>

                
                <form method="POST" action="{{ route('password.store') }}">
                    @csrf
                  <div class="-mx-4 flex flex-wrap">
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
                          :value="old('referral_code')" required autofocus autocomplete="referral_code"
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
                      <button
                        class="flex items-center justify-center rounded bg-primary py-[14px] px-14 text-sm font-semibold text-white"
                      >
                        Reset Password
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