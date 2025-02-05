<x-app-layout>
    @section('title', 'Exorde Stats')
    @section('description', 'Exorde Stats Node Service, Validator guide')

    <!-- Main Stats Container -->
    <div class="py-4">
        <div class="mx-auto max-w-5xl space-y-6 sm:px-6 lg:px-8">
            <!-- Enhanced Main Card -->
            <div class="overflow-hidden rounded-xl bg-white/80 p-6 backdrop-blur-sm sm:p-8 dark:bg-gray-800/90">
                <!-- Connect and Manual Address Container -->
                <div class="flex items-center justify-between space-x-4">
                    <!-- Connect Button -->
                    <button
                        class="inline-flex rounded-xl bg-gradient-to-r from-orange-500 to-orange-600 p-3 text-xs font-semibold uppercase tracking-widest text-white shadow-lg transition-all hover:-translate-y-0.5 hover:shadow-orange-500/25 dark:from-orange-600 dark:to-orange-700"
                        type="submit" id="connectButton1">Connect</button>

                    <!-- Input Manual dan Tombol Submit -->
                    <div class="flex flex-1 items-center space-x-2">
                        <input type="text" id="manualAddressInput" placeholder="Enter address manually"
                            class="flex-1 rounded-lg border border-gray-300 px-3 py-2 text-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        <button id="submitManualAddress"
                            class="rounded-xl bg-gradient-to-r from-orange-500 to-orange-600 p-3 text-xs font-semibold uppercase tracking-widest text-white shadow-lg transition-all hover:-translate-y-0.5 hover:shadow-green-500/25"
                            onclick="submitManualAddress()">Submit</button>
                    </div>
                </div>

                <!-- Reload Button -->
                <div class="mt-4 flex justify-end">
                    <button id="reloadButton"
                        class="hidden items-center rounded-xl bg-gradient-to-r from-gray-700 to-gray-800 p-3 text-xs font-semibold uppercase tracking-widest text-white shadow-lg transition-all hover:-translate-y-0.5 hover:shadow-gray-800/25 dark:from-orange-500 dark:to-orange-600"
                        onclick="reloadStats()">Reload</button>
                </div>

                <!-- Stats Grid Container -->
                <div id="statsContainer"
                    class="mt-6 hidden rounded-xl bg-gray-50 p-6 shadow-inner dark:bg-gray-700/50 dark:text-white">
                    <!-- Tampilkan Alamat di Sini -->


                    <h1 class="mb-4 text-xl font-bold">User Statistics</h1>
                    <div id="addressDisplayContainer" class="mb-4">
                        {{-- <span class="text-lg font-semibold">Connected Address:</span> --}}
                        <span class="font-mono text-lg" id="connectedAddress"></span>
                    </div>
                    <!-- Stats Grid -->
                    <div class="grid gap-6 md:grid-cols-3">
                        <!-- User Info Card -->
                        <div class="rounded-lg bg-white p-4 shadow-md transition-all hover:shadow-lg dark:bg-gray-800">
                            <h2 class="mb-3 text-lg font-semibold">User Information</h2>
                            <div class="space-y-2 text-sm">
                                <p><span id="userRank" class="font-medium"></span></p>
                                <p><span id="userRep" class="font-medium"></span></p>
                                <p><span id="userPercentage" class="font-medium"></span></p>
                            </div>
                        </div>

                        <!-- Bounty Stats Card -->
                        <div class="rounded-lg bg-white p-4 shadow-md transition-all hover:shadow-lg dark:bg-gray-800">
                            <h2 class="mb-3 text-lg font-semibold">Bounty Statistics</h2>
                            <div class="space-y-2 text-sm">
                                <p><span id="twitterBounty" class="font-medium"></span></p>
                                <p><span id="redditBounty" class="font-medium"></span></p>
                                <p><span id="youtubeBounty" class="font-medium"></span></p>
                                <p><span id="newsBounty" class="font-medium"></span></p>
                                <p><span id="blueSky" class="font-medium"></span></p>
                                <p><span id="threads" class="font-medium"></span></p>
                            </div>
                        </div>

                        <!-- Reward Card -->
                        <div class="rounded-lg bg-white p-4 shadow-md transition-all hover:shadow-lg dark:bg-gray-800">
                            <h2 class="mb-3 text-lg font-semibold">Reward Expectation</h2>
                            <div class="space-y-2 text-sm">
                                <p><span id="final" class="font-medium"></span></p>
                                <p><span id="exdReward" class="font-medium"></span></p>
                                <p><span id="exdPrice" class="font-medium"></span></p>
                                <p><span id="usdReward" class="font-medium"></span></p>
                            </div>
                        </div>
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

                    <!-- Disclaimer Section -->
                    <div class="mt-6 text-center text-sm text-gray-500 dark:text-gray-400">
                        <p>
                            <strong>Disclaimer:</strong> Reward expectation calculations are based on a reward pool of
                            {{ $multipliers->pool }} EXD distributed every 2 weeks.
                        </p>
                    </div>
                    <div class="mt-6 rounded-xl bg-white p-6 shadow-md dark:bg-gray-800">
                        <div class="mb-4">
                            <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Reputation History (24h)
                            </h2>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Your reputation changes over the last
                                24
                                hours</p>
                        </div>
                        <div class="relative h-[400px] w-full">
                            <canvas id="reputationChart"></canvas>
                            <p id="totalRepChange" class="mt-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                Total REP Change(last 24h): <span class="text-bold font-medium">0</span>
                        </div>
                    </div>
                </div>

                <!-- Loading Animation -->

            </div>
        </div>
    </div>

    <!-- Total Stats Container -->
    <div class="py-6">
        <div class="mx-auto max-w-5xl space-y-6 sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-xl bg-white/80 p-6 backdrop-blur-sm dark:bg-gray-800/90">
                <!-- Enhanced Stats Table -->
                <div class="overflow-hidden rounded-lg border border-gray-200 dark:border-gray-700">
                    <table class="w-full">
                        <tr
                            class="border-b border-gray-200 bg-gray-50 transition-colors hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-700/50 dark:hover:bg-gray-700">
                            <th class="p-4 text-left text-sm font-semibold text-gray-600 dark:text-gray-300">Total
                                Reputation</th>
                            <th class="p-4 text-right font-mono text-gray-800 dark:text-gray-100">
                                {{ number_format($totalReputation) }}</th>
                        </tr>
                        <tr
                            class="bg-white transition-colors hover:bg-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700">
                            <th class="p-4 text-left text-sm font-semibold text-gray-600 dark:text-gray-300">Total
                                Bounty</th>
                            <th class="p-4 text-right font-mono text-gray-800 dark:text-gray-100">
                                {{ number_format($totalBounty) }}</th>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Leaderboard Container -->
    <div class="py-4">
        <div class="mx-auto max-w-5xl space-y-6 sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-xl bg-white/80 p-6 backdrop-blur-sm dark:bg-gray-800/90">
                <h1 class="mb-4 text-center text-2xl font-bold text-gray-800 dark:text-white">Leaderboard</h1>

                <!-- Formula Card -->
                <div
                    class="mb-6 overflow-hidden rounded-xl bg-gradient-to-r from-blue-50 to-blue-100 p-6 dark:from-blue-900/20 dark:to-blue-800/20">
                    <h2 class="text-right text-lg font-semibold text-blue-800 dark:text-blue-200">FinalRep:</h2>
                    <p class="text-right font-bold text-blue-800 dark:text-blue-300">
                        Leaderboard +
                        <span class="font-bold text-blue-800 dark:text-blue-200">twitter bounties x
                            {{ $multipliers->twitter }}</span> +
                        <span class="font-bold text-blue-800 dark:text-blue-200">youtube bounties x
                            {{ $multipliers->youtube }}</span> +
                        <span class="font-bold text-blue-800 dark:text-blue-200">reddit bounties x
                            {{ $multipliers->reddit }}</span> +
                        <span class="font-bold text-blue-800 dark:text-blue-200">news bounties x
                            {{ $multipliers->news }}</span> +
                        <span class="font-bold text-blue-800 dark:text-blue-200">BlueSky bounties x
                            {{ $multipliers->bsky }}</span> +
                        <span class="font-bold text-blue-800 dark:text-blue-200">Threads bounties x
                            {{ $multipliers->threads }}</span>
                    </p>
                </div>

                @if (!empty($leaderboards))
                    <!-- Enhanced Leaderboard Table -->
                    <div
                        class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">
                        <table id="leaderboardTable" class="w-full table-auto">
                            <thead>
                                <tr
                                    class="border-b border-gray-200 bg-gray-50 text-sm dark:border-gray-700 dark:bg-gray-700">
                                    <th class="p-4 text-left font-medium text-gray-500 dark:text-gray-400"></th>
                                    <th class="p-4 text-left font-medium text-gray-500 dark:text-gray-400">No</th>
                                    <th class="p-4 text-left font-medium text-gray-500 dark:text-gray-400">Address</th>
                                    <th class="p-4 text-left font-medium text-gray-500 dark:text-gray-400">Reputation
                                    </th>
                                    <th class="p-4 text-left font-medium text-gray-500 dark:text-gray-400">Final Rep
                                    </th>
                                    <th class="p-4 text-left font-medium text-gray-500 dark:text-gray-400">Rep increase
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach ($leaderboards as $leaderboard)
                                    @if ($leaderboard['rep'] > 0)
                                        <tr class="transition-colors hover:bg-gray-50 dark:hover:bg-gray-700">
                                            <td class="p-4 text-right">
                                                @if ($leaderboard['rankDifference'] >= 0)
                                                    <span
                                                        class="text-green-500">+{{ $leaderboard['rankDifference'] }}</span>
                                                @else
                                                    <span
                                                        class="text-red-500">{{ $leaderboard['rankDifference'] }}</span>
                                                @endif
                                            </td>
                                            <td class="p-4 text-center font-medium text-gray-700 dark:text-gray-300">
                                                {{ $leaderboard['rank'] }}
                                            </td>
                                            <td
                                                class="address-cell p-4 font-mono text-sm text-gray-600 dark:text-gray-300">
                                                {{ strtolower($leaderboard['address']) }}
                                            </td>
                                            <td class="p-4 font-medium text-gray-700 dark:text-gray-300">
                                                {{ number_format($leaderboard['rep']) }}
                                            </td>
                                            <td class="p-4 font-medium text-gray-700 dark:text-gray-300">
                                                {{ number_format($leaderboard['totalRep']) }}
                                            </td>
                                            <td class="p-4 font-medium text-green-500">
                                                +{{ $leaderboard['valueDifference'] }}
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-center text-gray-500 dark:text-gray-400">Failed to fetch leaderboard data.</p>
                @endif
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/web3@1.3.6/dist/web3.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                document.getElementById("statsContainer").style.display = "block";
                document.getElementById("reloadButton").classList.remove("hidden");
                document.getElementById("reloadButton").classList.add("inline-flex");

                await getUserStats(connectedAddress);

                highlightConnectedAddressRow(connectedAddress);
            } catch (error) {
                console.error("MetaMask connection error:", error);
            }
        });

        // Fungsi untuk submit alamat manual
        function submitManualAddress() {
            const manualAddress = document.getElementById("manualAddressInput").value.trim();
            if (manualAddress) {
                sessionStorage.setItem("connectAddress", manualAddress);
                document.getElementById("connectedAddress").textContent = manualAddress;
                document.getElementById("statsContainer").style.display = "block";
                document.getElementById("reloadButton").classList.remove("hidden");
                document.getElementById("reloadButton").classList.add("inline-flex");

                getUserStats(manualAddress);
                highlightConnectedAddressRow(manualAddress);
            } else {
                alert("Please enter a valid address.");
            }
        }

        let reputationChart = null;

        async function initChart(userAddress) {
            try {
                const response = await fetch(`api/exorde-history?user_address=${userAddress}`);
                const data = await response.json();

                const ctx = document.getElementById('reputationChart').getContext('2d');
                const isDarkMode = document.documentElement.classList.contains('dark');

                if (reputationChart) {
                    reputationChart.destroy();
                }

                const chartData = data.changes.map(item => ({
                    x: new Date(item.timestamp).toLocaleTimeString('en-US', {
                        hour: '2-digit',
                        minute: '2-digit'
                    }),
                    y: item.change
                }));

                const totalChange = chartData.reduce((sum, item) => sum + item.y, 0);
                document.querySelector('#totalRepChange span').textContent = totalChange.toLocaleString();
                reputationChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: chartData.map(d => d.x),
                        datasets: [{
                            label: 'REP per 15m',
                            data: chartData.map(d => d.y),
                            borderColor: 'rgb(255, 159, 64)',
                            backgroundColor: 'rgba(255, 159, 64, 0.1)',
                            tension: 0.4,
                            fill: true,
                            pointRadius: 0,
                            pointHoverRadius: 6,
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: {
                            intersect: false,
                            mode: 'x'
                        },
                        scales: {
                            x: {
                                grid: {
                                    color: function(context) {
                                        if (!context.tick.label) return 'rgba(0, 0, 0, 0)';
                                        const hour = parseInt(context.tick.label.split(':')[0]);
                                        return (hour % 3 === 0) ?
                                            (isDarkMode ? 'rgba(255, 255, 255, 0.1)' :
                                                'rgba(0, 0, 0, 0.1)') :
                                            'rgba(0, 0, 0, 0)';
                                    }
                                },
                                ticks: {
                                    callback: function(val, index) {
                                        const label = this.getLabelForValue(val);
                                        const hour = parseInt(label.split(':')[0]);
                                        return hour % 3 === 0 ? label : '';
                                    }
                                }
                            },
                            y: {
                                min: 0
                            }
                        }
                    }
                });
            } catch (error) {
                console.error('Error initializing chart:', error);
            }
        }

        async function getUserStats(userAddress) {
            var statsContainer = document.getElementById('statsContainer');
            var loadingMessage = document.getElementById('loadingMessage');

            loadingMessage.style.display = 'block';

            try {
                var response = await fetch(`exorde-api?user_address=${userAddress}`);
                var data = await response.json();

                document.getElementById('userRep').innerText = 'Reputation: ' + data.reputation;
                document.getElementById('final').innerText = 'Final Reputation: ' + data.final;
                document.getElementById('userRank').innerText = 'Rank: ' + data.rank;
                document.getElementById('userPercentage').innerText = 'Percentage: ' + data.percentage + ' %';
                document.getElementById('twitterBounty').innerText = 'Twitter Bounties: ' + data.twitter;
                document.getElementById('redditBounty').innerText = 'Reddit Bounties: ' + data.reddit;
                document.getElementById('youtubeBounty').innerText = 'YouTube Bounties: ' + data.youtube;
                document.getElementById('newsBounty').innerText = 'News Bounties: ' + data.news;
                document.getElementById('blueSky').innerText = 'BlueSky Bounties: ' + data.blueSky;
                document.getElementById('threads').innerText = 'Threads Bounties: ' + data.threads;
                document.getElementById('exdPrice').innerText = 'EXD Price: ' + data.exd_price + ' USD';
                document.getElementById('usdReward').innerText = 'USD Reward: ' + data.usd_monthly_reward + ' USD';
                document.getElementById('exdReward').innerText = 'EXD Reward: ' + data.exdReward + ' EXD';

                // Initialize chart
                await initChart(userAddress);

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

        function highlightConnectedAddressRow(connectedAddress) {
            var leaderboardRows = document.querySelectorAll("#leaderboardTable tbody tr");
            leaderboardRows.forEach(row => {
                var addressCell = row.querySelector(".address-cell");
                if (addressCell && addressCell.textContent.toLowerCase() === connectedAddress.toLowerCase()) {
                    row.classList.add("bg-orange-500");
                }
            });
        }
    </script>
</x-app-layout>
