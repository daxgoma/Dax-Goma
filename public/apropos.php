


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
$brandEmail = $webContent['brandEmail'] ?? 'Default Brand Email';
$brandTel = $webContent['brandTel'] ?? 'Default Brand Tel';
?>








<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="../dist/styles.css" rel="stylesheet">
  <title>Stationova · À propos</title>
</head>
<body>

    <nav id="nav" class="flex py-2">
        <div class="flex items-center justify-start gap-[20px]">
            <h1 class="font-semibold">Statio<span class="text-gray-500">nova</span></h1>
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

    <footer class="section-footer w-full bg-gray-100 flex flex-col">
        <div class="top flex flex-row items-end justify-between py-[25px]">
            <div class="left flex flex-col">
                <h1 id="welcommeBrand" class="text-[50px] text-black font-semibold"><?php echo $brandNameFirst ?><span class="text-gray-400"><?php echo $brandNameSec ?></span></h1>
                <div class="flex flex-row gap-3 mb-4">
                    <span class="bg-gray-300 rounded-full p-4"></span>
                    <span class="bg-gray-300 rounded-full p-4"></span>
                    <span class="bg-gray-300 rounded-full p-4"></span>
                </div>
                <span class="text-[18px] text-black font-semibold">Boutique en Ligne</span>
                <p class="about-bio mt-10 w-[600px] text-gray-500"><?php echo $brandBio ?></p>
                <div class="about-contact flex flex-col gap-3 mt-10 mb-4">
                    <span><?php echo $brandEmail ?></span>
                    <span><?php echo $brandTel ?></span>
                </div>
                <div class="flex flex-row gap-3">
                    <span class="Bowl bg-gray-300 rounded-full cursor-pointer"></span>
                    <span class="Bowl bg-gray-300 rounded-full cursor-pointer"></span>
                </div>
            </div>
            <div class="right flex flex-row gap-3">
                <a href="admin.php" class="about-admin-btn px-4 py-2 rounded-full border border-black cursor-pointer hover:bg-black hover:text-white">Admin</a>
            </div>
        </div>
        <div class="bottom flex flex-row items-center justify-between py-[30px] border-t border-gray-300">
            <?php

            // Check if devVisibility is set to "show"
            if (isset($webContent['devVisivility']) && $webContent['devVisivility'] === 'show') {
                ?>
                <div class="left flex flex-col gap-3">
                    <span>Boutique en Ligne</span>
                </div>
                <?php
            }
            ?>

            <div class="right flex flex-col gap-3">
                <span>&copy; <?php echo date("Y") ?> Stationova. Tous droits réservés.</span>
            </div>
        </div>
    </footer>

    <script src="../src/scripts/global.js"></script>

</body>
</html>