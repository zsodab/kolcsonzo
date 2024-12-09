<?php


session_start();
require_once("config/config.php");
require_once("db/dbconnect.php");
$error = "";
$msg = "";

class UserException extends Exception{} // kivételosztály a felhasználói hiábkra

if (!empty($_SESSION["user"])){
  header("location:profil.php");
  die();
}



// Bejelentkezés
if ($_SERVER["REQUEST_METHOD"]=="POST" &&
    isset($_POST["submitLogin"]) &&
    !empty($dbconn)){
  try{
    $username = htmlspecialchars(trim($_POST["username"]));
    $password = htmlspecialchars(trim($_POST["password"]));
    if (empty($username) || empty($password)){
      throw new UserException("Adja meg mindkét adatot");
    }
    $sqlLogin = "
    SELECT ou.id AS id, ou.username AS username, ou.password AS password, u.fullname AS fullname
    FROM user u
    JOIN onlineUser ou ON u.id = ou.userID
    WHERE ou.username=:username
    ";
    $queryLogin = $dbconn->prepare($sqlLogin);
    $queryLogin->bindValue("username",$username,PDO::PARAM_STR);
    $queryLogin->execute();
    if ($queryLogin->rowCount()!=1){
      throw new UserException("Hibás felhasználónév");
      $msg = "Hibás felhasználónév"; // teszt
    }
    $user = $queryLogin->fetch(PDO::FETCH_ASSOC);
    if (!password_verify($password,$user["password"])){ // kódolt és nem kódolt jelszó összehasonlítása
      throw new UserException("Hibás jelszó");
    }

    // Megnézzük hogy admin vagy dealer-e
    $sqlUserCheck = 
    "
    SELECT 
      ou.id AS userID,
      CASE
        WHEN a.id IS NOT NULL THEN 'admin'
        WHEN d.id IS NOT NULL THEN 'dealer'
        ELSE 'user'
      END AS userType
    FROM 
      onlineUser ou
    LEFT JOIN 
      admin a ON ou.id = a.oUserID
    LEFT JOIN 
      dealer d ON ou.id = d.oUserID
    WHERE 
      ou.id =:checkID;
    ";
    $queryUserCheck = $dbconn->prepare($sqlUserCheck);
    $queryUserCheck->bindValue("checkID",$user["id"],PDO::PARAM_INT);
    $queryUserCheck->execute();
    $userType = $queryUserCheck->fetch(PDO::FETCH_ASSOC);
    $user["type"] = $userType["userType"];

    $_SESSION["user"] = $user; // sessiont létrehozzuk

    if (isset($_POST["logged"])) // ha bejelentkezve maradok be van pipálva
    {
      $userCookie =array("id"=>$user["id"], "fullname"=>$user["fullname"]);
      $jsonUser = json_encode($userCookie);
      setcookie("user",$jsonUser,time() + 86400 * 2);  // elmenti cookie-ban az azonosítóját és típusát
    }

    header("location:profil.php"); 
    die();
    $msg = "Sikeres bejelentkezés"; // teszt
  } catch (UserException $e){
    $error = "Bejelentkezési hiba: ".$e->getMessage();
  } catch (PDOException $e){
    $error = "Adatbázis hiba bejelentkezéskor: ".$e->getMessage();
  }
}


