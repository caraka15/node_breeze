<div>
    <p>Detail rep in current iteration for address {{ $userAddress }}:</p>
    <p>Total rep in current iteration: {{ number_format($reputation) }}</p>
    <hr>
    <p>Your statistic in current leaderboard:</p>
    <p>Rank: {{ $rank }}</p>
    <p>Reputation: {{ number_format($reputation) }}</p>
    <p>Percentage: {{ number_format($percentage, 2) }}%</p>
    <hr>
    <p>Your statistic in current bounty leaderboard:</p>
    <p>Twitter Bounties: {{ number_format($twitter) }}</p>
    <p>Reddit Bounties: {{ number_format($reddit) }}</p>
    <p>YouTube Bounties: {{ number_format($youtube) }}</p>
    <p>News Bounties: {{ number_format($news) }}</p>
    <hr>
    <p>EXD Price: {{ $exd_price }} USD</p>
    <p>Expected monthly reward: {{ number_format($usd_monthly_reward, 2) }} USD</p>
    <hr>
    <p>Note: It's only an expected reward; it may be different from the final calculation due to data quality, etc.</p>
    <hr>
    <p>Your rep increase +{{ $hourlyRepIncrease }} REP since your last check 82 minutes ago</p>
    <p>EXD Price in bot updated every 5 minutes due to limit request from CoinMarketCap</p>
    <p>Leaderboard updated every 10 minutes!!!!!</p>
</div>
