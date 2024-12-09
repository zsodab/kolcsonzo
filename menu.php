<?php

//session_start();
$error = "";
$msg = "";

//Csak include-al lehet elérni, urlből nem
if (basename($_SERVER['PHP_SELF']) == "menu.php") 
{
    die();
}

/* ha van cookie-ként mentett userID, automatikusa bejelentkeztetjük */
if (!empty($_COOKIE["user"]) && !empty($dbconn))
{
    $cookie = $_COOKIE["user"];
    $cookie = stripslashes($cookie);
    $cookieData = json_decode($cookie, true);
    try 
    {
        $sqlCookie = "
        SELECT ou.id AS id, u.fullname AS fullname
        FROM user u
        JOIN onlineUser ou ON u.id = ou.userID
        WHERE ou.id=:userID
        ";
        $queryCookie = $dbconn->prepare($sqlCookie);
        $queryCookie->bindValue("userID",$cookieData["id"]);
        $queryCookie->execute();
        if ($queryCookie->rowCount()!=1)
        {
            throw new UserException("Hibás mentett felhasználó");
        }
        $user = $queryCookie->fetch(PDO::FETCH_ASSOC);
        $_SESSION["user"] = $user;  // bejelentkeztetés: session-be mentés
        setcookie("user",$_COOKIE["user"],time() + 86400 * 2); // cookie lejáratának frissítése
    } catch (UserException $e)
    {   
        $error = "Cookie hiba: ".$e->getMessage();
    } catch (PDOException $e)
    {
        $error = "Adatbázis hiba automatikus bejelentkeztetéskor: ".$e->getMessage();
    }
  }


?>


<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>css/menu.css">
    <link rel="icon" type="image/x-icon" href="<?= BASE_URL ?>kepek/favicon.png">
    
</head>
<body>
    
<?= !empty($error) ? "<p class=\"error\">$error</p>\n" : "" ?>
<?= !empty($msg) ? "<p class=\"msg\">$msg</p>\n" : "" ?>

    <div class="menu">
        <div class="menu-left">
            <a href="<?= BASE_URL ?>index.php">Főoldal</a>
            <a href="<?= BASE_URL ?>autoink.php">Autóink</a>
            <a href="<?= BASE_URL ?>telephelyeink.php">Telephelyeink</a>
            <a href="<?= BASE_URL ?>rolunk.php">Rólunk</a>
        </div>
        <div class="menu-right">
            <?php
            if (isset($_SESSION["user"])){
                $username = $_SESSION["user"]["username"];
                //Ha nem a profil oldalon vagyunk, akkor a profil linket is megjelenítjük, ha igen, akkor csak a felhasználónevet
                if (basename($_SERVER['PHP_SELF']) != "profil.php") {
                    echo "<a href=\"". BASE_URL ."profil.php\" data-username=\"$username\">Profil</a>";
                } else 
                {
                    echo "<span>$username</span>";
                }
                echo "<a href=\"". BASE_URL ."index.php?logout\">Kijelentkezés</a>";
            } else {
                echo "<a href=\"". BASE_URL ."bejelentkezes.php\">Bejelentkezés</a>";
            }?>
        </div>
    </div>
</body>
</html>
