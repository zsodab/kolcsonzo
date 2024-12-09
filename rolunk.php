<?php
session_start();
require_once("config/config.php");
//ha minden megvan majd ez se statikus lesz

?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/rolunk.css">
    <title>Rólunk</title>

</head>
<body>
    <?php include 'menu.php'; ?> 

    <div class="content">
        <h1>Rólunk</h1>
        <p>

            Cégünk 2005 óta működik sikeresen az autóbérlés piacán. Az elmúlt években több ezer elégedett ügyfelünk vette igénybe szolgáltatásainkat. 
            Számunkra kiemelten fontos, hogy a bérlés folyamata gyors, egyszerű és problémamentes legyen. 
            Széles autóflottával és kedvező árakkal állunk rendelkezésre, hogy minden ügyfelünk megtalálja a számára legmegfelelőbb járművet.

        </p>
        

        <h2>Autóbérlési áraink</h2>
        <table>
            <thead>
                <tr>
                    <th>Évjárat</th>
                    <th>Ár (1 napra)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>2008 - 2010</td>
                    <td>8 000 Ft</td>
                </tr>
                <tr>
                    <td>2011 - 2014</td>
                    <td>10 000 Ft</td>
                </tr>
                <tr>
                    <td>2015 - 2019</td>
                    <td>12 000 Ft</td>
                </tr>
                <tr>
                    <td>2020 - 2024</td>
                    <td>15 000 Ft</td>
                </tr>
            </tbody>
        </table>

        <h2>Ügyfélvélemények</h2>
        <div class="ratings-container">
            <div class="ratings-slider">
                <?php 
                    $reviews = [
                        ["Kovács Péter", "Nagyon elégedett vagyok az autóval és a gyors ügyintézéssel!", "★★★★★"],
                        ["Szabó Éva", "Korrekt árak és megbízható autók.", "★★★★☆"],
                        ["Varga Tamás", "Minden rendben ment, az autó tiszta és jól felszerelt volt.", "★★★★★"],
                        ["Nagy Andrea", "Jó tapasztalat, de az ügyfélszolgálaton még van mit fejleszteni.", "★★★☆☆"],
                        ["Molnár Zoltán", "Szuper élmény volt az autóbérlés, köszönöm!", "★★★★★"],
                        ["Kiss Noémi", "Gyors kiszolgálás és remek autók.", "★★★★☆"],
                        ["Tóth László", "Rugalmas ügyintézés, ajánlom másoknak is.", "★★★★★"],
                        ["Papp Anna", "Nagyon segítőkész volt a csapat.", "★★★★☆"],
                        ["Székely Balázs", "Megbízható autók, barátságos árak.", "★★★★★"],
                        ["Horváth Dóra", "Minden igényt kielégítettek, elégedett vagyok.", "★★★★★"],
                        ["Kiss Bálint", "Nagyon jó minőségű autók és udvarias kiszolgálás.", "★★★★☆"],
                        ["József Gábor", "Szeretem, hogy mindig új autókat kínálnak, köszönöm.", "★★★★★"]
                    ];

                    foreach ($reviews as $review) {
                        echo "<div class='rating-card'>
                                <p><strong>{$review[0]}</strong></p>
                                <p>{$review[1]}</p>
                                <div class='stars'>{$review[2]}</div>
                              </div>";
                    }
                ?>
            </div>

            <span class="arrow arrow-left" onclick="moveSlider(-1)">&#8592;</span>
            <span class="arrow arrow-right" onclick="moveSlider(1)">&#8594;</span>
        </div>
    </div>

    <script>
        const slider = document.querySelector('.ratings-slider');
        const cardCount = <?php echo count($reviews); ?>;
        const visibleCards = 3; // Egyszerre látható kártyák
        let currentIndex = 0;

        // Automatikus csúsztatás
        setInterval(() => {
            currentIndex = (currentIndex + visibleCards) % cardCount;
            slider.style.transform = `translateX(-${currentIndex * (100 / visibleCards)}%)`;
        }, 10000);

        // Manuális csúsztatás
        function moveSlider(direction) {
            currentIndex = (currentIndex + direction * visibleCards + cardCount) % cardCount;
            slider.style.transform = `translateX(-${currentIndex * (100 / visibleCards)}%)`;
        }
    </script>
</body>
</html>
