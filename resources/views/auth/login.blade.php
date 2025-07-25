<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="bg-gradient-to-r from-rose-100 to-teal-100 dark:from-gray-700 dark:via-gray-900 dark:to-black">

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="h-screen w-screen flex justify-center items-center">

            <div class="2xl:w-1/4 lg:w-1/3 md:w-1/2 w-full">
                <div class="card overflow-hidden sm:rounded-md rounded-none">
                    <form method="POST" action="{{ route('login') }}">
                            @csrf
                    <div class="p-6">
                        <a href="{{ route('login') }}" class="block mb-8">
                            <img class="h-6 block dark:hidden" src="{{asset('storage/'. $settings->dark_logo_sm)}}" alt="">
                            <img class="h-6 hidden dark:block" src="{{asset('storage/' . $settings->light_logo_sm)}}" alt="">
                        </a>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-600 dark:text-gray-200 mb-2" for="LoggingEmailAddress">Email Address</label>
                            <input id="LoggingEmailAddress" class="form-input" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="Enter your email" >
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                         

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-600 dark:text-gray-200 mb-2" for="loggingPassword">Password</label>
                            <input id="password" class="form-input" type="password"
                            name="password" required autocomplete="current-password" placeholder="Enter your password" >
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center">
                                <input type="checkbox" class="form-checkbox rounded" name="remember" id="remember_me">
                                <label class="ms-2" for="checkbox-signin">Remember me</label>
                            </div>
                             @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-sm text-primary border-b border-dashed border-primary">Forget Password ?</a>
            @endif

                            
                        </div>

                        <div class="flex justify-center mb-6">
                            <button class="btn w-full text-white bg-primary"> Log In </button>
                        </div>

                        <div class="flex items-center my-6">
                            <div class="flex-auto mt-px border-t border-dashed border-gray-200 dark:border-slate-700"></div>
                            <div class="mx-4 text-secondary">Or</div>
                            <div class="flex-auto mt-px border-t border-dashed border-gray-200 dark:border-slate-700"></div>
                        </div>

                        {{-- <div class="flex gap-4 justify-center mb-6">
                            <a href="javascript:void(0)" class="btn border-light text-gray-400 dark:border-slate-700">
                                <span class="flex justify-center items-center gap-2">
                                    <i class="mgc_github_line text-info text-xl"></i>
                                    <span class="lg:block hidden">Github</span>
                                </span>
                            </a>
                            <a href="javascript:void(0)" class="btn border-light text-gray-400 dark:border-slate-700">
                                <span class="flex justify-center items-center gap-2">
                                    <i class="mgc_google_line text-danger text-xl"></i>
                                    <span class="lg:block hidden">Google</span>
                                </span>
                            </a>
                            <a href="javascript:void(0)" class="btn border-light text-gray-400 dark:border-slate-700">
                                <span class="flex justify-center items-center gap-2">
                                    <i class="mgc_facebook_line text-primary text-xl"></i>
                                    <span class="lg:block hidden">Facebook</span>
                                </span>
                            </a>
                        </div> --}}

                        <p class="text-gray-500 dark:text-gray-400 text-center">Don't have an account ?<a href="{{ route('register') }}" class="text-primary ms-1"><b>Register</b></a></p>
                    </div>
                </form>
                </div>
            </div>
        </div>

    </div>

    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->

</x-guest-layout>