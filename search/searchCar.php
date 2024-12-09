<?php
session_start();

//megakadályozzuk hogy URL-ből hozzáférjenek
if ($_SERVER["REQUEST_METHOD"] != "POST") 
{
    echo "forbidden";
    die();
}

include_once(__DIR__. '/../config/config.php'); //Csak include, mert lehet a searchCart olyan hívja meg ami másik helyen van de passzolja neki már
require_once(BASE_DIR."db/dbconnect.php");

try 
{
    $selectedLocation = $_POST["location"];
    $selectedAvailable = $_POST["onlyAvailable"];
    $selectedProps = [];
    /*echo "<pre>";
            print_r($_POST);
            echo "</pre>";*/
    foreach ($_POST as $key => $value) 
    {
        if ($key != "location" && !empty($value) && $key != "onlyAvailable" && $key != "listCars") 
        {
            $selectedProps[$key] = $value;
        }
    }

    /*
    SQL parancs összefűzse stringbe, csak a megadott paraméterekkel keresünk
    */
    $sql = "SELECT *, c.id AS carID FROM car c JOIN dealership d ON c.dealerID = d.id WHERE d.city = \"$selectedLocation\" AND ";
    foreach ($selectedProps as $key => $value)
    {
        $sql .= "c.$key=:$key AND ";
    }

    if ($selectedAvailable == 1) 
    {
        $sql .= "c.isAvailable = " . $selectedAvailable;
    } else 
    {
        $sql = substr($sql, 0, -4);
    }


    $query = $dbconn->prepare($sql);
    foreach ($selectedProps as $key => $value) 
    {
        $query->bindValue($key, $value, PDO::PARAM_STR);
    }

    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    /*
     nice
    */
    foreach ($result as $car) 
    {
        echo "<div id={$car['carID']} dealer-id={$car['dealerID']} class='car-box'>
              <h3>{$car['brand']} {$car['model']} ({$car['year']})</h3>";
              if ($car['isAvailable'] != 1)
              {
                echo "<br><em>(Jelenleg nem elérhető)</em></br>";
              }
        echo "
              <img src='{$car['picture']}' alt='{$car['brand']} {$car['model']}' />
              <p>Kapacitás: {$car['capacity']} fő</p>
              <p>Üzemanyag: {$car['fuelType']} ({$car['fuelConsumption']}l/100km)</p>";
        $tierIdur = 1;
        $tierIdur += $car['tierIduration'];
        echo "<p>Ár 2-{$car['tierIduration']} napig: {$car['tierIprice']}Ft / nap </p>
              <p>Kaució: {$car['depositAmount']} Ft</p>
              <div class='hidden-info' style='display:none;'><p>Ár {$tierIdur}-{$car['tierIIduration']} napig: {$car['tierIIprice']}Ft / nap </p>";
        if ($car['tierCustomNotes'] != NULL) 
        {
            echo "<p>További árak: {$car['tierCustomNotes']}</p>";
        }
        echo "<p>Leírás: {$car['description']}</p>";
        // if ($car['isAvailable'] != 1) 
        // {
        //     echo "<p>Ez az autó jelenleg nem elérhető.</p>";
        // }
        echo "<p>Telefonon érdeklődni a {$car['phone']} számon lehet.</p>";
        if (empty($_SESSION["user"])) 
        {
            echo "<button class='denied-inquiry-btn'>További információért kérjük jelentkezzen be!</button>";
        } else 
        {
            $sqlActiveBooking = "SELECT hasActiveBooking FROM user WHERE id = :userID";
            $queryActiveBooking = $dbconn->prepare($sqlActiveBooking);
            $queryActiveBooking->bindValue("userID", $_SESSION["user"]["id"], PDO::PARAM_INT);
            $queryActiveBooking->execute();
            $resultActiveBooking = $queryActiveBooking->fetch(PDO::FETCH_ASSOC);
            if ($resultActiveBooking["hasActiveBooking"] == 1) 
            {
                echo "<button class='denied-inquiry-btn'>Már van aktív foglalása!</button>";
            } else if ($car['isAvailable'] != 1)
            {
                echo "<button class='denied-inquiry-btn'>Ez az autó jelenleg nem elérhető. Kérjük érdeklődjön a fenti telefonszámon.</button>";
            }
            else 
            {
                echo '
                <form action="profil.php#tab=conversations" method="POST">
                <input type="hidden" name="carID" value="' . $car['carID'] . '">
                <input type="hidden" name="dealerID" value="' . $car['dealerID'] . '">
                <input type="hidden" name="submitInquiry" value="submitInquiry">
                <button type="submit" id="online-inquiry-btn" class="online-inquiry-btn">Szeretném lefoglalni!</button>
                </form>
                ';
            }
        }
        echo "</div>
              </div>";
    }
    // echo "<pre>";
    // print_r($result);
    // echo "</pre>";
} catch (PDOException $e) 
{
    $error = "Hiba az adatbázis elérésekor!" + $e->getMessage();
}
?>