<x-app-layout>
    @section('title', $title)
    <x-slot name="header">
        <h2 class="flex justify-between text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            <div x-data="{ showModal: {{ $errors->any() ? 'true' : 'false' }} }">
                <!-- Tombol untuk menampilkan modal -->
                <button @click="showModal = true" class="rounded-md bg-orange-600 px-5 py-2 hover:bg-orange-500">
                    New Airdrop
                </button>
                <!-- Modal -->
                <div x-show="showModal" class="fixed inset-9 z-50 overflow-hidden bg-transparent">
                    <div class="items-center justify-center">
                        <div
                            class="mx-auto max-w-5xl rounded-lg border border-gray-700 bg-white p-4 shadow dark:bg-gray-800 sm:rounded-lg sm:p-8">
                            <div class="mt-4 flex justify-end">
                                <button @click="showModal = false" class="relative text-gray-500 hover:text-gray-700">
                                    <i data-feather="x"></i>
                                </button>
                            </div>
                            <div class="max-w-full">
                                @include('airdrops.create')
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <x-primary-button id="NotificationBtn" class="rounded-md bg-orange-500 px-2 py-1 text-black">
                {{ auth()->user()->telegram_username ? 'Notifikasi Menyala' : 'Nyalakan Notifikasi' }}
            </x-primary-button>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto space-y-6 sm:px-6 lg:px-8">
            <div class="flex max-w-full overflow-auto bg-white p-4 shadow dark:bg-gray-800 sm:rounded-lg sm:p-8">
                <div class="relative w-full">
                    <table class="w-full text-left text-sm text-gray-500 rtl:text-right dark:text-gray-400">
                        <thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    No
                                </th>
                                <th scope="col" class="max-w-[800px] px-4 py-3">
                                    Title
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Link
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Frekuensi
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($airdrops as $airdrop)
                                <tr class="border-b bg-white dark:border-gray-700 dark:bg-gray-800">
                                    <th scope="row"
                                        class="whitespace-nowrap px-6 py-4 font-medium text-gray-900 dark:text-white">
                                        {{ $loop->iteration }}
                                    </th>
                                    <td class="max-w-[800px] whitespace-normal px-4 py-4">
                                        <input type="text" name="nama" value="{{ $airdrop->nama }}"
                                            class="border-transparent bg-transparent px-4 py-1 focus:border-none focus:ring-transparent">
                                    </td>
                                    <td class="px-6 py-4">
                                        <form action="/airdrop/status/{{ $airdrop->id }}" method="post"
                                            id="updateForm">
                                            @csrf
                                            @method('put')

                                            @if ($airdrop->sudah_dikerjakan)
                                                <button type="submit"
                                                    class="w-24 rounded-md bg-orange-500/50 px-4 py-2 text-white/50"
                                                    disabled>
                                                    Selesai
                                                </button>
                                            @else
                                                <button type="submit"
                                                    class="w-24 rounded-md bg-orange-500 px-4 py-2 text-white hover:scale-105 hover:bg-orange-600">
                                                    Kerjakan
                                                </button>
                                            @endif

                                        </form>

                                        <script>
                                            document.getElementById('updateForm').addEventListener('submit', function() {
                                                window.open("{{ $airdrop->link }}", "_blank");
                                            });
                                        </script>
                                    </td>
                                    <td class="px-6 py-4">
                                        <select name="frekuensi"
                                            class="border-transparent bg-transparent px-4 py-1 focus:border-none focus:ring-transparent">
                                            <option value="sekali"
                                                {{ $airdrop->frekuensi === 'sekali' ? 'selected' : '' }}>Sekali
                                            </option>
                                            <option value="daily"
                                                {{ $airdrop->frekuensi === 'daily' ? 'selected' : '' }}>Daily
                                            </option>
                                            <option value="weekly"
                                                {{ $airdrop->frekuensi === 'weekly' ? 'selected' : '' }}>Weekly
                                            </option>
                                        </select>
                                    </td>
                                    <td class="px-6 py-4">
                                        <x-primary-button type="submit"
                                            class="rounded-md bg-orange-500 px-2 py-1 text-black hover:bg-orange-600">
                                            {{ __('Update') }}
                                        </x-primary-button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('NotificationBtn').addEventListener('click', function() {
            // Gantilah 'your-telegram-id' dengan properti yang sesuai dengan Telegram ID pengguna
            var telegramId = '{{ auth()->user()->telegram_username }}';

            if (!telegramId) {
                // Jika Telegram ID kosong, tampilkan pesan peringatan
                alert('Isi Telegram ID untuk menyalakan notifikasi.');

                // Arahkan pengguna ke halaman edit profile
                window.location.href = '{{ route('profile.edit') }}';
            } else {
                alert('Anda ingin mematikan notifikasi? hapus Telegram ID di Profile');
                // Arahkan pengguna ke halaman edit profile

                window.location.href = '{{ route('profile.edit') }}';
            }
        });
    </script>

</x-app-layout>
