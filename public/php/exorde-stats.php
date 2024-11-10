<?php

$userAddress = strtolower($_GET['user_address']); // Convert user address to lowercase

// Fetch Data
$leaderboardUrl = "https://raw.githubusercontent.com/exorde-labs/TestnetProtocol/main/Stats/leaderboard.json";
$bountyUrl = "https://raw.githubusercontent.com/exorde-labs/TestnetProtocol/main/Stats/bounties.json";


// Decode data
$leaderboardData = json_decode(file_get_contents($leaderboardUrl), true);
$bountyData = json_decode(file_get_contents($bountyUrl), true);
// Function to convert array keys to lowercase
function arrayKeysToLower($array)
{
    return array_change_key_case($array, CASE_LOWER);
}

// Convert array keys to lowercase
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

$twitter = is_array($bountyData['tweets']) ? arrayKeysToLower($bountyData['tweets']) : [];
$reddit = is_array($bountyData['reddit']) ? arrayKeysToLower($bountyData['reddit']) : [];
$youtube = is_array($bountyData['youtube']) ? arrayKeysToLower($bountyData['youtube']) : [];
$news = is_array($bountyData['news']) ? arrayKeysToLower($bountyData['news']) : [];
$bsky = is_array($bountyData['bsky']) ? arrayKeysToLower($bountyData['bsky']) : [];

// Set default value of 0 for userAddress in tweets array
$twitterBounty = $twitter[$userAddress] ?? 0;
$redditBounty = $reddit[$userAddress] ?? 0;
$youtubeBounty = $youtube[$userAddress] ?? 0;
$newsBounty = $news[$userAddress] ?? 0;
$bskyBounty = $bsky[$userAddress] ?? 0;

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

// Get hourly reward data (assuming hourlyData is defined somewhere)
$hourlyReward = isset($hourlyData[$userAddress]) ? floatval($hourlyData[$userAddress]) : 0;

$totalRep = array_sum($leaderboardData);
$totaltweets = array_sum($bountyData['tweets']);
$totalReddit = array_sum($bountyData['reddit']);
$totalNews = array_sum($bountyData['news']);
$totalYoutube = array_sum($bountyData['youtube']);
$totalbsky = array_sum($bountyData['bsky']);

$totalBounty = ($totaltweets * 7.5) + ($totalReddit * 13) + ($totalNews * 25) + ($totalYoutube * 5) + ($totalbsky * 5) + $totalRep;

$finalReps = $userRep + ($twitterBounty * 7.5) + ($youtubeBounty * 5) + ($redditBounty * 13) + ($newsBounty * 25) + ($bskyBounty * 5);

//Final rep
// Path to your JSON file in the storage
$latestLeaderboardUrl = '../storage/data-json/latest_leaderboard.json';

// Check if the file exists
if (!file_exists($latestLeaderboardUrl)) {
    die('Error: File not found.');
}

// Read the content of the file
$latestLeaderboardData = file_get_contents($latestLeaderboardUrl);

// Decode JSON content into an associative array
$dataArray = json_decode($latestLeaderboardData, true);

$totalFinalRep = array_sum(array_column($dataArray, 'FinalRep'));

// Ini

$totalFinal = number_format($totalFinalRep);
$finalPresentage = number_format(($finalReps / $totalBounty) * 100, 2);
$exdReward = ($finalPresentage / 100) * 400000;

$userPercentage = number_format(($userRep / $totalRep) * 100, 2);
// Calculate monthly reward
$monthlyReward = $hourlyReward * 720;
$numMonthlyReward = number_format($monthlyReward, 2);
// Calculate USD reward
$usdReward = number_format($exdReward * $exdPrice, 2);

$data = [
    'rank' => $userRank,
    'reputation' => number_format($userRep),
    'percentage' => $userPercentage,
    'twitter' => number_format($twitterBounty),
    'reddit' => number_format($redditBounty),
    'youtube' => number_format($youtubeBounty),
    'news' => number_format($newsBounty),
    'final' => number_format($finalReps),
    'blueSky' => number_format($bskyBounty),
    'totalBounty' => number_format($totalBounty),
    'finalPresentage' => $finalPresentage,
    'exdReward' => $exdReward,
    'exd_price' => $numExdPrice,
    'usd_monthly_reward' => $usdReward,
    'totalRep' => $totalRep,
    'totaltweets' => $totaltweets,
];

// Return data as JSON
header('Content-Type: application/json');
echo json_encode($data);
