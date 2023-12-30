<x-app-layout>
    @section('title', 'Exorde Stats')
    @section('description', 'Exorde Stats Node Service, Validator guide')

    <div class="mx-auto max-w-lg rounded bg-white p-8 shadow">
        <h1 class="mb-6 text-2xl font-bold">User Stats</h1>

        <form action="/exorde-stats" method="post" class="mb-6">
            @csrf
            <div class="mb-4">
                <label for="userAddress" class="block text-sm font-medium text-gray-600">User Address:</label>
                <input type="text" id="userAddress" name="user_address" class="mt-1 w-full rounded border p-2"
                    required>
            </div>

            <button type="submit"
                class="rounded bg-blue-500 px-4 py-2 text-white hover:bg-blue-600 focus:border-blue-300 focus:outline-none focus:ring">
                Get User Stats
            </button>
        </form>

        @isset($userAddress)
            <div class="py-6">
                <div class="mx-auto space-y-6 sm:px-6 lg:px-8">
                    <div class="bg-white p-4 shadow dark:bg-gray-800 sm:rounded-lg sm:p-8">
                        <div class="overflow-x-auto dark:text-white">
                            @include('exorde.stats') {{-- Include the stats partial --}}
                        </div>
                    </div>
                </div>
            </div>
        @endisset
    </div>

    <script>
        function getUserStats() {
            var userAddress = document.getElementById('userAddress').value;

            fetch('/exorde-stats', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        user_address: userAddress
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    document.getElementById('userRep').innerText = data.userRep;
                    document.getElementById('userBounty').innerText = data.userBounty;
                    // Update other elements with additional data
                    document.getElementById('userStatsResult').classList.remove('hidden');
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }
    </script>
</x-app-layout>
