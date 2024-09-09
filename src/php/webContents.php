<?php
header('Content-Type: application/json');
$action = $_SERVER['REQUEST_METHOD'];

if ($action === 'GET') {
    // Fetch current web content settings
    $filePath = '../data/webContents.json';

    if (file_exists($filePath)) {
        $jsonData = file_get_contents($filePath);
        echo $jsonData;
    } else {
        echo json_encode([
            'error' => 'File not found',
            'brandName' => '',
            'brandNameFirst' => '',
            'brandNameSec' => '',
            'brandBio' => '',
            'brandEmail' => '',
            'brandTel' => '',
            'devVisivility' => ''
        ]);
    }
} elseif ($action === 'POST') {
    // Save new web content settings
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['brandName'],$data['brandNameFirst'],$data['brandNameSec'], $data['brandBio'], $data['brandEmail'], $data['brandTel'], $data['devVisivility'])) {
        $filePath = '../data/webContents.json';

        $jsonData = json_encode([
            'brandName' => $data['brandName'],
            'brandNameFirst' => $data['brandNameFirst'],
            'brandNameSec' => $data['brandNameSec'],
            'brandBio' => $data['brandBio'],
            'brandEmail' => $data['brandEmail'],
            'brandTel' => $data['brandTel'],
            'devVisivility' => $data['devVisivility']
        ], JSON_PRETTY_PRINT);

        if (file_put_contents($filePath, $jsonData)) {
            echo json_encode(['status' => 'success', 'message' => 'Settings updated successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update settings']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid data']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
