<?php


session_start();
include_once(__DIR__. '/../config/config.php');
require_once(BASE_DIR."db/dbconnect.php");


if ($_SERVER["REQUEST_METHOD"] != "POST") 
{
    echo "forbidden";
    die();
}
echo "<pre>";
print_r($_POST);
echo "</pre>";

if (!empty($dbconn))
{
    try
    {
        $convStatus = "";
        $userID = $_SESSION["user"]["id"];
        $convStatus = $_POST["target"] == "open" ? 0 : 1;
        $sqlConv = "
        SELECT * FROM conversation 
        JOIN dealership d ON dshipID = d.id JOIN car c ON carID = c.id 
        WHERE isClosed = :convStatus AND isDeleted = 0 AND oUserID = :userID AND type = 'booking'";
        $query = $dbconn->prepare($sqlConv);
        $query->bindValue("convStatus", $convStatus, PDO::PARAM_INT);
        $query->bindValue("userID", $userID, PDO::PARAM_INT);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        if ($query->rowCount() == 0)
        {
            echo "<h2>Nincs megjeleníthető beszélgetés</h2>";
            die();
        }

        /*
        Beszélgetések (nem üzenetek) megjelenítése.
        Megmutatjuk a felhasználónak melyik kereskedővel beszélt, melyik autóról, és mikor.
        Az üzenetek majd másik phpból jelennek meg
        */
        echo "<table>
              <tr>
              <th>Kereskedő</th>
              <th>Autó</th>
              <th>Kezdés</th>
              <th>Lezárás</th>
              </tr>";
        foreach ($result as $row)
        {
            echo "<tr>
                  <td>" . $row["fullname"] . "</td>
                  <td>" . $row["brand"] . " " . $row["model"] . " " . $row["year"] . "</td>
                  <td>" . $row["startedAt"] . "</td>
                  <td>" . $row["closedAt"] . "</td>
                  </tr>";
        }
        echo "</table>";
    } catch (PDOException $e)
    {
        echo "<p>Hiba: " . $e->getMessage()." </p>";
    }
}

?>