<?php
/*
Foglalásokat listáz. WIP
*/

session_start();
include_once(__DIR__. '/../config/config.php');
require_once(BASE_DIR."db/dbconnect.php");



if ($_SERVER["REQUEST_METHOD"] != "POST") 
{
    echo "forbidden";
    die();
}

if (!empty($dbconn))
{
    try
    {
        $userID = $_SESSION["user"]["id"];
        $quickSql = "SELECT hasActiveBooking FROM user WHERE user.id = :userID";
        $quickQuery = $dbconn->prepare($quickSql);
        $quickQuery->bindValue("userID", $userID, PDO::PARAM_INT);
        $quickQuery->execute();
        $quickResult = $quickQuery->fetch(PDO::FETCH_ASSOC);
        if ($quickResult["hasActiveBooking"] == 0)
        {
            echo "<h2>Nincs aktív foglalása</h2>";
            die();
        }
        //booking_data, dealer és car táblák összekapcsolása
        $sql = "
        SELECT 
        bd.status as status,
        bd.datePickup as datePickup,
        bd.dateReturn as dateReturn,
        bd.pricePaid as pricePaid,
        bd.priceEstimate as priceEstimate,
        c.brand as brand,
        c.model as model,
        c.year as year,
        c.picture as picture,
        d.city AS city,
        d.phone AS phone
        FROM booking_data bd
        JOIN car c ON bd.carID = c.id
        JOIN dealership d ON bd.dshipID = d.id
        WHERE bd.status = 'active' AND bd.userID = :userID
        ";
        $query = $dbconn->prepare($sql);
        $query->bindValue("userID", $userID, PDO::PARAM_INT);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $booking) 
        {
            echo "<div class='car-box'>
                  <h3>{$booking['brand']} {$booking['model']} ({$booking['year']})</h3>
                  <img src='{$booking['picture']}' alt='{$booking['brand']} {$booking['model']}' />
                  <p>Státusz: {$booking['status']}</p>
                  <p>Helyszín: {$booking['city']}</p>
                  <p>Telefonszám: {$booking['phone']}</p>
                  <p>Foglalás dátuma: {$booking['datePickup']}</p>
                  <p>Visszavétel dátuma: {$booking['dateReturn']}</p>
                  <p>Eddig fizetett: {$booking['pricePaid']}Ft</p>
                  <p>Végösszeg*: {$booking['priceEstimate']}Ft</p>
                  </div>";
        }
    } catch (PDOException $e) 
    {
        echo "<p>Hiba az adatbázis elérésekor!</p>". $e->getMessage();
    }
}


?>