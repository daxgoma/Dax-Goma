<?php
$jsonFilePath = '../data/products.json'; // Path to your JSON file
$mediaFolderPath = '../assets/media/'; // Path to your media folder

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = $_POST['id'];

    if (file_exists($jsonFilePath)) {
        $jsonData = file_get_contents($jsonFilePath);
        $products = json_decode($jsonData, true);

        // Find the product to delete and get the image path
        $productToDelete = null;
        foreach ($products as $product) {
            if ($product['id'] == $productId) {
                $productToDelete = $product;
                break;
            }
        }

        // Delete the product image if it exists
        if ($productToDelete && isset($productToDelete['image'])) {
            $imagePath = $mediaFolderPath . basename($productToDelete['image']);
            if (file_exists($imagePath)) {
                unlink($imagePath); // Delete the image file
            }
        }

        // Filter out the product to delete
        $products = array_filter($products, function($product) use ($productId) {
            return $product['id'] != $productId;
        });

        // Save the updated array back to the JSON file
        if (file_put_contents($jsonFilePath, json_encode($products, JSON_PRETTY_PRINT))) {
            echo json_encode(['status' => 'success']);
        } else {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Erreur lors de la suppression du produit.']);
        }
    } else {
        http_response_code(404);
        echo json_encode(['status' => 'error', 'message' => 'Le fichier JSON est introuvable.']);
    }
} else {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Méthode de requête non valide.']);
}
?>
