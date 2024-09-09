<?php
$jsonFilePath = '../data/categories.json';

// Vérifiez si la méthode de la requête est POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtenez les données du formulaire de la requête POST
    $nomCategorie = $_POST['name'] ?? null;

    if ($nomCategorie) {
        // Initialiser un tableau vide de catégories
        $categories = [];

        // Si le fichier existe, chargez et décodez les catégories existantes
        if (file_exists($jsonFilePath)) {
            $jsonData = file_get_contents($jsonFilePath);
            $categories = json_decode($jsonData, true);
            // Assurez-vous que $categories est un tableau
            if (!is_array($categories)) {
                $categories = [];
            }
        }

        // Vérifiez la duplication de la catégorie
        $duplique = false;
        foreach ($categories as $categorie) {
            if (strtolower($categorie['name']) === strtolower($nomCategorie)) {
                $duplique = true;
                break;
            }
        }

        if ($duplique) {
            echo json_encode(['status' => 'error', 'message' => 'La catégorie existe déjà.']);
        } else {
            // Créez un nouvel identifiant de catégorie
            $nouvelleCategorieId = count($categories);

            // Ajoutez la nouvelle catégorie
            $categories[] = [
                'id' => $nouvelleCategorieId,
                'name' => $nomCategorie,
            ];

            // Enregistrez les catégories mises à jour dans le fichier JSON
            if (file_put_contents($jsonFilePath, json_encode($categories, JSON_PRETTY_PRINT))) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Échec de l\'enregistrement de la catégorie.']);
            }
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Le nom de la catégorie est requis.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Méthode de requête invalide.']);
}
?>
