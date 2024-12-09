<?php
session_start();
$error = "";
$msg = "";

//majd ez is mind adatbázisból lesz lekérve de az már nagyon a vége

class UserException extends Exception{}

require_once("config/config.php");
//require_once("db/dbconnect.php");

if ($_SERVER["REQUEST_METHOD"]=="GET" && isset($_GET["logout"])){
    unset($_SESSION["user"]);
    setcookie("user","",time()-1);
    unset($_COOKIE["user"]); 
  }

?>



<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Főoldal</title>
    <link rel="stylesheet" type="text/css" href="css/index.css">
</head>
<body>
    <?php include 'menu.php'; ?>

    <section class="hero blur">
        <h1>Köszöntjük az oldalon!</h1>
        <p>Béreljen autót egyszerűen és gyorsan, minden alkalomra!</p>
        <a href="autoink.php" class="btn">Keressen autót most!</a>
    </section>

    <section class="featured-cars blur">
        <h2>Kiemelt autók</h2>
        <div class="car-container">
            <div class="car-box">
                <h3>Audi A8 (2019)</h3>
                <img src="kepek/autok/audi.jpg" alt="audi">
                <div class="rating-details">
                    <p>Ügyfélértékelések: 4.5/5</p>
                    <!--<a href="details.php?id=1" class="btn">Részletek</a>-->
                </div>
            </div>
            <div class="car-box">
                <h3>BMW X5 (2020)</h3>
                <img src="kepek/autok/bmw.jpg" alt="bmw">
                <div class="rating-details">
                    <p>Ügyfélértékelések: 4.7/5</p>
                    <!--<a href="details.php?id=2" class="btn">Részletek</a>-->
                </div>
            </div>
        </div>
    </section>


    <section class="services blur">
        <h2>Miért válasszon minket?</h2>
        <div class="service-item">
            <img src="kepek/fast_booking.jpg" alt="Gyors foglalás">
            <h3>Gyors foglalás</h3>
            
        </div>
        <div class="service-item">
            <img src="kepek/reliable_cars.jpg" alt="Megbízható autók">
            <h3>Megbízható autók</h3>
            
        </div>
        <div class="service-item">
            <img src="kepek/great_prices.jpg" alt="Kedvező árak">
            <h3>Kedvező árak</h3>
            
        </div>
    </section>

    <section class="testimonials blur">
        <h2>Ügyfeleink véleménye</h2>
        <div class="testimonial-item">
            <p>"Nagyon gyors és megbízható szolgáltatás, az autó tökéletes állapotban volt!"</p>
            <p>– Péter, Budapest</p>
        </div>
        <div class="testimonial-item">
            <p>"A legjobb ár-érték arány, amit találtam. Csak ajánlani tudom."</p>
            <p>– Anna, Szeged</p>
        </div>
    </section>

    <section class="contact blur">
        <h2>Lépjen velünk kapcsolatba!</h2>
        <p>E-mail: <a href="mailto:info@kolcsonauto.hu">info@kolcsonauto.hu</a></p>
        <p>Telefon: <a href="tel:+36203333333">+36 20 3333 333</a></p>
        <p>Cím: 1195 Budapest, Kossuth Lajos u. 5</p>
    </section>
</body>
</html>
