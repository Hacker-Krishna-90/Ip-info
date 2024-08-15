<?php
// Set the content type to JSON if an error occurs
header('Content-Type: application/json');

// Check if the IP parameter is present
if (!isset($_GET['ip']) || empty($_GET['ip'])) {
    echo json_encode(['error' => "parameters can't be empty, fix the format"]);
    exit;
}

// Get the IP address from the query parameter
$ip = $_GET['ip'];

// Define the IP-API endpoint with the provided IP address
$apiUrl = "http://ip-api.com/json/{$ip}";

// Fetch data from IP-API
$response = @file_get_contents($apiUrl);

// Check if the request was successful
if ($response === FALSE) {
    echo json_encode(['error' => "Failed to fetch IP details."]);
    exit;
}

// Decode the API response
$data = json_decode($response, true);

// Check if the API returned a successful response
if ($data['status'] === 'fail') {
    echo json_encode(['error' => 'Invalid IP address or unable to retrieve details.']);
    exit;
}

// Set the content type to plain text for the response
header('Content-Type: text/plain');

// Format the response data in plain text with the ❤️ emoji
$formattedResponse = "
❤️ Free IP Services ❤️
==========================
🗾 IP Valid: " . ($data['status'] === "success" ? "✅" : "❌") . "
🌎 Country: {$data['country']}
💠 Country Code: {$data['countryCode']}
🥬 Region: {$data['region']}
🗺️ Region Name: {$data['regionName']}
🏠 City: {$data['city']}
✉️ Zip: {$data['zip']}
🦠 Latitude: {$data['lat']}
⭐ Longitude: {$data['lon']}
🕢 Timezone: {$data['timezone']}
🗼 ISP: {$data['isp']}
🔥 Organization: {$data['org']}
🌾 AS: {$data['as']}
🛰 IP: {$data['query']}
==========================
🔥 Powered By @cutehack99yt
";

// Output the plain text response
echo $formattedResponse;
