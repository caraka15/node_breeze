<?php

$userAddress = $_GET['user_address'];

// Fetch Data
$dailyUrl = "https://raw.githubusercontent.com/exorde-labs/TestnetProtocol/main/Stats/daily_EXD_projected_rewards.json";
$hourlyUrl = "https://raw.githubusercontent.com/exorde-labs/TestnetProtocol/main/Stats/hourly_EXD_projected_rewards.json";
$leaderboardUrl = "https://raw.githubusercontent.com/exorde-labs/TestnetProtocol/main/Stats/leaderboard.json";
$bountyUrl = "https://raw.githubusercontent.com/exorde-labs/TestnetProtocol/main/Stats/bounties.json";

$dailyData = json_decode(file_get_contents($dailyUrl), true);
$hourlyData = json_decode(file_get_contents($hourlyUrl), true);
$leaderboardData = json_decode(file_get_contents($leaderboardUrl), true);
$bountyData = json_decode(file_get_contents($bountyUrl), true);

$userRep = $leaderboardData[$userAddress] ?? 0;
$userBounty = $bountyData['tweets'][$userAddress] ?? 0;

$sortedLeaderboard = array_values(array_flip(array_flip(array_column($leaderboardData, null))));
$rankedLeaderboard = array_flip($sortedLeaderboard);

$rankedLeaderboard = array_map(function ($rank) {
    return $rank + 1;
}, $rankedLeaderboard);

$userRank = $rankedLeaderboard[$userAddress] ?? null;

$totalRep = array_sum($leaderboardData);
$totalBounty = array_sum($bountyData['tweets']);
$exdPrice = 0.0647;
$hourlyReward = $hourlyData[$userAddress] ?? 0;
$monthlyReward = ($dailyData[$userAddress] ?? 0) * 30;
$hourlyRepIncrease = 506;

// Membuat array data untuk dikirim sebagai JSON
$data = [
    'userAddress' => $userAddress,
    'userRep' => $userRep,
    'userRank' => $userRank,
    'userBounty' => $userBounty,
    'totalRep' => $totalRep,
    'totalBounty' => $totalBounty,
    'exdPrice' => $exdPrice,
    'hourlyReward' => $hourlyReward,
    'monthlyReward' => $monthlyReward,
    'hourlyRepIncrease' => $hourlyRepIncrease,
];

// Mengembalikan data sebagai JSON
header('Content-Type: application/json');
echo json_encode($data);
