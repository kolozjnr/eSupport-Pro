<x-guest-layout>
    <div class="bg-gradient-to-r from-rose-100 to-teal-100 dark:from-gray-700 dark:via-gray-900 dark:to-black">

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="h-screen w-screen flex justify-center items-center">

            <div class="2xl:w-1/4 lg:w-1/3 md:w-1/2 w-full">
                <div class="card overflow-hidden sm:rounded-md rounded-none">
                    <div class="p-6">
                            <form method="POST" action="{{ route('password.store') }}">
                            @csrf
                            <!-- Password Reset Token -->
                            <input type="hidden" name="token" value="{{ $request->route('token') }}">
                        <a href="index.html" class="block mb-8">
                            <img class="h-6 block dark:hidden" src="{{asset('storage/'. $settings->dark_logo_sm)}}" alt="">
                            <img class="h-6 hidden dark:block" src="{{asset('storage/' . $settings->light_logo_sm)}}" alt="">
                        </a>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-600 dark:text-gray-200 mb-2" for="LoggingEmailAddress">Email Address</label>
                            <input id="email" class="form-input" type="email" name="email" :value="old('email')" required autofocus >
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                          <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-600 dark:text-gray-200 mb-2" for="email">Password</label>
                            <input id="email" class="form-input" type="password" name="password" required autocomplete="new-password" >
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>
                          <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-600 dark:text-gray-200 mb-2" for="password_confirmation">Confirm Password</label>
                            <input id="password_confirmation" class="form-input" type="password"  name="password_confirmation" required autocomplete="new-password" >
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>

                                  

                        <div class="flex justify-center mb-6">
                            <button class="btn w-full text-white bg-primary"> Reset Password </button>
                        </div>

                        {{-- <div class="flex items-center my-6">
                            <div class="flex-auto mt-px border-t border-dashed border-gray-200 dark:border-slate-700"></div>
                            <div class="mx-4 text-secondary">Or</div>
                            <div class="flex-auto mt-px border-t border-dashed border-gray-200 dark:border-slate-700"></div>
                        </div>
                    
                        <p class="text-gray-500 dark:text-gray-400 text-center">Back to<a href="/login" class="text-primary ms-1"><b>Log In</b></a></p> --}}
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->

</x-guest-layout>