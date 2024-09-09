<?php
session_start();

$productId = $_POST['productId'] ?? null;

if (!$productId) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid product ID']);
    exit;
}

// Initialize the cart session if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Check if the product is already in the cart
if (in_array($productId, $_SESSION['cart'])) {
    // Remove the product from the cart
    $_SESSION['cart'] = array_diff($_SESSION['cart'], [$productId]);
    $action = 'removed';
} else {
    // Add the product to the cart
    $_SESSION['cart'][] = $productId;
    $action = 'added';
}

echo json_encode(['status' => 'success', 'action' => $action, 'cart' => $_SESSION['cart']]);
?>
