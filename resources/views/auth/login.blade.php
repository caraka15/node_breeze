<x-guest-layout>
    @section('title', $title)
    @section('description', 'Log in to your CRXA Node account. Ensure secure access to exclusive content and features.
        Your trusted gateway to node and validator services.')

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                    autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="relative mt-4">
                <x-input-label for="password" :value="__('Password')" />
                <div class="flex items-center">
                    <x-text-input id="password" class="block w-full pr-10" type="password" name="password" required
                        autocomplete="current-password" />
                    <div class="absolute inset-y-0 right-0 items-center flex top-5 m-0 pr-3">
                        <label for="togglePassword" class="cursor-pointer">
                            <i data-feather="eye-off" class="text-gray-600 dark:text-gray-400 text-xs w-5"
                                id="eye-open"></i>
                            <i data-feather="eye" class="text-gray-600 dark:text-gray-400 hidden text-xs w-5"
                                id="eye-closed"></i>
                            <input type="checkbox" class="hidden" id="togglePassword" />
                        </label>
                    </div>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>


            <!-- Remember Me -->
            <div class=" flex justify-between mt-4">
                <label for="remember_me" class="flex-none items-center">
                    <input id="remember_me" type="checkbox"
                        class="rounded flex-none dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-orange-600 shadow-sm focus:ring-orange-500 dark:focus:ring-orange-600 dark:focus:ring-offset-gray-800"
                        name="remember" {{ old('remember') ? 'checked' : '' }}>
                    <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
                </label>
                @if (Route::has('password.request'))
                    <a class="underline flex-col text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 dark:focus:ring-offset-gray-800"
                        href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class=" flex-col text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 dark:focus:ring-offset-gray-800"
                    href="{{ route('register') }}">
                    {{ __('Register') }}
                </a>
                <x-primary-button class="ml-3">
                    {{ __('Log in') }}
                </x-primary-button>
            </div>
        </form>
    </x-guest-layout>
