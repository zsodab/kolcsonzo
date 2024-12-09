<?php
session_start();

// Még mindig WIP!TM

require_once("config/config.php");
require_once("db/dbconnect.php");
//require_once("update/updateuserek.php");

if (empty($_SESSION["user"])){
  header("location:bejelentkezes.php");
  die();
}

//Elkapjuk az adatot amit foglalás indításakor VAGY véleményezéskor kapunk (meh)
$requestCarID = 0;
$requestType = "asd";
if ($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST["submitInquiry"]))
{
  $requestType = "newBooking";
  $requestCarID = $_POST["carID"];
} else if ($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST["submitConversation"]))
{
  $requestType = "convSubmitted";
}

//Nem mindenkinek ugyanaz a profilja
$userType = $_SESSION["user"]["type"];
/*echo "<pre>";
print_r($_SESSION);
echo "</pre>";*/

//updateOnline($dbconn);

?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
    <link rel="stylesheet" type="text/css" href="css/profil.css">
    <script>
        const BASE_DIR = '<?= addslashes(BASE_DIR) ?>';
        const BASE_URL = '<?= addslashes(BASE_URL) ?>';
        const requestCarID = '<?= $requestCarID ?>';
        var requestType = '<?= $requestType ?>';
    </script>
    <script src="js/jquery-3.7.1.min.js"></script>
    <script src="js/profil.js"></script>
</head>
<body>
<?php include 'menu.php'; ?>

<div class="profile-container">
    <div class="tabs">
        <button class="tab-link active" data-target="bookings">Foglalásaim</button>
        <button class="tab-link" data-target="conversations">Üzenetek</button>
        <button class="tab-link" data-target="reviews">Véleményeim</button>
        <button class="tab-link" data-target="profile">Profil adatok</button>
        <?= $userType == "admin" ? "<a href=\"profile/admin.php\" class=\"tab-link\">Admin felület</a>" : "" ?>
        <?= $userType == "dealer" ? "<a href=\"profile/dealer.php\" class=\"tab-link\">Kereskedői felület</a>" : "" ?>
    </div>

    <div class="new-booking" id=newBooking>
   <!-- Itt lesz a foglalás indítás formja -->
    </div>


    <div class="tab-content" id="bookings">
        <h2></h2>
        <div class="car-container" id="car-results">
    <!--  -->
        </div>
    </div>
    <div class="tab-content" id="conversations" requestType="<?=$requestType?>">
        <h2>Beszélgetések</h2>
        <div class="sub-tab">
          <button class="sub-link active" id="conv-open" data-target="convList">Nyitott</button>
          <button class="sub-link" id="conv-closed" data-target="convList">Lezárt</button>
        </div>
        <div class="conversations-content" id="convList">

          <!--  -->
        </div>
    </div>
    <div class="tab-content" id="reviews">
        <h2>Véleményeim</h2>
        <!-- -->
    </div>
    <div class="tab-content" id="profile">
        <h2>Profil adatok</h2>
        <!-- -->
    </div>

</div>

</body>
</html>