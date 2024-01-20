<?php
$userAddress = strtolower($_GET['user_address']); // Convert user address to lowercase

// Fetch Data
$dailyUrl = "https://raw.githubusercontent.com/exorde-labs/TestnetProtocol/main/Stats/daily_EXD_projected_rewards.json";
$hourlyUrl =
    "https://raw.githubusercontent.com/exorde-labs/TestnetProtocol/main/Stats/hourly_EXD_projected_rewards.json";
$leaderboardUrl = "https://raw.githubusercontent.com/exorde-labs/TestnetProtocol/main/Stats/leaderboard.json";
$bountyUrl = "https://raw.githubusercontent.com/exorde-labs/TestnetProtocol/main/Stats/bounties.json";

// Decode data
$dailyData = json_decode(file_get_contents($dailyUrl), true);
$hourlyData = json_decode(file_get_contents($hourlyUrl), true);
$leaderboardData = json_decode(file_get_contents($leaderboardUrl), true);
$bountyData = json_decode(file_get_contents($bountyUrl), true);

// Function to convert array keys to lowercase
function arrayKeysToLower($array)
{
    return array_change_key_case($array, CASE_LOWER);
}

// Convert array keys to lowercase
$dailyData = arrayKeysToLower($dailyData);
$hourlyData = arrayKeysToLower($hourlyData);
$leaderboardData = arrayKeysToLower($leaderboardData);
$bountyData = arrayKeysToLower($bountyData);

$userRep = $leaderboardData[$userAddress] ?? null;

// Sort leaderboard data
arsort($leaderboardData);
$sortedLeaderboard = array_keys($leaderboardData);
$rankedLeaderboard = array_flip($sortedLeaderboard);
$rankedLeaderboard = array_map(function ($rank) {
    return $rank + 1;
}, $rankedLeaderboard);
$userRank = $rankedLeaderboard[$userAddress] ?? null;

$bountyTweets = is_array($bountyData['tweets']) ? arrayKeysToLower($bountyData['tweets']) : [];

// Set default value of 0 for userAddress in tweets array
$userBounty = $bountyTweets[$userAddress] ?? 0;

// Function to get cryptocurrency data
function getCryptoData()
{
    $url = 'https://pro-api.coinmarketcap.com/v1/cryptocurrency/quotes/latest';
    $api_key = 'c278f052-8555-4544-81a5-a2d0ef287c4c';
    $crypto_slug = 'exorde';
    $convert_currency = 'USD';

    $parameters = [
        'slug' => $crypto_slug,
        'convert' => $convert_currency,
    ];

    $headers = [
        'Accepts: application/json',
        'X-CMC_PRO_API_KEY: ' . $api_key,
    ];

    $options = [
        'http' => [
            'header' => implode("\r\n", $headers),
        ],
    ];

    $context = stream_context_create($options);
    $response = file_get_contents("$url?" . http_build_query($parameters), false, $context);

    $crypto_data = json_decode($response, true);

    return $crypto_data;
}

// Get cryptocurrency data
$cryptoData = getCryptoData();
$bitcoinInfo = $cryptoData['data']['23638'];
$exdPrice = $bitcoinInfo['quote']['USD']['price'];
$numExdPrice = number_format($exdPrice, 4);

// Get hourly reward data
$hourlyReward = isset($hourlyData[$userAddress]) ? floatval($hourlyData[$userAddress]) : 0;

$totalRep = array_sum($leaderboardData);
$totalBounty = array_sum($bountyData['tweets']);

$userPercentage = number_format(($userRep / $totalRep) * 100, 2);
$bountyPercentage = number_format(($userBounty / $totalBounty) * 100, 2);
// Calculate monthly reward
$monthlyReward = $hourlyReward * 720;
$numMonthlyReward = number_format($monthlyReward, 2);
// Calculate USD reward
$usdReward = number_format($monthlyReward * $exdPrice, 2);

$data = [
    'userAddress' => $userAddress,
    'userPercentage' => $userPercentage,
    'bountyPercentage' => $bountyPercentage,
    'userRep' => $userRep,
    'userRank' => $userRank,
    'userBounty' => $userBounty,
    'exdPrice' => $numExdPrice,
    'hourlyReward' => $hourlyReward,
    'monthlyReward' => $numMonthlyReward,
    'usdReward' => $usdReward,
];

// Return data as JSON
header('Content-Type: application/json');
echo json_encode($data);
