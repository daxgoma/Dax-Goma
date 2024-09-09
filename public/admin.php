

<?php
session_start();


// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // User is not logged in, redirect to the login page
    header("Location: adminLogin.html");
    exit;
}

// User is logged in, display the admin page content
?>


<?php

// Path to the JSON file
$jsonFile = '../src/data/webContents.json';

// Read the JSON file
$jsonData = file_get_contents($jsonFile);

// Decode the JSON data into an associative array
$webContent = json_decode($jsonData, true);


// Extract values
$brandName = $webContent['brandName'] ?? 'Default Brand Name';
$brandNameFirst = $webContent['brandNameFirst'] ?? 'Default Brand Name First';
$brandNameSec = $webContent['brandNameSec'] ?? 'Default Brand Name Sec';
$brandBio = $webContent['brandBio'] ?? 'Default Brand Bio';
?>


<?php
$jsonFilePath = '../src/data/products.json'; // Path to your JSON file

if (file_exists($jsonFilePath)) {
    $jsonData = file_get_contents($jsonFilePath);
    $products = json_decode($jsonData, true);

    // Sort the products array by 'id' in descending order
    usort($products, function($a, $b) {
        return $b['id'] - $a['id'];
    });
} else {
    $products = [];
}
?>

<?php
// Load categories from categories.json
$jsonFilePath = '../src/data/categories.json';
$categories = [];

