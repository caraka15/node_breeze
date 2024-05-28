<h2 class="mb-7 text-center text-2xl dark:text-white">Input Salary from {{ $airdrop->nama }}</h2>
<form method="post" action="/airdrop/salary/{{ $airdrop->id }}" enctype="multipart/form-data">
    @csrf
    @method('put')
    <div class="mt-4">
        <x-input-label for="salary" :value="__('Salary')" />
        <x-text-input id="salary" class="mt-1 block w-full" type="number" name="salary" :value="old('salary', $airdrop->salary)" required
            step="1" min="0" autocomplete="salary" />
        <x-input-error :messages="$errors->get('salary')" class="mt-2" />
    </div>

    <x-primary-button class="mt-4 justify-end">
        {{ __('Add Salary') }}
    </x-primary-button>
</form>
