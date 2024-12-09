<?php
session_start();

// Még eléggé WIP

require_once("../config/config.php");
require_once(BASE_DIR."db/dbconnect.php");

if (empty($_SESSION["user"])){
  echo "nincs bejelentkezve";
  die();
}


//if ($_SERVER["REQUEST_METHOD"]=="POST")


if ($_SESSION["user"]["type"] != "dealer")
{
  echo "forbidden";
  die();
}
/*echo "<pre>";
print_r($_SESSION);
echo "</pre>";*/
// include(BASE_DIR."update/updateuserek.php");

// updateOnline($dbconn);


?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>css/profil.css">
    <script>
        const BASE_DIR = '<?= BASE_DIR ?>';
        const BASE_URL = '<?= BASE_URL ?>';
    </script>
    <script src="<?= BASE_URL ?>jquery-3.7.1.min.js"></script>
    <script src="<?= BASE_URL ?>js/profil.js"></script>
</head>
<body>
<?php include BASE_DIR.'menu.php'; ?>

<div class="profile-container">
    <div class="tabs">
        <button class="tab-link active" data-target="bookings">Kereskedés info</button>
        <button class="tab-link" data-target="conversations">Üzlet foglalásai</button>
        <button class="tab-link" data-target="reviews">Üzenetek</button>
        <button class="tab-link" data-target="profile">Kereskedői dolgozók</button>
    </div>
    <div class="tab-content" id="bookings">
        <h2></h2>
        <?php

        ?>
        <!-- -->
    </div>
    <div class="tab-content" id="conversations">
        <h2>Beszélgetések</h2>
    </div>
    <div class="tab-content" id="reviews">
        <h2>Véleményeim</h2>
        <!-- -->
    </div>
    <div class="tab-content" id="profile">
        <h2>Profil adatok</h2>
        <!-- -->
    </div>
    <?php

    ?>
</div>

</body>
</html>