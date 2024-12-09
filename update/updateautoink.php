<?php
require_once(BASE_DIR."db/dbconnect.php");

/*
Igazából csak egy JSON fájlba tárolja az autók adatait kereséshez,
akkor van csak meghívva, ha adatbázisban az autók adatai változnak.
*/

function updateAutok($dbconn)
{
    $error = "";
    $availableCars = [];

    if (!empty($dbconn)) 
    {
        try 
        {
            $sql = "
            SELECT 
                dealership.city, 
                car.brand, 
                car.model, 
                car.year, 
                car.fuelType
            FROM 
                car 
            JOIN 
                dealership 
            ON 
                car.dealerID = dealership.id
            ORDER BY 
                dealership.city, car.brand, car.model, car.year, car.fuelType";

            $query = $dbconn->query($sql);
            $results = $query->fetchAll(PDO::FETCH_ASSOC);

            foreach ($results as $row) 
            {
                $availableCars[$row["city"]][$row["brand"]][$row["model"]][$row["year"]][] = $row["fuelType"];
            }

            $file = fopen(BASE_DIR."json/autoink.json", "w") or die("Nem lehet megnyitni a fájlt!");
            fwrite($file, json_encode($availableCars, JSON_UNESCAPED_UNICODE));
            fclose($file);

            // echo "<pre>";
            // print_r($availableCars);
            // echo "</pre>";

        } 
        catch (Exception $e) 
        {
            $error = $e->getMessage();
            return $error;
        }
    }

    return $availableCars;
}