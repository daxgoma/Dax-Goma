


<?php

session_start();

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

    // Filter the products array to include only those with 'visibility' set to 'public'
    $products = array_filter($products, function($product) {
        return isset($product['visibility']) && $product['visibility'] === 'public';
    });

    // Shuffle products to display them in random order
    shuffle($products);
    
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
  <title>Stationova</title>
</head>
<body class="flex justify-center items-center bg-white">

    <nav id="nav" class="flex py-2">
        <div class="flex items-center justify-start gap-[20px]">
            <h1 class="font-semibold"><?php echo $brandNameFirst; ?><span class="text-gray-500"><?php echo $brandNameSec; ?></span></h1>
            <input id="search" class="hidden bg-transparent border border-black rounded-full font-normal w-[300px] py-3 px-6 focus:outline-none placeholder:text-black" type="search" name="search" id="search" placeholder="Rechercher une article">
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
                    <span>À propos de nous</span>
                </a>
            </li>
            <li>
                <a href="./cartPublic.php">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M19.5 8.25H16.5V7.75C16.5 6.55653 16.0259 5.41193 15.182 4.56802C14.3381 3.72411 13.1935 3.25 12 3.25C10.8065 3.25 9.66193 3.72411 8.81802 4.56802C7.97411 5.41193 7.5 6.55653 7.5 7.75V8.25H4.5C4.16848 8.25 3.85054 8.3817 3.61612 8.61612C3.3817 8.85054 3.25 9.16848 3.25 9.5V18C3.25 18.7293 3.53973 19.4288 4.05546 19.9445C4.57118 20.4603 5.27065 20.75 6 20.75H18C18.7293 20.75 19.4288 20.4603 19.9445 19.9445C20.4603 19.4288 20.75 18.7293 20.75 18V9.5C20.75 9.16848 20.6183 8.85054 20.3839 8.61612C20.1495 8.3817 19.8315 8.25 19.5 8.25ZM9 7.75C9 6.95435 9.31607 6.19129 9.87868 5.62868C10.4413 5.06607 11.2044 4.75 12 4.75C12.7956 4.75 13.5587 5.06607 14.1213 5.62868C14.6839 6.19129 15 6.95435 15 7.75V8.25H9V7.75ZM19.25 18C19.25 18.3315 19.1183 18.6495 18.8839 18.8839C18.6495 19.1183 18.3315 19.25 18 19.25H6C5.66848 19.25 5.35054 19.1183 5.11612 18.8839C4.8817 18.6495 4.75 18.3315 4.75 18V9.75H7.5V12C7.5 12.1989 7.57902 12.3897 7.71967 12.5303C7.86032 12.671 8.05109 12.75 8.25 12.75C8.44891 12.75 8.63968 12.671 8.78033 12.5303C8.92098 12.3897 9 12.1989 9 12V9.75H15V12C15 12.1989 15.079 12.3897 15.2197 12.5303C15.3603 12.671 15.5511 12.75 15.75 12.75C15.9489 12.75 16.1397 12.671 16.2803 12.5303C16.421 12.3897 16.5 12.1989 16.5 12V9.75H19.25V18Z" fill="#000000"/>
                    </svg>
                    <span class="cart-span">Mon panier</span>
                </a>
            </li>
        </ul>
    </nav>

    <!-- Home Section -->
    <section id="home" class="bg-gray-100 flex flex-row items-end py-[75px]">
        <div class="w-[50%] text-gray-500">
            <span class="font-semibold text-[14px]">Bienvenue à</span>
            <h1 id="welcommeBrand" class="text-[75px] text-black font-semibold"><?php echo $brandNameFirst; ?><span class="text-gray-400"><?php echo $brandNameSec; ?></span></h1>
            <span class="text-[18px] text-black font-semibold">Boutique en Ligne</span>
            <p class="mt-10">
                <?php echo nl2br($brandBio); ?>
            </p>
            <div class="flex align-center mt-10">
                <button onclick="scrollToPoint()" class="bg-black text-white py-4 px-6 rounded-full">
                    Nos articles
                </button>
            </div>
        </div>
        <div class="w-[50%] flex flex-col items-end justify-end">
            <div class="flex flex-col items-end gap-[10px]">
                <a href="admin.php" class="px-4 py-2 rounded-full border border-black cursor-pointer hover:bg-black hover:text-white">
                    Admin
                </a>
                <a href="hidden.php" class="3 px-4 py-2 rounded-full border border-black cursor-pointer hover:bg-black hover:text-white">
                    Auth
                </a>
            </div>
        </div>
    </section>
    
    <!-- Articles Section -->
    <section id="StartBuying" class="py-12 pb-[50px]">

        <ul id="categoryUl" class="flex flex-row gap-3 mb-10">
            <li class="bg-black text-white px-4 py-2 rounded-full border border-black cursor-pointer hover:bg-black hover:text-white" data-category="all">Tout</li>
            <?php foreach ($randomCategories as $category): ?>
                <li class="px-4 py-2 rounded-full border border-black cursor-pointer hover:bg-black hover:text-white" data-category="<?= htmlspecialchars($category['name'], ENT_QUOTES, 'UTF-8') ?>">
                    <?= htmlspecialchars($category['name'], ENT_QUOTES, 'UTF-8') ?>
                </li>
            <?php endforeach; ?>
        </ul>

        <div id="productsContainer" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">

            <div id="noProductMessage" class="no-products-message font-bold text-xl text-gray-500 hidden items-center justify-center w-full py-12">
                Aucun produit trouvé
            </div>

            <?php
            $cart = $_SESSION['cart'] ?? [];

            foreach ($products as $product): 
                $isActive = in_array($product['id'], $cart) ? 'active' : '';
            ?>
                <div class="article bg-white rounded-xl border overflow-hidden" data-category="<?php echo htmlspecialchars($product['category'], ENT_QUOTES, 'UTF-8'); ?>" data-product-id="<?php echo $product['id']; ?>">
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
                        <div class="article-btns flex flex-row gap-3 items-center mb-4">
                            <a href="product.php?id=<?php echo $product['id']; ?>" target="_blank" class="buy-btn bg-black text-white text-center w-[calc(100%-50px)] px-4 py-2 rounded-full text-center block">
                                Acheter
                            </a>
                            <svg id="addToCart" class="<?php echo $isActive; ?>" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M19.5 8.25H16.5V7.75C16.5 6.55653 16.0259 5.41193 15.182 4.56802C14.3381 3.72411 13.1935 3.25 12 3.25C10.8065 3.25 9.66193 3.72411 8.81802 4.56802C7.97411 5.41193 7.5 6.55653 7.5 7.75V8.25H4.5C4.16848 8.25 3.85054 8.3817 3.61612 8.61612C3.3817 8.85054 3.25 9.16848 3.25 9.5V18C3.25 18.7293 3.53973 19.4288 4.05546 19.9445C4.57118 20.4603 5.27065 20.75 6 20.75H18C18.7293 20.75 19.4288 20.4603 19.9445 19.9445C20.4603 19.4288 20.75 18.7293 20.75 18V9.5C20.75 9.16848 20.6183 8.85054 20.3839 8.61612C20.1495 8.3817 19.8315 8.25 19.5 8.25ZM9 7.75C9 6.95435 9.31607 6.19129 9.87868 5.62868C10.4413 5.06607 11.2044 4.75 12 4.75C12.7956 4.75 13.5587 5.06607 14.1213 5.62868C14.6839 6.19129 15 6.95435 15 7.75V8.25H9V7.75ZM19.25 18C19.25 18.3315 19.1183 18.6495 18.8839 18.8839C18.6495 19.1183 18.3315 19.25 18 19.25H6C5.66848 19.25 5.35054 19.1183 5.11612 18.8839C4.8817 18.6495 4.75 18.3315 4.75 18V9.75H7.5V12C7.5 12.1989 7.57902 12.3897 7.71967 12.5303C7.86032 12.671 8.05109 12.75 8.25 12.75C8.44891 12.75 8.63968 12.671 8.78033 12.5303C8.92098 12.3897 9 12.1989 9 12V9.75H15V12C15 12.1989 15.079 12.3897 15.2197 12.5303C15.3603 12.671 15.5511 12.75 15.75 12.75C15.9489 12.75 16.1397 12.671 16.2803 12.5303C16.421 12.3897 16.5 12.1989 16.5 12V9.75H19.25V18Z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

        </div>

    </section>


    <footer class="w-full bg-gray-100 flex flex-col">
        <div class="top flex flex-row items-end justify-between py-[25px]">
            <div class="left flex flex-col">
                <h1 id="welcommeBrand" class="text-[50px] text-black font-semibold"><?php echo $brandNameFirst; ?><span class="text-gray-400"><?php echo $brandNameSec; ?></span></h1>
                <div class="flex flex-row gap-3">
                    <span class="bg-gray-300 rounded-full p-4"></span>
                    <span class="bg-gray-300 rounded-full p-4"></span>
                    <span class="bg-gray-300 rounded-full p-4"></span>
                </div>
            </div>
            <div class="right flex flex-row gap-3">
                <a href="./apropos.php" class="px-4 py-2 rounded-full border border-black cursor-pointer hover:bg-black hover:text-white">À propos</a>
            </div>
        </div>
        <div class="bottom flex flex-row items-center justify-between py-[30px] border-t border-gray-300">
            <div class="left flex flex-col gap-3">
                <span>Boutique en Ligne</span>
                <span>&copy; <?php echo date("Y"); ?> Stationova. Tous droits réservés.</span>
            </div>
            <?php

                // Check if devVisibility is set to "show"
                if (isset($webContent['devVisivility']) && $webContent['devVisivility'] === 'show') {
                    ?>
                    <div class="right flex flex-col items-end gap-3">
                        <span>By Joachim Paluku</span>
                        <span>joachimpaluk@gmail.com</span>
                    </div>
                    <?php
                }
            ?>
        </div>
    </footer>

    <script src="../src/scripts/global.js"></script>
    <script src="../src/scripts/searchProduct.js"></script>
    <script src="../src/scripts/categoryFilter.js"></script>
    <script src="../src/scripts/cart.js"></script>

    <script>

        const brandLogo = document.querySelector("nav div h1");

        // JavaScript to show the div after scrolling down to 50vh
        window.addEventListener('scroll', function() {
            // Get the current scroll position
            const scrollPosition = window.scrollY;
            // Get the viewport height (50% of it)
            const viewportHeight = window.innerHeight / 2;

            // Check if the user has scrolled down past 50vh
            if (scrollPosition >= viewportHeight) {
                document.getElementById('search').style.display = 'block';
                document.getElementById('nav').style.background = 'white';
                brandLogo.classList.add("hide-brand");
            } else {
                document.getElementById('search').style.display = 'none';
                document.getElementById('nav').style.background = 'rgba(255, 255, 255, 0.062)';
                brandLogo.classList.remove("hide-brand");
            }
        });

    </script>

    <script>

        function scrollToPoint() {
            const element = document.getElementById('StartBuying');
            const topPos = element.offsetTop - 30;

            window.scrollTo({
                top: topPos, // Scrolls to the vertical position of the targetElement
                behavior: 'smooth' // Smooth scroll
            });
        }

    </script>

</body>
</html>