<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the logout status from the POST data
    $islogedout = $_POST['islogedout'] ?? '';

    // Check if the logout request is valid
    if ($islogedout === "true") {
        // Unset only the 'authorised' session variable
        if (isset($_SESSION['authorised'])) {
            unset($_SESSION['authorised']);
        }

        // Optionally, you can check if the session is now empty and destroy it
        if (empty($_SESSION)) {
            session_destroy();
        }

        // Respond with success
        echo "success";
        exit;
    } else {
        exit;
    }
} else {
    echo "Invalid request method.";
}
?>
