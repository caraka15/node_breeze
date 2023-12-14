<x-guest-layout>
    @section('title', $title)
    @section('description',
        'Join CRXA Node community. Register for a new account to access exclusive features. Start
        your journey with CRXA Node - Your reliable partner in node and validator services.')

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
                    autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="username" :value="__('Username')" />
                <x-text-input id="username" name="username" type="text" class="mt-1 block w-full" :value="old('username')"
                    required autofocus autocomplete="username" />
                <x-input-error class="mt-2" :messages="$errors->get('username')" />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                    required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="relative mt-4">
                <x-input-label for="password" :value="__('Password')" />

                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                    autocomplete="new-password" />
                <div class="absolute inset-y-0 right-0 items-center flex top-5 m-0 pr-3">
                    <label for="togglePassword" class="cursor-pointer">
                        <i data-feather="eye-off" class="text-gray-600 dark:text-gray-400 text-xs w-5" id="eye-open"></i>
                        <i data-feather="eye" class="text-gray-600 dark:text-gray-400 hidden text-xs w-5"
                            id="eye-closed"></i>
                        <input type="checkbox" class="hidden" id="togglePassword" />
                    </label>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="relative mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                    name="password_confirmation" required autocomplete="new-password" />
                <div class="absolute inset-y-0 right-0 items-center flex top-5 m-0 pr-3">
                    <label for="togglePassword" class="cursor-pointer">
                        <i data-feather="eye-off" class="text-gray-600 dark:text-gray-400 text-xs w-5" id="eye-open"></i>
                        <i data-feather="eye" class="text-gray-600 dark:text-gray-400 hidden text-xs w-5"
                            id="eye-closed"></i>
                        <input type="checkbox" class="hidden" id="togglePassword" />
                    </label>
                </div>

                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                    href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-primary-button class="ml-4">
                    {{ __('Register') }}
                </x-primary-button>
            </div>
        </form>
    </x-guest-layout>
