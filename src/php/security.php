<?php
// Paths to the admin and auth JSON files
$adminSecurityFile = '../data/adminSecurity.json';
$authSecurityFile = '../data/authSecurity.json';

// Fetch current data from the files
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $adminData = file_exists($adminSecurityFile) ? file_get_contents($adminSecurityFile) : json_encode(['identity' => '', 'password' => '']);
    $authData = file_exists($authSecurityFile) ? file_get_contents($authSecurityFile) : json_encode(['identity' => '', 'password' => '']);

    // Return both admin and auth data
    echo json_encode([
        'admin' => json_decode($adminData, true),
        'auth' => json_decode($authData, true)
    ]);
}

// Update the adminSecurity.json or authSecurity.json files with new data from the forms
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $inputData = json_decode(file_get_contents('php://input'), true);

    // Check if admin data is being updated
    if (isset($inputData['admin'])) {
        file_put_contents($adminSecurityFile, json_encode($inputData['admin'], JSON_PRETTY_PRINT));
        $response = ['status' => 'success', 'message' => 'Admin data saved successfully.'];
    }

    // Check if auth data is being updated
    if (isset($inputData['auth'])) {
        file_put_contents($authSecurityFile, json_encode($inputData['auth'], JSON_PRETTY_PRINT));
        $response = ['status' => 'success', 'message' => 'Auth data saved successfully.'];
    }

    // Return success message
    echo json_encode($response);
}
?>
