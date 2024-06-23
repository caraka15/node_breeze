<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)"
                required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="username" :value="__('Username')" />
            <x-text-input id="username" name="username" type="text" class="mt-1 block w-full" :value="old('username', $user->username)"
                required autofocus autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('username')" />
        </div>

        <div>
            <x-input-label for="telegram_username" :value="__('Telegram ID')" />
            <x-text-input id="telegram_username" name="telegram_username" type="text" class="mt-1 block w-full"
                :value="old('telegram_username', $user->telegram_username)" autofocus autocomplete="telegram_username" />
            <x-input-error class="mt-2" :messages="$errors->get('telegram_username')" />
        </div>
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)"
                required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div>
                    <p class="mt-2 text-sm text-gray-800 dark:text-gray-200">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification"
                            class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:text-gray-400 dark:hover:text-gray-100 dark:focus:ring-offset-gray-800">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-sm font-medium text-green-600 dark:text-green-400">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div id="addresses-section">
            <x-input-label for="addresses" :value="__('Addresses')" />
            <div id="addresses-wrapper">
                @foreach (old('addresses', $user->addresses ?? []) as $index => $address)
                    <div class="address-input mt-2 flex items-center gap-2" id="address-{{ $index }}">
                        <x-text-input id="addresses[{{ $index }}]" name="addresses[]" type="text"
                            class="mt-1 block w-full" :value="$address" required autofocus />
                        <button type="button"
                            class="remove-address-button mt-1 h-10 items-center rounded bg-red-500 px-2 py-1 text-white"
                            data-index="{{ $index }}">Remove</button>
                    </div>
                @endforeach
            </div>
            <button type="button" id="add-address-button"
                class="mt-2 rounded-md bg-red-600 px-3 py-1 hover:bg-red-500">{{ __('Add Address') }}</button>
            <x-input-error class="mt-2" :messages="$errors->get('addresses')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        let addressIndex = document.querySelectorAll('.address-input').length;

        document.getElementById('add-address-button').addEventListener('click', function() {
            const wrapper = document.getElementById('addresses-wrapper');
            const newAddressDiv = document.createElement('div');
            newAddressDiv.className = 'address-input mt-2 flex items-center gap-2';
            newAddressDiv.id = `address-${addressIndex}`;

            const newAddressInput = document.createElement('input');
            newAddressInput.type = 'text';
            newAddressInput.name = `addresses[]`;
            newAddressInput.className = 'mt-1 block w-full';
            newAddressInput.required = true;

            const removeButton = document.createElement('button');
            removeButton.type = 'button';
            removeButton.className =
                'remove-address-button mt-1 h-10 items-center rounded bg-red-500 px-2 py-1 text-white';
            removeButton.dataset.index = addressIndex;
            removeButton.innerText = 'Remove';

            newAddressDiv.appendChild(newAddressInput);
            newAddressDiv.appendChild(removeButton);
            wrapper.appendChild(newAddressDiv);

            addressIndex++;
        });

        document.getElementById('addresses-wrapper').addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-address-button')) {
                const index = e.target.dataset.index;
                const addressDiv = document.getElementById(`address-${index}`);
                addressDiv.remove();
            }
        });
    });
</script>
