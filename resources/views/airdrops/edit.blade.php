<h2 class="mb-7 text-center text-2xl dark:text-white">Edit Airdrop {{ $airdrop->nama }}</h2>
<form method="post" action="/airdrop/{{ $airdrop->id }}" enctype="multipart/form-data">
    @csrf
    @method('put')
    <div class="mt-4">
        <x-input-label for="nama" :value="__('Name')" />
        <x-text-input id="nama" class="mt-1 block w-full" type="text" name="nama" :value="old('nama', $airdrop->nama)" required
            autofocus autocomplete="nama" />
        <x-input-error :messages="$errors->get('nama')" class="mt-2" />
    </div>


    <div class="mt-4">
        <x-input-label for="link" :value="__('Link')" />
        <x-text-input id="link" class="mt-1 block w-full" type="text" name="link" :value="old('link', $airdrop->link)" required
            autofocus autocomplete="link" />
        <x-input-error :messages="$errors->get('link')" class="mt-2" />
    </div>

    <div class="mt-4">
        <x-input-label for="frekuensi" :value="__('Frekuensi')" />
        <select name="frekuensi" id="frekuensi"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600">
            <option value="once" {{ old('frekuensi', $airdrop->frekuensi) == 'once' ? 'selected' : '' }}>Once
            </option>
            <option value="daily" {{ old('frekuensi', $airdrop->frekuensi) == 'daily' ? 'selected' : '' }}>Daily
            </option>
        </select>
    </div>

    <x-primary-button class="mt-4 justify-end">
        {{ __('Edit Airdrop') }}
    </x-primary-button>
</form>
