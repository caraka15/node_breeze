<x-app-layout>
    @section('title', 'Exorde Stats')
    @section('description', 'Exorde Stats Node Service, Validator guide')

    <div class="py-12">
        <div class="mx-auto max-w-5xl space-y-6 sm:px-6 lg:px-8">
            <div class="bg-white p-4 shadow dark:bg-gray-800 sm:rounded-lg sm:p-8">

                <div class="justify-center">
                    <button
                        class="inline-flex rounded-md border border-transparent bg-gray-800 p-3 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 dark:bg-orange-500 dark:hover:bg-orange-600 dark:focus:bg-orange-600 dark:active:bg-orange-600"
                        type="submit" id="connectButton1">Connect</button>
                </div>
                <div class="flex items-center justify-between">
                    <div class="hidden space-x-8 sm:-my-px sm:ml-5 sm:flex">
                        <div class="hidden space-x-8 sm:-my-px sm:ml-5 sm:flex">
                            <div id="connectedAddressContainer" class="hidden text-sm dark:text-white">
                                <span class="text-lg" id="connectedAddress"></span>
                            </div>
                        </div>
                    </div>

                    <button id="reloadButton"
                        class="hidden items-center rounded-md border border-transparent bg-gray-800 p-3 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 dark:bg-orange-500 dark:hover:bg-orange-600 dark:focus:bg-orange-600 dark:active:bg-orange-600"
                        onclick="reloadStats()">Reload</button>
                </div>

                <div id="statsContainer"
                    class="mt-4 hidden rounded-md bg-gray-200 p-4 dark:bg-slate-500 dark:text-white">
                    <p id="userRep"></p>
                    <p id="userRank"></p>
                    <p id="userBounty"></p>
                    <br>
                    <p id="exdPrice"></p>
                    <p id="hourlyReward"></p>
                    <p id="monthlyReward"></p>
                    <p id="usdReward"></p>

                    <!-- Menambahkan elemen untuk menampilkan waktu terakhir diperbarui -->
                </div>

                <div id="loadingMessage" class="hidden w-full">
                    <div class="mx-auto mt-5 flex h-20 w-20 content-center items-center justify-center">
                        <svg version="1.1" id="L5" xmlns="http://www.w3.org/2000/svg"
                            xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 100 100"
                            enable-background="new 0 0 0 0" xml:space="preserve">
                            <circle fill="orange" stroke="none" cx="6" cy="50" r="6">
                                <animateTransform attributeName="transform" dur="1s" type="translate"
                                    values="0 15 ; 0 -15; 0 15" repeatCount="indefinite" begin="0.1" />
                            </circle>
                            <circle fill="orange" stroke="none" cx="30" cy="50" r="6">
                                <animateTransform attributeName="transform" dur="1s" type="translate"
                                    values="0 10 ; 0 -10; 0 10" repeatCount="indefinite" begin="0.2" />
                            </circle>
                            <circle fill="orange" stroke="none" cx="54" cy="50" r="6">
                                <animateTransform attributeName="transform" dur="1s" type="translate"
                                    values="0 5 ; 0 -5; 0 5" repeatCount="indefinite" begin="0.3" />
                            </circle>
                        </svg>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="mx-auto max-w-5xl space-y-6 sm:px-6 lg:px-8">
            <div class="bg-white p-4 shadow dark:bg-gray-800 sm:rounded-lg sm:p-8">
                <table class="w-full table-auto border dark:text-white">
                    <tr>
                        <th class="border p-2">Total Reputation</th>
                        <th class="border p-2">{{ number_format($totalReputation) }}</th>
                    </tr>
                    <tr>
                        <th class="border p-2">Total Bounty</th>
                        <th class="border p-2">{{ number_format($totalBounty) }}</th>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="py-4">
        <div class="mx-auto max-w-5xl space-y-6 sm:px-6 lg:px-8">
            <div class="bg-white p-4 shadow dark:bg-gray-800 sm:rounded-lg sm:p-8">
                <h1 class="mb-4 text-center text-lg dark:text-white">Leaderboard</h1>
                @if (!empty($leaderboards))
                    <table class="w-full table-auto border dark:text-white">
                        <thead>
                            <tr>
                                <th class="border p-2">No</th>
                                <th class="border p-2">Address</th>
                                <th class="border p-2">Reputation</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($leaderboards as $address => $reward)
                                @if ($reward !== 0)
                                    <tr>
                                        <td class="border p-2">{{ $loop->iteration }}</td>
                                        <td class="border p-2">{{ $address }}</td>
                                        <td class="border p-2">{{ number_format($reward) }}</td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p>Failed to fetch leaderboard data.</p>
                @endif
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/web3@1.3.6/dist/web3.min.js"></script>
    <script>
        document.getElementById("connectButton1").addEventListener("click", async () => {
            try {
                await ethereum.enable(); // Request account access if needed
                console.log("Connected to MetaMask");

                const accounts = await ethereum.request({
                    method: 'eth_requestAccounts'
                });
                const connectedAddress = accounts[0];

                await fetch("/connect-metamask", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify({
                        connectedAddress
                    }),
                });

                console.log("Connected account:", connectedAddress);

                sessionStorage.setItem("connectAddress", connectedAddress);

                document.getElementById("connectButton1").style.display = "none";
                document.getElementById("connectedAddress").textContent = connectedAddress;
                document.getElementById("connectedAddressContainer").style.display = "inline";
                var reloadButton = document.getElementById("reloadButton");
                reloadButton.classList.add("inline-flex");
                reloadButton.classList.remove("hidden");

                await getUserStats(connectedAddress);
            } catch (error) {
                console.error("MetaMask connection error:", error);
            }
        });

        async function getUserStats(userAddress) {
            var statsContainer = document.getElementById('statsContainer');
            var loadingMessage = document.getElementById('loadingMessage');

            loadingMessage.style.display = 'block';

            try {
                var response = await fetch(`/php/exorde-stats.php?user_address=${userAddress}`);
                var data = await response.json();

                document.getElementById('userRep').innerText = 'Reputation: ' + data.userRep;
                document.getElementById('userRank').innerText = 'Rank: ' + data.userRank;
                document.getElementById('userBounty').innerText = 'Bounty: ' + data.userBounty + ' REP';
                document.getElementById('exdPrice').innerText = 'EXD Price: ' + data.exdPrice + 'USD';
                document.getElementById('hourlyReward').innerText = 'Hourly Reward: ' + data.hourlyReward + ' EXD';
                document.getElementById('monthlyReward').innerText = 'Monthly Reward: ' + data.monthlyReward +
                    ' EXD';
                document.getElementById('usdReward').innerText = 'USD Monthly Reward: ' + data.usdReward + ' USD';

                loadingMessage.style.display = 'none';
                statsContainer.style.display = 'block';
            } catch (error) {
                console.error('Error fetching data:', error);
                loadingMessage.innerText = 'Error fetching data';
            }
        }

        function reloadStats() {
            var statsContainer = document.getElementById('statsContainer');
            var loadingMessage = document.getElementById('loadingMessage');
            var connectedAddress = sessionStorage.getItem("connectAddress");

            statsContainer.style.display = 'none';
            loadingMessage.style.display = 'block';

            if (connectedAddress) {
                getUserStats(connectedAddress);
            } else {
                console.log("User not connected. Please connect to MetaMask first.");
            }
        }
    </script>
</x-app-layout>
