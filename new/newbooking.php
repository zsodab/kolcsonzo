<?php
session_start();
include_once(__DIR__. '/../config/config.php');
require_once(BASE_DIR."db/dbconnect.php");


if ($_SERVER["REQUEST_METHOD"] != "POST") 
{
    echo "forbidden";
    die();
}



try 
{
        $carID = $_POST["carID"];

        echo '<div class="car-container" id="new-booking-results">';
        echo "<div class='car-box'>";
        echo '<form action="profil.php#tab=conversations" method="POST">
              <h2>Foglalás igénylése erre: </h2>';
        $sqlNewBooking = "
        SELECT c.brand as brand, c.model as model, c.year as year, c.picture as picture, d.city as city, d.name as dealerName
        FROM car c JOIN dealership d ON c.dealerID = d.id
        WHERE c.id = :carID
        ";
        $queryNewBooking = $dbconn->prepare($sqlNewBooking);
        $queryNewBooking->bindValue("carID",$carID);
        $queryNewBooking->execute();
        $resultNewBooking = $queryNewBooking->fetch(PDO::FETCH_ASSOC);
        echo "<img src=\"".BASE_URL."{$resultNewBooking['picture']}\" alt=\"{$resultNewBooking['brand']} {$resultNewBooking['model']}\">";
        echo "<h3>{$resultNewBooking['brand']} {$resultNewBooking['model']} ({$resultNewBooking['year']})</h3>";
        echo "<p>{$resultNewBooking['city']} - {$resultNewBooking['dealerName']}</p>";
        echo '
        <p>
            <label for="pickup-date">Felvétel dátuma</label>
            <input type="date" id="pickup-date" name="pickup-date" required>
        </p>
        <p>
        <label for="return-date">Visszavétel dátuma</label>
            <input type="date" id="return-date" name="return-date" required>
            <input type="hidden" name="carID" required>
        </p>
        <p><textarea name="message" placeholder="Üzenet" required></textarea></p>
        <p class="checkbox-container">
            <input type="checkbox" id="callback" name="callback" class="custom-checkbox">
            <label for="callback">Visszahívást kérek!</label>
        </p>
        <input type="hidden" name="submitConversation" value="submitConversation">
        <p><button class="tab-link" type="submit" id="new-conversation-btn">Foglalás igénylése</button></p>
        </form>
        </div>
        </div>';

}
catch (PDOException $e) 
{
    echo "error";
    die();
}

?>