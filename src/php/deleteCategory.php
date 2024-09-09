<?php
$jsonFilePath = '../data/categories.json';

// Vérifiez si la méthode de la requête est POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtenez les données de la requête
    $input = json_decode(file_get_contents('php://input'), true);
    $idCategorie = $input['id'] ?? null;

    if ($idCategorie !== null && file_exists($jsonFilePath)) {
        $jsonData = file_get_contents($jsonFilePath);
        $categories = json_decode($jsonData, true);

        // Assurez-vous que les catégories sont un tableau
        if (is_array($categories)) {
            // Filtrez la catégorie avec l'ID correspondant
            $categories = array_filter($categories, function($categorie) use ($idCategorie) {
                return $categorie['id'] != $idCategorie;
            });

            // Réindexez le tableau
            $categories = array_values($categories);

            // Enregistrez les catégories mises à jour dans le fichier JSON
            if (file_put_contents($jsonFilePath, json_encode($categories, JSON_PRETTY_PRINT))) {
                // Stocker un indicateur dans localStorage pour garder `categoryManager` ouvert après le rechargement
                echo json_encode(['status' => 'success', 'keepManagerOpen' => true]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Échec de l\'enregistrement des catégories mises à jour.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Données de catégorie invalides.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'L\'ID de la catégorie est requis ou le fichier n\'existe pas.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Méthode de requête invalide.']);
}
?>
