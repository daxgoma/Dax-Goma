<?php
$jsonFilePath = '../data/products.json'; // Path to your JSON file

if ($_SERVER['REQUEST_METHOD'] === 'POST' && file_exists($jsonFilePath)) {
    $jsonData = file_get_contents($jsonFilePath);
    $products = json_decode($jsonData, true);
    $productId = $_POST['id'];

    if (isset($productId)) {
        foreach ($products as &$product) {
            if ($product['id'] == $productId) {
                // Update product data
                $product['name'] = $_POST['editName'];
                $product['description'] = $_POST['editDescription'];
                $product['price'] = $_POST['editPrice'];
                $product['category'] = $_POST['editCategory'];
                $product['visibility'] = $_POST['editVisibility'];
    
                // Handle image upload if a new image is provided
                if (isset($_FILES['editImage']) && $_FILES['editImage']['error'] === UPLOAD_ERR_OK) {
                    $imageDir = '../assets/media/';
                    $imageExtension = pathinfo($_FILES['editImage']['name'], PATHINFO_EXTENSION);
                    $newImageName = 'product_image_' . $productId . '.' . $imageExtension;
                    $imageTmpPath = $_FILES['editImage']['tmp_name'];
                    $imagePath = $imageDir . $newImageName;
    
                    if (move_uploaded_file($imageTmpPath, $imagePath)) {
                        $product['image'] = $newImageName; // Save just the image name or relative path
                    } else {
                        echo json_encode(['status' => 'error', 'message' => 'Error uploading image.']);
                        exit;
                    }
                }
    
                // Save updated data back to JSON file
                if (file_put_contents($jsonFilePath, json_encode($products, JSON_PRETTY_PRINT))) {
                    echo json_encode(['status' => 'success', 'message' => 'Product updated successfully.']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Error saving product data.']);
                }
    
                break; // Exit the loop once the product is found and updated
            }
        }
        
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Product not found.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
}
?>
