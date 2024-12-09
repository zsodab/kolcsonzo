<?php
require_once(BASE_DIR."db/dbconnect.php");

// Offline (sima user) json frissítése
function updateOffline($dbconn)
{
    if (!empty($dbconn)) 
    {
        try 
        {
            $sqlUser = "SELECT * FROM user u LEFT JOIN onlineUser ou ON u.id = ou.userID WHERE ou.userID IS NULL";
            $queryUser = $dbconn->query($sqlUser);
            $users = $queryUser->fetchAll(PDO::FETCH_ASSOC);

            $file = fopen(BASE_DIR."json/userOffline.json", "w") or die("Nem lehet megnyitni a fájlt!");
            fwrite($file, json_encode($users, JSON_UNESCAPED_UNICODE));
            fclose($file);
        } 
        catch (PDOException $e) 
        {
            echo "Hiba az adatbázis elérésekor!" + $e->getMessage();
        }
    }
}

// Online (felhasználó, admin, dealer) json frissítése
function updateOnline($dbconn)
{
    if (!empty($dbconn)) 
    {
        try 
        {
            $sqlUser = "SELECT u.*, ou.username, a.id as adminID, d.id as dealerID, d.dshipID 
            FROM user u JOIN onlineUser ou ON u.id = ou.userID
            LEFT JOIN admin a ON u.id = a.oUserID
            LEFT JOIN dealer d ON u.id = d.oUserID";
            $queryUser = $dbconn->query($sqlUser);
            $result = $queryUser->fetchAll(PDO::FETCH_ASSOC);
            $users = [];
            foreach ($result as $user)
            {
                if ($user["adminID"] != NULL)
                {
                    $users["adminID"][$user['adminID']] = $user;
                }
                else if ($user["dealerID"] != NULL)
                {
                    $users["dealer"][] = $user;
                }
                else
                {
                    $users["user"][] = $user;
                }
            }
            // echo "<pre>";
            // print_r($users);
            // echo "</pre>";

            $file = fopen(BASE_DIR."json/userOnline.json", "w") or die("Nem lehet megnyitni a fájlt!");
            fwrite($file, json_encode($users, JSON_UNESCAPED_UNICODE));
            fclose($file);
        } 
        catch (PDOException $e) 
        {
            echo "Hiba az adatbázis elérésekor!" + $e->getMessage();
        }
    }
}




?>