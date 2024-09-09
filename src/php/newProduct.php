<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Define the directory paths
    $imageDir = '../assets/media/'; // Path to the media folder
    $jsonFilePath = '../data/products.json'; // Path to the JSON file

    // Check if the image was uploaded without errors
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        // Check if the JSON file exists to determine the new product ID
        if (file_exists($jsonFilePath)) {
            // Retrieve existing data from the JSON file
            $jsonData = file_get_contents($jsonFilePath);
            $products = json_decode($jsonData, true);

            // Find the highest current ID
            $maxId = 0;
            foreach ($products as $product) {
                if (isset($product['id']) && $product['id'] > $maxId) {
                    $maxId = $product['id'];
                }
            }

            // Increment the ID for the new product
            $newId = $maxId + 1;
        } else {
            // Start with ID 1 if no products exist
            $newId = 1;
            $products = [];
        }

        // Set the new image name to "product_image_{ID}"
        $imageExtension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $newImageName = 'product_image_' . $newId . '.' . $imageExtension;
        $imageTmpPath = $_FILES['image']['tmp_name'];
        $imagePath = $imageDir . $newImageName;

        // Move the file to the upload directory with the new name
        if (move_uploaded_file($imageTmpPath, $imagePath)) {
            // Prepare the product data
            $productData = [
                'id' => $newId,
                'name' => $_POST['name'],
                'description' => $_POST['description'],
                'price' => $_POST['price'],
                'category' => $_POST['category'],
                'visibility' => $_POST['visibility'],
                'image' => '../' . $imagePath, // Make sure the path is relative to where it will be used
            ];

            // Append the new product data
            $products[] = $productData;

            // Sort products by ID in descending order (newest first)
            usort($products, function($a, $b) {
                return $b['id'] - $a['id'];
            });

            // Save the updated product data back to the JSON file
            if (file_put_contents($jsonFilePath, json_encode($products, JSON_PRETTY_PRINT))) {
                // Send a success response back to the JS
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Produit ajouté avec succès.',
                    'product' => $productData
                ]);
            } else {
                http_response_code(500);
                echo json_encode([
                    'status' => 'error',
                    'message' => "Erreur lors de l'enregistrement du produit dans le fichier JSON."
                ]);
            }
        } else {
            http_response_code(500);
            echo json_encode([
                'status' => 'error',
                'message' => "Erreur lors du téléchargement de l'image."
            ]);
        }
    } else {
        http_response_code(400);
        echo json_encode([
            'status' => 'error',
            'message' => "No image uploaded or an error occurred."
        ]);
    }
} else {
    http_response_code(405);
    echo json_encode([
        'status' => 'error',
        'message' => "Invalid request method."
    ]);
}
