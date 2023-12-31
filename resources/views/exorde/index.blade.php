<x-app-layout>
    @section('title', 'Exorde Stats')
    @section('description', 'Exorde Stats Node Service, Validator guide')

    <div class="py-12">
        <div class="mx-auto max-w-5xl space-y-6 sm:px-6 lg:px-8">
            <div class="bg-white p-4 shadow dark:bg-gray-800 sm:rounded-lg sm:p-8">

                <div class="flex items-center justify-center">
                    <input type="text"
                        class="max-w-full rounded-l-md border-gray-300 shadow-none focus:border-orange-500 focus:ring-orange-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-orange-600 dark:focus:ring-orange-600 sm:w-96"
                        placeholder="Get stats" name="user_address" id="user_address">
                    <button
                        class="inline-flex items-center rounded-r-md border border-transparent bg-gray-800 p-3 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 dark:bg-orange-500 dark:hover:bg-orange-600 dark:focus:bg-orange-600 dark:active:bg-orange-600"
                        type="submit" onclick="getUserStats()">Get Stats</button>
                </div>



                <div id="statsContainer"
                    class="mt-4 hidden rounded-md bg-gray-200 p-4 dark:bg-slate-500 dark:text-white">
                    <p id="userAddress"></p>
                    <p id="userRep"></p>
                    <p id="userRank"></p>
                    <p id="userBounty"></p>
                    <br>
                    <p id="totalRep"></p>
                    <p id="totalBounty"></p>
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
                            <circle fill="#fff" stroke="none" cx="6" cy="50" r="6">
                                <animateTransform attributeName="transform" dur="1s" type="translate"
                                    values="0 15 ; 0 -15; 0 15" repeatCount="indefinite" begin="0.1" />
                            </circle>
                            <circle fill="#fff" stroke="none" cx="30" cy="50" r="6">
                                <animateTransform attributeName="transform" dur="1s" type="translate"
                                    values="0 10 ; 0 -10; 0 10" repeatCount="indefinite" begin="0.2" />
                            </circle>
                            <circle fill="#fff" stroke="none" cx="54" cy="50" r="6">
                                <animateTransform attributeName="transform" dur="1s" type="translate"
                                    values="0 5 ; 0 -5; 0 5" repeatCount="indefinite" begin="0.3" />
                            </circle>
                        </svg>
                    </div>
                </div>
            </div>
        </div>



        <script>
            async function getUserStats() {
                var userAddress = document.getElementById('user_address').value;
                var statsContainer = document.getElementById('statsContainer');
                var loadingMessage = document.getElementById('loadingMessage');

                loadingMessage.style.display = 'block';

                try {
                    var response = await fetch(`/php/exorde-stats.php?user_address=${userAddress}`);
                    var data = await response.json();

                    document.getElementById('userAddress').innerText = 'Address: ' + data.userAddress;
                    document.getElementById('userRep').innerText = 'Reputation: ' + data.userRep;
                    document.getElementById('userRank').innerText = 'Rank: ' + data.userRank;
                    document.getElementById('userBounty').innerText = 'Bounty: ' + data.userBounty + ' REP';
                    document.getElementById('totalRep').innerText = 'Total Reputation: ' + data.totalRep + ' REP';
                    document.getElementById('totalBounty').innerText = 'Total Bounty: ' + data.totalBounty + ' REP';
                    document.getElementById('exdPrice').innerText = 'EXD Price: ' + data.exdPrice + 'USD';
                    document.getElementById('hourlyReward').innerText = 'Hourly Reward: ' + data.hourlyReward + ' EXD';
                    document.getElementById('monthlyReward').innerText = 'Monthly Reward: ' + data.monthlyReward + ' EXD';
                    document.getElementById('usdReward').innerText = 'USD Monthly Reward: ' + data.usdReward + ' USD';

                    loadingMessage.style.display = 'none';
                    statsContainer.style.display = 'block';
                } catch (error) {
                    console.error('Error fetching data:', error);
                    loadingMessage.innerText = 'Error fetching data';
                }
            }
        </script>
</x-app-layout>
