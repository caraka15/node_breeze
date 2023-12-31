<?php

$userAddress = $_GET['user_address'];

// Set absolute paths for files in public/php/
$previousLeaderboardPath = __DIR__ . '/previous_leaderboard.json';
$lastLeaderboardUpdatePath = __DIR__ . '/last_leaderboard_update_timestamp.txt';

// Load previous leaderboard data and timestamp
$previousLeaderboardData = json_decode(file_get_contents($previousLeaderboardPath), true);
$lastLeaderboardUpdateTimestamp = file_get_contents($lastLeaderboardUpdatePath);

// Get the current timestamp
$currentTimestamp = time();

// Calculate the time difference in seconds
$timeDifference = $currentTimestamp - $lastLeaderboardUpdateTimestamp;

// Convert seconds to minutes
$timeDifferenceInMinutes = round($timeDifference / 60);

// Fetch previous leaderboard if more than 10 minutes have passed
if ($timeDifferenceInMinutes > 10) {
    // Fetch the previous leaderboard
    // ... (your code to fetch the leaderboard)

    // Save the current timestamp for the next comparison
    file_put_contents($lastLeaderboardUpdatePath, $currentTimestamp);

    // Save the current leaderboard data for the next 10-minute interval
    file_put_contents($previousLeaderboardPath, json_encode($leaderboardData));
}

// Fetch Data
$dailyUrl = "https://raw.githubusercontent.com/exorde-labs/TestnetProtocol/main/Stats/daily_EXD_projected_rewards.json";
$hourlyUrl = "https://raw.githubusercontent.com/exorde-labs/TestnetProtocol/main/Stats/hourly_EXD_projected_rewards.json";
$leaderboardUrl = "https://raw.githubusercontent.com/exorde-labs/TestnetProtocol/main/Stats/leaderboard.json";
$bountyUrl = "https://raw.githubusercontent.com/exorde-labs/TestnetProtocol/main/Stats/bounties.json";

// Fetch current data
$dailyData = json_decode(file_get_contents($dailyUrl), true);
$hourlyData = json_decode(file_get_contents($hourlyUrl), true);
$leaderboardData = json_decode(file_get_contents($leaderboardUrl), true);
$bountyData = json_decode(file_get_contents($bountyUrl), true);

$userRep = $leaderboardData[$userAddress] ?? 0;
$userBounty = $bountyData['tweets'][$userAddress] ?? 0;

// Mengurutkan dari yang tertinggi ke terendah berdasarkan reputasi
arsort($leaderboardData);

// Mengambil kunci (alamat) dari array yang sudah diurutkan
$sortedLeaderboard = array_keys($leaderboardData);

// Menentukan urutan untuk setiap alamat
$rankedLeaderboard = array_flip($sortedLeaderboard);

// Menggeser urutan untuk memastikan dimulai dari 1
$rankedLeaderboard = array_map(function ($rank) {
    return $rank + 1;
}, $rankedLeaderboard);

// Mendapatkan peringkat pengguna yang diminta
$userRank = $rankedLeaderboard[$userAddress] ?? null;

$totalRep = array_sum($leaderboardData);
$totalBounty = array_sum($bountyData['tweets']);


// Save the current leaderboard data for the next comparison
file_put_contents($previousLeaderboardPath, json_encode($leaderboardData));

// ... (rest of your code)

// Get cryptocurrency data
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

// Extract relevant information
$bitcoinInfo = $cryptoData['data']['23638'];

$exdPrice = number_format($bitcoinInfo['quote']['USD']['price'], 4);

$hourlyReward = $hourlyData[$userAddress] ?? 0;
$monthlyReward = ($dailyData[$userAddress] ?? 0) * 30;
$hourlyRepIncrease = $leaderboardData[$userAddress] - ($previousLeaderboardData[$userAddress]);
$usdReward = $monthlyReward * $exdPrice;

// Create a string for "minutes ago" information
$minutesAgoString = $timeDifferenceInMinutes > 0 ? $timeDifferenceInMinutes . ' minutes ago' : 'just now';

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
    'usdReward' => $usdReward,
    'hourlyRepIncrease' => $hourlyRepIncrease,
    'lastUpdate' => $minutesAgoString, // Add last update time
];

// Mengembalikan data sebagai JSON
header('Content-Type: application/json');
echo json_encode($data);
