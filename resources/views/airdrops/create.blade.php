<h2 class="mb-7 text-center text-2xl dark:text-white">ADD NEW AIRDROP</h2>
<form method="post" action="/airdrop" enctype="multipart/form-data">
    @csrf

    <div class="mt-4">
        <x-input-label for="nama" :value="__('Nama')" />
        <x-text-input id="nama" class="mt-1 block w-full" type="text" name="nama" :value="old('nama')" required
            autofocus autocomplete="nama" />
        <x-input-error :messages="$errors->get('nama')" class="mt-2" />
    </div>


    <div class="mt-4">
        <x-input-label for="link" :value="__('Link')" />
        <x-text-input id="link" class="mt-1 block w-full" type="text" name="link" :value="old('link')" required
            autofocus autocomplete="link" />
        <x-input-error :messages="$errors->get('link')" class="mt-2" />
    </div>

    <div class="mt-4">
        <x-input-label for="frekuensi" :value="__('Frekuensi')" />
        <select name="frekuensi" id="frekuensi"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600">
            <option value="sekali">Sekali</option>
            <option value="daily">Daily</option>
            <option value="weekly">Weekly</option>
        </select>
    </div>

    <x-primary-button class="ml-[450px] mt-5 w-[122px]">
        {{ __('Add Airdrop') }}
    </x-primary-button>
</form>
