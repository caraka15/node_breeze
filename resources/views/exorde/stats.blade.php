<div>
    <p>Detail rep in current iteration for address {{ $userAddress }}:</p>
    <p>Total rep in current iteration: {{ number_format($userRep) }}</p>
    <hr>
    <p>Your statistic in current leaderboard:</p>
    <p>Rank: {{ $userRank }}</p>
    <p>Reputation: {{ number_format($userRep) }}</p>
    <p>Percentage: {{ number_format(($userRep / $totalRep) * 100, 2) }}%</p>
    <hr>
    <p>Your statistic in current bounty leaderboard:</p>
    <p>Your bounty: {{ number_format($userBounty) }}</p>
    <p>Percentage: {{ number_format(($userBounty / $totalBounty) * 100, 2) }}%</p>
    <hr>
    <p>EXD Price: {{ $exdPrice }} USD</p>
    <p>Your projected hourly reward: {{ number_format($hourlyReward) }} EXD</p>
    <p>Expected monthly reward: {{ number_format($monthlyReward) }} EXD</p>
    <p>Expected monthly reward: {{ number_format($monthlyReward * $exdPrice, 2) }} USD</p>
    <hr>
    <p>Note: It's only expected reward, it may be different with final calculation due to data quality etc.</p>
    <hr>
    <p>Your rep increase +{{ $hourlyRepIncrease }} REP since your last check 82 minutes ago</p>
    <p>EXD Price in bot updated every 5 minutes due to limit request from coinmarketcap</p>
    <p>Leaderboard updated every 10 minutes!!!!!</p>
</div>