if (file_exists($jsonFilePath)) {
    $jsonData = file_get_contents($jsonFilePath);
    $categories = json_decode($jsonData, true);

    // Ensure $categories is an array before processing
    if (is_array($categories)) {
        // Sort categories alphabetically by their name
        usort($categories, function($a, $b) {
            return strcmp($a['name'], $b['name']);
        });

        // Shuffle categories to display them in random order
        $randomCategories = $categories;
        shuffle($randomCategories);
    } else {
        $categories = [];
        $randomCategories = [];
    }
} else {
    // If the file doesn't exist, initialize empty arrays
    $categories = [];
    $randomCategories = [];
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="../dist/styles.css" rel="stylesheet">
  <title>Stationova · Admin</title>
</head>
<body class="flex justify-center items-center bg-white">

    <nav id="nav" class="admin-nav flex py-2">
        <div class="flex items-center justify-start gap-[20px]">
            <h1 class="hidden-brand font-semibold">Statio<span class="text-gray-500">nova</span></h1>
            <input id="search" class="bg-transparent border border-black rounded-full font-normal w-[300px] py-3 px-6 focus:outline-none placeholder:text-black" type="search" name="search" id="search" placeholder="Rechercher une article">
        </div>
        <div class="menu-bars">
            <svg id="menuBtn" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                <path d="M0 96C0 78.3 14.3 64 32 64l384 0c17.7 0 32 14.3 32 32s-14.3 32-32 32L32 128C14.3 128 0 113.7 0 96zM0 256c0-17.7 14.3-32 32-32l384 0c17.7 0 32 14.3 32 32s-14.3 32-32 32L32 288c-17.7 0-32-14.3-32-32zM448 416c0 17.7-14.3 32-32 32L32 448c-17.7 0-32-14.3-32-32s14.3-32 32-32l384 0c17.7 0 32 14.3 32 32z"/>
            </svg>
        </div>
        <ul id="menu">
            <div class="logo">
                <svg id="closeMenuBtn" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                    <path fill="#000000" fill-rule="evenodd" d="M10.707085,3.70711 C11.097605,3.31658 11.097605,2.68342 10.707085,2.29289 C10.316555,1.90237 9.683395,1.90237 9.292865,2.29289 L4.292875,7.29289 C3.902375,7.68342 3.902375,8.31658 4.292875,8.70711 L9.292865,13.7071 C9.683395,14.0976 10.316555,14.0976 10.707085,13.7071 C11.097605,13.3166 11.097605,12.6834 10.707085,12.2929 L6.414185,8 L10.707085,3.70711 Z"/>
                </svg>
                <h1 class="font-semibold"><?php echo $brandNameFirst; ?><span class="text-gray-500"><?php echo $brandNameSec; ?></span></h1>
            </div>
            <li>
                <a href="./index.php">
                    <span>Accueil</span>
                </a>
            </li>
            <li>
                <a href="./apropos.php">
                    <span>À propos</span>
                </a>
            </li>
            <li id="categoryBtn">
                <a href="#">
                    <span>Categories</span>
                </a>
            </li>
            <li id="settingsBtn">
                <a href="#">
                    <span>Parametres</span>
                </a>
            </li>
            <button id="newProductBtn" class="bg-black text-white ml-3 py-3 px-6 rounded-full">
                Nouveau produit
            </button>
            <form method="post" id="LogoutForm" class="bg-transparent flex items-center justify-center">
                <button type="submit" class="bg-transparent">   
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 3.25C12.4142 3.25 12.75 3.58579 12.75 4C12.75 4.41421 12.4142 4.75 12 4.75C7.99594 4.75 4.75 7.99594 4.75 12C4.75 16.0041 7.99594 19.25 12 19.25C12.4142 19.25 12.75 19.5858 12.75 20C12.75 20.4142 12.4142 20.75 12 20.75C7.16751 20.75 3.25 16.8325 3.25 12C3.25 7.16751 7.16751 3.25 12 3.25Z" fill="#000"/>
                        <path d="M16.4697 9.53033C16.1768 9.23744 16.1768 8.76256 16.4697 8.46967C16.7626 8.17678 17.2374 8.17678 17.5303 8.46967L20.5303 11.4697C20.8232 11.7626 20.8232 12.2374 20.5303 12.5303L17.5303 15.5303C17.2374 15.8232 16.7626 15.8232 16.4697 15.5303C16.1768 15.2374 16.1768 14.7626 16.4697 14.4697L18.1893 12.75H10C9.58579 12.75 9.25 12.4142 9.25 12C9.25 11.5858 9.58579 11.25 10 11.25H18.1893L16.4697 9.53033Z" fill="#000"/>
                    </svg>
                </button>
            </form>
        </ul>
    </nav>

    <section class="py-12 mt-10 pb-[50px]">
    
        <ul id="categoryUl" class="flex flex-row gap-3 mb-10">
            <li class="bg-black text-white px-4 py-2 rounded-full border border-black cursor-pointer hover:bg-black hover:text-white" data-category="all">Tout</li>
            <?php foreach ($randomCategories as $category): ?>
                <li class="px-4 py-2 rounded-full border border-black cursor-pointer hover:bg-black hover:text-white" data-category="<?php echo htmlspecialchars($category['name'], ENT_QUOTES, 'UTF-8'); ?>">
                    <?= htmlspecialchars($category['name'], ENT_QUOTES, 'UTF-8') ?>
                </li>
            <?php endforeach; ?>
        </ul>

        <div id="productsContainer" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
            
            <div id="noProductMessage" class="no-products-message font-bold text-xl text-gray-500 hidden items-center justify-center w-full py-12">
                Aucun produit trouvé
            </div>

            <?php foreach ($products as $product): ?>
                <div 
                    class="article bg-white rounded-xl border overflow-hidden" 
                    data-category="<?php echo htmlspecialchars($product['category'], ENT_QUOTES, 'UTF-8'); ?>" 
                    data-product-id="<?php echo $product['id']; ?>"
                    <?php if ($product['visibility'] === 'private') echo 'id="hiddenArticle"'; ?>
                >
                    <img src="../src/assets/media/<?php echo basename($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="w-full">
                    <div class="p-3 w-full">
                        <h3 class="text-[16px] font-semibold mb-2"><?php echo htmlspecialchars($product['name']); ?></h3>
                        <p id="itemDesc" class="text-gray-700 mb-4"><?php echo htmlspecialchars($product['description']); ?></p>
                        <div class="flex flex-row justify-between align-center">
                            <p class="text-[16px] font-bold mb-4"><?php echo '$' . number_format($product['price'], 2); ?></p>
                            <?php if (isset($product['original_price'])): ?>
                                <p class="text-[14px] font-bold mb-4 text-gray-700 line-through"><?php echo '$' . number_format($product['original_price'], 2); ?></p>
                            <?php endif; ?>
                        </div>
                        <div class="flex flex-row gap-3 items-center mr-3 mb-4">
                            <!-- Modifier Button with data-product-id -->
                            <button class="border border-black text-black text-center w-[calc(100%-30px)] px-4 py-2 rounded-full text-center block edit-product" data-product-id="<?php echo $product['id']; ?>">Modifier</button>
                            <!-- Delete SVG with data-product-id -->
                            <svg class="deleteProduct" data-product-id="<?php echo $product['id']; ?>" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="height: 24px; width: 24px; cursor: pointer;">
                                <path d="M18 6L17.1991 18.0129C17.129 19.065 17.0939 19.5911 16.8667 19.99C16.6666 20.3412 16.3648 20.6235 16.0011 20.7998C15.588 21 15.0607 21 14.0062 21H9.99377C8.93927 21 8.41202 21 7.99889 20.7998C7.63517 20.6235 7.33339 20.3412 7.13332 19.99C6.90607 19.5911 6.871 19.065 6.80086 18.0129L6 6M4 6H20M16 6L15.7294 5.18807C15.4671 4.40125 15.3359 4.00784 15.0927 3.71698C14.8779 3.46013 14.6021 3.26132 14.2905 3.13878C13.9376 3 13.523 3 12.6936 3H11.3064C10.477 3 10.0624 3 9.70951 3.13878C9.39792 3.26132 9.12208 3.46013 8.90729 3.71698C8.66405 4.00784 8.53292 4.40125 8.27064 5.18807L8 6M14 10V17M10 10V17" stroke="red" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
    </section>

    <div id="productFormPopup" class="product-form-popup">
        <div id="formContainer" class="form-container">
            <div class="header">
                <span></span>
                <h2 class="text-[16px] font-bold">Publier un Nouveau Produit</h2>
                <span></span>
            </div>

            <form id="productForm" action="../src/php/newProduct.php" method="post" enctype="multipart/form-data">
                <div class="flex flex-row gap-3">
                    <div class="mb-4 w-full">
                        <label for="image">Image du Produit</label>
                        <div class="image-container">
                            <img src="" alt="">
                            <label for="image">Image</label>
                        </div>
                        <input type="file" id="image" name="image" accept="image/*" hidden required>
                    </div>

                    <div class="mb-4 w-full">
                        <label for="name">Nom du Produit</label>
                        <input type="text" id="name" name="name" placeholder="Entrez le nom du produit" required>
                    </div>
                </div>

                <div class="mb-4 w-full">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" placeholder="Entrez la description du produit" rows="5" required></textarea>
                </div>

                <div class="flex flex-row gap-3">
                    <div class="mb-4 w-full">
                        <label for="price">Prix</label>
                        <input type="number" id="price" name="price" placeholder="Entrez le prix du produit" required>
                    </div>

                    <div class="mb-4 w-full">
                        <label for="category">Catégorie</label>
                        <select id="category" name="category" required>
                            <option>Catégorie</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= htmlspecialchars($category['name'], ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($category['name'], ENT_QUOTES, 'UTF-8') ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>  
                </div>

                <div class="mb-4">
                    <label>Visibilité</label>
                    <div class="radio-group">
                        <label>
                            <input type="radio" name="visibility" value="public" required>
                            <span>Public</span>
                        </label>
                        <label>
                            <input type="radio" name="visibility" value="private" required>
                            <span>Privé</span>
                        </label>
                    </div>
                </div>

                <div class="w-full flex flex-row justify-start">
                    <button type="button" id="cancelNewProduct" class="bg-transparent font-bold border py-3 px-6 rounded-full" style="color: black; border-color: black;">
                        Annuler
                    </button>
                    <button type="submit" class="bg-transparent font-bold border border-black ml-3 py-3 px-6 rounded-full">
                        Publier
                    </button>
                </div>

            </form>
            
        </div>
    </div>

    <div id="editProduct" class="product-form-popup">
        <div id="editContainer" class="form-container">
            <div class="header">
                <span></span>
                <h2 class="text-[16px] font-bold">Modifier le Produit</h2>
                <span></span>
            </div>
            <form id="editForm" method="post" enctype="multipart/form-data">
                <div class="flex flex-row gap-3">
                    <div class="mb-4 w-full">
                        <label for="editImage">Image du Produit</label>
                        <div id="editImageContainer" class="image-container">
                            <img src="" alt="">
                            <label for="editImage">Image</label>
                        </div>
                        <input type="file" id="editImage" name="editImage" accept="image/*" hidden>
                    </div>

                    <div class="mb-4 w-full">
                        <label for="editName">Nom du Produit</label>
                        <input type="text" id="editName" name="editName" placeholder="Entrez le nom du produit" required>
                    </div>
                </div>

                <div class="mb-4 w-full">
                    <label for="editDescription">Description</label>
                    <textarea id="editDescription" name="editDescription" placeholder="Entrez la description du produit" rows="5" required></textarea>
                </div>

                <div class="flex flex-row gap-3">
                    <div class="mb-4 w-full">
                        <label for="editPrice">Prix</label>
                        <input type="number" id="editPrice" name="editPrice" placeholder="Entrez le prix du produit" required>
                    </div>

                    <div class="mb-4 w-full">
                        <label for="editCategory">Catégorie</label>
                        <select id="editCategory" name="editCategory" required>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= htmlspecialchars($category['name'], ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($category['name'], ENT_QUOTES, 'UTF-8') ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>  
                </div>

                <div class="mb-4">
                    <label>Visibilité</label>
                    <div class="radio-group">
                        <label>
                            <input type="radio" name="editVisibility" value="public" required>
                            <span>Public</span>
                        </label>
                        <label>
                            <input type="radio" name="editVisibility" value="private" required>
                            <span>Privé</span>
                        </label>
                    </div>
                </div>

                <div class="w-full flex flex-row justify-start">
                    <button type="button" id="cancelEdit" class="bg-transparent font-bold border py-3 px-6 rounded-full" style="color: black; border-color: black;">
                        Annuler
                    </button>
                    <button type="submit" class="bg-transparent font-bold border border-black ml-3 py-3 px-6 rounded-full">
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div id="productDeletion">
        <div class="Deletion-container">
            <h2 class="text-[16px] font-bold">Supprimer le Produit</h2>
            <div>
                <button id="cancelDeletionBtn" class="bg-transparent font-bold border py-3 px-6 rounded-full" style="color: black; border-color: black;">
                    Annuler
                </button>
                <button id="deleteBtn" class="bg-transparent font-bold border ml-3 py-3 px-6 rounded-full" style="color: red; border-color: red;">
                    Supprimer
                </button>
            </div>
        </div>
    </div>

    <div id="settingsPopup">
        <div class="settings-container">
            <div class="header">
                <svg id="closeSettingsBtn" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                    <path fill="#000000" fill-rule="evenodd" d="M10.707085,3.70711 C11.097605,3.31658 11.097605,2.68342 10.707085,2.29289 C10.316555,1.90237 9.683395,1.90237 9.292865,2.29289 L4.292875,7.29289 C3.902375,7.68342 3.902375,8.31658 4.292875,8.70711 L9.292865,13.7071 C9.683395,14.0976 10.316555,14.0976 10.707085,13.7071 C11.097605,13.3166 11.097605,12.6834 10.707085,12.2929 L6.414185,8 L10.707085,3.70711 Z"/>
                </svg>
                <h2 class="text-[16px] font-bold">Settings</h2>
                <span></span>
            </div>
            <ul id="settingTitles" class="flex flex-row gap-3">
                <li class="bg-black text-white px-4 py-2 rounded-full border border-black cursor-pointer hover:bg-black hover:text-white">Contenus web</li>
                <li class="px-4 py-2 rounded-full border border-black cursor-pointer hover:bg-black hover:text-white">Security</li>
            </ul>

            <form id="webContentSettings" class="setting-box active">

                <div class="flex flex-row gap-3">
                    <div class="mb-4 w-full">
                        <label for="brandName">Nom de la Boutique</label>
                        <input type="text" id="brandName" name="brandName" placeholder="Entrez le nom de la boutique" required>
                    </div>
                </div>

                <div class="flex flex-row gap-3">
                    <div class="mb-4 w-full">
                        <label for="brandNameFirst">Nom premier</label>
                        <input type="text" id="brandNameFirst" name="brandNameFirst" placeholder="Entrez le nom de la boutique">
                    </div>
                    <div class="mb-4 w-full">
                        <label for="brandNameSec">Nom second</label>
                        <input type="text" id="brandNameSec" name="brandNameSec" placeholder="Entrez le nom de la boutique">
                    </div>
                </div>

                <div class="mb-4 w-full">
                    <label for="description">Bio</label>
                    <textarea id="brandBio" name="brandBio" placeholder="Entrez le bio de la boutique " rows="4" required></textarea>
                </div>
                
                <div class="flex flex-row gap-3">
                    <div class="mb-4 w-full">
                        <label for="brandEmail">Email de la Boutique</label>
                        <input type="email" id="brandEmail" name="brandEmail" placeholder="Entrez le nom de la boutique" required>
                    </div>

                    <div class="mb-4 w-full">
                        <label for="brandTel">Numero de telephone de la boutique</label>
                        <input type="tel" id="brandTel" name="brandTel" placeholder="Entrez le nom du produit" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label>Visibilite du developeur</label>
                    <div class="radio-group">
                        <label>
                            <input type="radio" name="devVisivility" value="show" required>
                            <span>Afficher</span>
                        </label>
                        <label>
                            <input type="radio" name="devVisivility" value="hide" required>
                            <span>Cacher</span>
                        </label>
                    </div>
                </div>

                <div class="w-full flex flex-row justify-start">
                    <button type="button" id="webContentResetForm" class="bg-transparent font-bold border py-3 px-6 rounded-full" style="color: black; border-color: black;">
                        réinitialiser
                    </button>
                    <button type="submit" class="bg-black text-white font-bold border border-black ml-3 py-3 px-6 rounded-full">
                        Enregistrer
                    </button>
                </div>

            </form>

            <div id="securitySettings" class="setting-box">

                <form id="adminForm">
                    <h3>Identification de l'admin</h3>
                    <div class="flex flex-row gap-3">
                        <div class="mb-4 w-full">
                            <input type="text" id="adminIdentity" name="adminIdentity" placeholder="Entrez l'identite" required>
                        </div>

                        <div class="mb-4 w-full">
                            <input type="text" id="adminPassword" name="adminPassword" placeholder="Entrez le mot" required>
                        </div>
                    </div>

                    <div class="w-full flex flex-row justify-start">
                        <button type="button" id="adminResetButton" class="bg-transparent font-bold border py-3 px-6 rounded-full" style="color: black; border-color: black;">
                            réinitialiser
                        </button>
                        <button type="submit" class="bg-black text-white font-bold border border-black ml-3 py-3 px-6 rounded-full">
                            Enregistrer
                        </button>
                    </div>

                </form>
                <hr>
                <form id="authForm">
                    <h3>Identification d'autorisation</h3>
                    <div class="flex flex-row gap-3">
                        <div class="mb-4 w-full">
                            <input type="text" id="authIdentity" name="authIdentity" placeholder="Entrez l'identite" required>
                        </div>

                        <div class="mb-4 w-full">
                            <input type="text" id="authPassword" name="authPassword" placeholder="Entrez le mot de passe" required>
                        </div>
                    </div>

                    <div class="w-full flex flex-row justify-start">
                        <button type="button" id="authResetButton" class="bg-transparent font-bold border py-3 px-6 rounded-full" style="color: black; border-color: black;">
                            réinitialiser
                        </button>
                        <button type="submit" class="bg-black text-white font-bold border border-black ml-3 py-3 px-6 rounded-full">
                            Enregistrer
                        </button>
                    </div>

                </form>
                
            </div>

        </div>
    </div>

    <div id="categoryManager">
        <div id="editContainer" class="edit-container">
            <div class="header">
                <svg id="closeCotegoriesBtn" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                    <path fill="#000000" fill-rule="evenodd" d="M10.707085,3.70711 C11.097605,3.31658 11.097605,2.68342 10.707085,2.29289 C10.316555,1.90237 9.683395,1.90237 9.292865,2.29289 L4.292875,7.29289 C3.902375,7.68342 3.902375,8.31658 4.292875,8.70711 L9.292865,13.7071 C9.683395,14.0976 10.316555,14.0976 10.707085,13.7071 C11.097605,13.3166 11.097605,12.6834 10.707085,12.2929 L6.414185,8 L10.707085,3.70711 Z"/>
                </svg>
                <h2 class="text-[16px] font-bold">Categories</h2>
                <span></span>
            </div>
            <div class="top flex flex-row gap-3 justify-between">
                <input id="searchCategory" class="bg-transparent border border-black rounded-full font-normal w-[300px] py-3 px-6 focus:outline-none placeholder:text-gray-700" type="search" name="searchCategory" placeholder="Rechercher une categorie">
                <button id="newCategorieBtn" class="bg-black text-white ml-3 py-3 px-3 rounded-full">
                    Ajouter
                </button>
            </div>
            <form id="newCategoryForm" class="mid">
                <input type="text" id="name" name="name" placeholder="Entrez le nom du produit" required>
                <div class="flex flex-row justify-start gap-3 w-full">
                    <button type="button" id="cancelCategorieAddition" class="border border-black text-black py-3 px-3 rounded-full">
                        Annuler
                    </button>
                    <button type="submit" id="addCategorieBtn" class="bg-black text-white ml-3 py-3 px-3 rounded-full">
                        Ajouter la categorie
                    </button>
                </div>
            </form>

            <div id="categoryManagerContainer" class="bottom flex flex-col gap-3 w-full">
                <?php if (empty($categories)): ?>
                    <div class="font-bold text-xl text-gray-500 flex items-center justify-center w-full py-12">Aucune catégorie trouvée</div>
                <?php else: ?>
                    <?php foreach ($categories as $category): ?>
                        <div class="categorie flex flex-row items-center justify-between gap-3 py-3 px-6 border rounded-xl">
                            <span class="font-bold"><?= htmlspecialchars($category['name'], ENT_QUOTES, 'UTF-8') ?></span>
                            <div class="flex">
                                <button class="border text-black ml-3 py-3 px-6 rounded-full deleteCategorie" data-id="<?= $category['id'] ?>">
                                    Supprimer
                                </button>
                                <button class="border text-black ml-3 py-3 px-6 rounded-full confirmCategorieDeletion" style="display: none; border-color: red; color: red;" data-id="<?= $category['id'] ?>">
                                    Confirmer
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

        </div>
    </div>

    
    <script src="../src/scripts/global.js"></script>
    <script src="../src/scripts/settings.js"></script>
    <script src="../src/scripts/adminLogout.js"></script>
    <script src="../src/scripts/searchProduct.js"></script>
    <script src="../src/scripts/categoryFilter.js"></script>
    <script src="../src/scripts/newProduct.js"></script>
    <script src="../src/scripts/productDeletion.js"></script>
    <script src="../src/scripts/editProduct.js"></script>
    <script src="../src/scripts/categories.js"></script>

</body>
</html>