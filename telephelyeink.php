<?php
session_start();
require_once("config/config.php");
//Szintén csak temp amíg nincs még minden kész sql-el

?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/telephelyeink.css">
    <title>Telephelyeink</title>

</head>
<body>
    <?php include 'menu.php'; ?>

    <div class="content">
        <h1>Telephelyeink</h1>
        
        <div class="city-selector">
            <div class="city-option" style="background-image: url('kepek/szeged.jpg');" onclick="scrollToSection('szeged')">
                <span>Szeged</span>
            </div>
            <div class="city-option" style="background-image: url('kepek/budapest.jpg');" onclick="scrollToSection('budapest')">
                <span>Budapest</span>
            </div>
            <div class="city-option" style="background-image: url('kepek/debrecen.jpg');" onclick="scrollToSection('debrecen')">
                <span>Debrecen</span>
            </div>
        </div>

        <div class="section" id="szeged">
            <h2>Szeged</h2>
            <div class="map">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2747.288232017851!2d20.149813715636644!3d46.25479807911819!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47448b3b6e7a27ad%3A0xabcde!2sKossuth%20Lajos%20utca%205!5e0!3m2!1shu!2shu!4v1698403200000!5m2!1shu!2shu"
                    width="100%" height="100%" frameborder="0" allowfullscreen>
                </iframe>
            </div>
            <div class="opening-hours">
                Nyitvatartás: Hétfő-Péntek 8:00-18:00, Szombat 9:00-13:00, Vasárnap zárva.
            </div>
            <div class="attractions">
                <h3>Helyi ízelítő:</h3>
                <div class="attractions-grid">
                    <div class="attraction">
                        <h4>Széchenyi tér</h4>
                        <p>A Széchenyi tér Szeged zöld szíve, ahol gyönyörű sétányok és épületek találhatóak.</p>
                    </div>
                    <div class="attraction">
                        <h4>Fogadalmi templom</h4>
                        <p>Az ikonikus dóm lenyűgöző neogótikus stílusban épült, és a város egyik jelképe.</p>
                    </div>
                    <div class="attraction">
                        <h4>Vadaspark</h4>
                        <p>Modern állatkert, ahol a világ számos pontjáról származó állatokat láthatunk.</p>
                    </div>
                    <div class="attraction">
                        <h4>Tisza-part</h4>
                        <p>Kiváló hely piknikezésre és romantikus sétákra a folyó mentén.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="section" id="budapest">
            <h2>Budapest</h2>
            <div class="map">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2662.1325023341787!2d19.05553961563671!3d47.49789717917656!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4741dcda6c110001%3A0xabcdef!2sAndrássy%20út%2010!5e0!3m2!1shu!2shu!4v1698403200001!5m2!1shu!2shu" 
                    width="100%" height="100%" frameborder="0" allowfullscreen>
                </iframe>
            </div>
            <div class="opening-hours">
                Nyitvatartás: Hétfő-Péntek 8:00-18:00, Szombat 9:00-14:00, Vasárnap zárva.
            </div>
            <div class="attractions">
                <h3>Helyi ízelítő:</h3>
                <div class="attractions-grid">
                    <div class="attraction">
                        <h4>Parlament</h4>
                        <p>Lenyűgöző épület, a magyar demokrácia központja.</p>
                    </div>
                    <div class="attraction">
                        <h4>Lánchíd</h4>
                        <p>Az első állandó híd a Duna felett, amely Budapestet összeköti.</p>
                    </div>
                    <div class="attraction">
                        <h4>Buda vár</h4>
                        <p>Világörökségi helyszín lenyűgöző kilátással a városra.</p>
                    </div>
                    <div class="attraction">
                        <h4>Margit-sziget</h4>
                        <p>A város zöld szigete futópályával és gyönyörű parkokkal.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="section" id="debrecen">
            <h2>Debrecen</h2>
            <div class="map">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2694.6441263182046!2d21.623816715636583!3d47.529919179177066!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47470cde5d123456%3A0xabc123!2sPiac%20utca%208!5e0!3m2!1shu!2shu!4v1698403200002!5m2!1shu!2shu" 
                    width="100%" height="100%" frameborder="0" allowfullscreen>
                </iframe>
            </div>
            <div class="opening-hours">
                Nyitvatartás: Hétfő-Péntek 8:00-18:00, Szombat 9:00-12:00, Vasárnap zárva.
            </div>
            <div class="attractions">
                <h3>Helyi ízelítő:</h3>
                <div class="attractions-grid">
                    <div class="attraction">
                        <h4>Református Nagytemplom</h4>
                        <p>Az ország egyik legnagyobb temploma lenyűgöző belső térrel.</p>
                    </div>
                    <div class="attraction">
                        <h4>Debreceni Egyetem</h4>
                        <p>A magyar felsőoktatás egyik legrégebbi intézménye.</p>
                    </div>
                    <div class="attraction">
                        <h4>Nagyerdő</h4>
                        <p>Egy csodás park sétányokkal és szabadtéri színházzal.</p>
                    </div>
                    <div class="attraction">
                        <h4>MODEM</h4>
                        <p>Modern művészeti kiállítások otthona, amely új élményeket nyújt.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function scrollToSection(id) {
            document.getElementById(id).scrollIntoView({ behavior: 'smooth' });
        }
    </script>
</body>
</html>
