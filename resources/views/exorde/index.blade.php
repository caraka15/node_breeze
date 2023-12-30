<x-app-layout>
    @section('title', 'Exorde Stats')
    @section('description', 'Exorde Stats Node Service, Validator guide')

    <div class="mx-auto mt-5 max-w-lg rounded bg-white p-8 shadow">
        <label for="user_address">Enter Address:</label>
        <input type="text" id="user_address" required>
        <button onclick="getUserStats()">Get Stats</button>

        <div id="statsContainer" class="hidden rounded-md bg-gray-200 p-4">
            <p id="userAddress"></p>
            <p id="userRep"></p>
            <p id="userRank"></p>
            <p id="userBounty"></p>
            <p id="totalRep"></p>
            <p id="totalBounty"></p>
            <p id="exdPrice"></p>
            <p id="hourlyReward"></p>
            <p id="monthlyReward"></p>
            <p id="hourlyRepIncrease"></p>
        </div>

        <div id="loadingMessage" class="hidden">
            Loading...
        </div>
    </div>

    <script>
        async function getUserStats() {
            var userAddress = document.getElementById('user_address').value;
            var statsContainer = document.getElementById('statsContainer');
            var loadingMessage = document.getElementById('loadingMessage');

            loadingMessage.style.display = 'block';

            try {
                // Pengambilan data langsung dari server
                var response = await fetch(`/php/exorde-stats.php?user_address=${userAddress}`);

                var data = await response.json();

                document.getElementById('userAddress').innerText = 'Address: ' + data.userAddress;
                document.getElementById('userRep').innerText = 'Reputation: ' + data.userRep;
                document.getElementById('userRank').innerText = 'Rank: ' + data.userRank;
                document.getElementById('userBounty').innerText = 'Bounty: ' + data.userBounty;
                document.getElementById('totalRep').innerText = 'Total Reputation: ' + data.totalRep;
                document.getElementById('totalBounty').innerText = 'Total Bounty: ' + data.totalBounty;
                document.getElementById('exdPrice').innerText = 'EXD Price: ' + data.exdPrice;
                document.getElementById('hourlyReward').innerText = 'Hourly Reward: ' + data.hourlyReward;
                document.getElementById('monthlyReward').innerText = 'Monthly Reward: ' + data.monthlyReward;
                document.getElementById('hourlyRepIncrease').innerText = 'Hourly Rep Increase: ' + data
                    .hourlyRepIncrease;

                loadingMessage.style.display = 'none';
                statsContainer.style.display = 'block';
            } catch (error) {
                console.error('Error fetching data:', error);
                loadingMessage.innerText = 'Error fetching data';
            }
        }
    </script>
</x-app-layout>
