<?php
/* adatbázis kapcsolat */
// include()  // warning, ha nem sikerül
// include_once()
// require();  // error, ha nem sikerül
require_once("dbconfig.php"); // csak egyszer emeli be
try {
  $dbconn = new PDO(
    DBTYPE.
    ":host=".DBHOST.
    ";dbname=".DBNAME.
    ";charset=".DBCHARSET,
    DBUSER, DBPASSWORD
  );
  $dbconn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  $error = "Adatbázis kapcsolódási hiba: ".$e->getMessage();
}
?>