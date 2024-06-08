<?php

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

// Check if JSON decoding was successful
if (json_last_error() !== JSON_ERROR_NONE) {
    die('Error: Invalid JSON file.');
}

// Initialize total FinalRep
$totalFinalRep = 0;

// Iterate through each item and sum the FinalRep values
foreach ($dataArray as $item) {
    if (isset($item['FinalRep'])) {
        $totalFinalRep += $item['FinalRep'];
    }
}

// Output the total FinalRep
echo "Total FinalRep: " . number_format($totalFinalRep);
