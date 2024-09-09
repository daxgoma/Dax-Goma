<?php
// Start the session
session_start();

// Check if the user is already logged in, if yes then redirect to the hidden page
if (isset($_SESSION['authorised']) && $_SESSION['authorised'] === true) {
    header("Location: hidden.php");
    exit;
}

// Path to the JSON file
$jsonFilePath = '../data/authSecurity.json';

// Check if the JSON file exists
if (!file_exists($jsonFilePath)) {
    die("Error: JSON file not found.");
}

// Get the JSON data
$jsonData = file_get_contents($jsonFilePath);

// Decode the JSON data
$credentials = json_decode($jsonData, true);

// Check if decoding was successful
if ($credentials === null) {
    die("Error: Unable to parse JSON data.");
}

// Retrieve credentials from JSON data
$valid_username = $credentials['identity'] ?? '';
$valid_password = $credentials['password'] ?? '';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the identity and password from the POST data
    $identity = trim($_POST['identity'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // Check if the credentials are valid
    if ($identity === $valid_username && $password === $valid_password) {
        // Authentication successful
        $_SESSION['authorised'] = true;
        $_SESSION['username'] = $identity;

        // Return a specific success keyword
        echo "success";
    } else {
        // Authentication failed
        echo "Identite ou mot de passe invalide.";
    }
} else {
    echo "Invalid request method.";
}
?>
