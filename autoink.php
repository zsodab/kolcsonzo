<?php
session_start();
$error = "";
$msg = "";

class UserException extends Exception {} // kivételosztály a felhasználói hiábkra

require_once("config/config.php");

require_once("db/dbconnect.php");  // adatbáziskapcsolat beemelése

require_once("update/updateautoink.php");
updateAutok($dbconn);



//Elérhető városok
//!ELMÉLETILEG! lehetséges hogy a dbconn szar de jsonból ki lehet közben olvasni, de az nem valószínű

$locations = [];
if (!empty($dbconn)) {
    try {
        $sql = "SELECT DISTINCT city FROM dealership";
        $query = $dbconn->query($sql);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row) {
            $locations[] = $row['city'];
        }
    } catch (PDOException $e) {
        $error = "Hiba az adatbázis elérésekor!";
    }
}

?>



<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autókölcsönző</title>
    <link rel="stylesheet" type="text/css" href="css/autoink.css">
    <script>
        const BASE_DIR = '<?= addslashes(BASE_DIR) ?>';
        const BASE_URL = '<?= addslashes(BASE_URL) ?>';
    </script>
    <script src="js/jquery-3.7.1.min.js"></script>
    <script src="js/autoink.js"></script>

</head>

<body>
<?php include 'menu.php'; ?>

<div class="search-panel">
    <h2>Autók keresése</h2>
    <form id="search-form">
        <div class="form-row">
            <div class="form-group">
                <label for="location">Helyszín</label>
                <select id="location" name="location" required>
                    <option value=''>Válasszon várost</option>
                    <?php
                    foreach ($locations as $location) {
                        echo "<option value='$location'>$location</option>\n";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="brand">Márka</label>
                <select id="brand" name="brand">
                    <option value=''></option>
                    <!-- ajax moment -->
                </select>
            </div>
            <div class="form-group">
                <label for="model">Modell</label>
                <select id="model" name="model">
                    <option value=''></option>
                    <!-- -->
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="year">Évjárat</label>
                <select id="year" name="year">
                    <option value=''></option>
                    <!--  -->
                </select>
            </div>
            <div class="form-group">
                <label for="fuelType">Üzemanyag típus</label>
                <select id="fuelType" name="fuelType">
                    <option value=''></option>
                    <!--  -->
                </select>
            </div>
            <div class="form-group">
                <label for="onlyAvailable">Csak jelenleg elérhetők</label>
                <select id="onlyAvailable" name="onlyAvailable">
                    <option value="1">Igen</option>
                    <option value="0">Nem</option>
                </select>
            </div>
        </div>
        <button type="submit" class="btn">Keresés</button>
        <button type="button" id="reset-button" class="btn">Alapértelmezett</button>
    </form>
</div>
<div class="error">
        <?= !empty($error) ? "<p class=\"error\">$error</p>\n" : "" ?>
        <?= !empty($msg) ? "<p class=\"msg\">$msg</p>\n" : "" ?>
</div>


<div class="car-container" id="car-results">
    <!-- Itt lesznek az autók -->
</div>

<div id="overlay"></div>
<div id="large-box">
    <button id="close-btn">Bezárás</button>
    <div id="large-box-content">
        <!-- Itt lesz az autó nagy képe -->
    </div>
</div>

</body>

</html>