// Regisztráció
if ($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST["submitReg"]) && !empty($dbconn)) {
    try // Először sima user táblába küldés, aztán onlineuser táblába
    {
    $username = htmlspecialchars(trim($_POST["username"]));
    $password1 = htmlspecialchars(trim($_POST["password1"]));
    $password2 = htmlspecialchars(trim($_POST["password2"]));
    $fullname = htmlspecialchars(trim($_POST["fullName"]));
    $birth = htmlspecialchars(trim($_POST["birth"]));
    $phone = htmlspecialchars(trim($_POST["phone"]));

    if (empty($username) || empty($password1) || empty($password2) || empty($fullname) || empty($birth) || empty($phone))
    {
      throw new UserException("Minden adat kitöltése kötelező!");
    }
    if ($password1 != $password2)
    {
      throw new UserException("A két jelszó nem egyezik.");
    }

    // Megnézzük adatbázisban létezik-e már ilyen felhasználó (username és telefonszám egyedi kell legyen)
    $sqlCheckUser = "SELECT id FROM onlineUser WHERE username=:username";
    $queryCheckUser = $dbconn->prepare($sqlCheckUser);
    $queryCheckUser->bindValue("username",$username,PDO::PARAM_STR);
    $queryCheckUser->execute();
    if ($queryCheckUser->rowCount()>0)
    {
      throw new UserException("Ez a felhasználónév már foglalt.");
    }
    $sqlCheckPhone = "SELECT id FROM user WHERE phone=:phone";
    $queryCheckPhone = $dbconn->prepare($sqlCheckPhone);
    $queryCheckPhone->bindValue("phone",$phone,PDO::PARAM_STR);
    $queryCheckPhone->execute();
    if ($queryCheckPhone->rowCount()>0)
    {
      throw new UserException("Ezen a telefonszámon már regisztráltak.");
    }
    

    // User tábla feltöltése
    $sqlUserReg = "INSERT INTO user (fullname, dateofbirth, phone, hasActiveBooking, registerDate, deleteDate, isDeleted) 
    VALUES (:fullname, :dateofbirth, :phone, 0, NOW(), NULL, 0)";
    $queryUserReg = $dbconn->prepare($sqlUserReg);
    $queryUserReg->bindValue("fullname",$fullname,PDO::PARAM_STR);
    $queryUserReg->bindValue("dateofbirth",$birth,PDO::PARAM_STR);
    $queryUserReg->bindValue("phone",$phone,PDO::PARAM_STR);
    $queryUserReg->execute();

    // Elmentjük az új felhasználó azonosítóját (onlineUser tábla miatt)
    $userID = $dbconn->lastInsertId();
    
    // OnlineUser tábla feltöltése
    $sqlOnlineUserReg = "INSERT INTO onlineUser (username, password, userID) 
    VALUES (:username, :password, :userID)";
    $queryOnlineUserReg = $dbconn->prepare($sqlOnlineUserReg);
    $queryOnlineUserReg->bindValue("username",$username,PDO::PARAM_STR);
    $passwordHash = password_hash($password1,PASSWORD_DEFAULT);
    $queryOnlineUserReg->bindValue("password",$passwordHash,PDO::PARAM_STR);
    $queryOnlineUserReg->bindValue("userID",$userID,PDO::PARAM_INT);
    $queryOnlineUserReg->execute();
    $msg = "Sikeres regisztráció";

    } catch (UserException $e)
    {
    $error = "Regisztrációs hiba: ".$e->getMessage();
    } catch (PDOException $e)
    {
    $error = "Adatmentési hiba: ".$e->getMessage();
    }


}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/bejelentkezes.css">
    <script>
      function toggleRegistrationForm() {
        var form = document.getElementById("registrationForm");
        if (form.style.display === "none") {
          form.style.display = "block";
        } else {
          form.style.display = "none";
        }
      }
    </script>
</head>
<body>

<?= !empty($error) ? "<p class=\"error\">$error</p>\n" : "" ?>
<?= !empty($msg) ? "<p class=\"msg\">$msg</p>\n" : "" ?>

<?php include 'menu.php'; ?>

<div class="container">
  <h1>Bejelentkezés</h1>
  <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">
    <fieldset>
      <legend>Bejelentkezés</legend>
      <input type="text" name="username" placeholder="Felhasználónév" required>
      <input type="password" name="password" placeholder="Jelszó" required>
      <label>Bejelentkezve maradok <input type="checkbox" name="logged"></label>
      <input type="submit" value="Bejelentkezés" name="submitLogin">
    </fieldset>
  </form>   

  <button onclick="toggleRegistrationForm()">Regisztrálni szeretnék</button>

  <div id="registrationForm" style="display:none;">
    <h1>Regisztráció</h1>
    <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">
      <fieldset>
        <legend>Regisztráció</legend>
        <label>Felhasználónév <input type="text" name="username" required></label>
        <label>Jelszó <input type="password" name="password1" required></label>
        <label>Jelszó újra <input type="password" name="password2" required></label>
        <label>Teljes név <input type="text" name="fullName" required></label>
        <label>Születési dátum <input type="date" name="birth" required></label>
        <label>Telefonszám <input type="text" name="phone" required></label>
        <input type="submit" value="Regisztráció" name="submitReg">
      </fieldset>
    </form>
  </div>
</div>
</body>
</html>