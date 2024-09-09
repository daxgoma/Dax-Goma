<?php
$jsonFilePath = '../data/products.json'; // Path to your JSON file

if (isset($_GET['id']) && file_exists($jsonFilePath)) {
    $productId = $_GET['id'];
    $jsonData = file_get_contents($jsonFilePath);
    $products = json_decode($jsonData, true);

    $productFound = null;
    foreach ($products as $product) {
        if ($product['id'] == $productId) {
            $productFound = $product;
            break;
        }
    }

    if ($productFound) {
        echo json_encode([
            'status' => 'success',
            'product' => $productFound
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Product not found.'
        ]);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid request.'
    ]);
}
?>
