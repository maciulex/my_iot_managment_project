<?php

include "db_credits.php";

$temp_c_dht20       = floatval($_GET["temp_c_dht20"]      );  
$temp_c_ds1820      = floatval($_GET["temp_c_ds1820"]     ); 
$humidity_dht20     = floatval($_GET["humidity_dht20"]    );
$pressure_bmp280    = floatval($_GET["pressure_bmp280"]   );
$temperature_bmp280 = floatval($_GET["temperature_bmp280"]);

$db = "pico_devices_dev2";
$connection = mysqli_connect($host, $log_account, $log_account_pass, $db);

$sql = "INSERT INTO temperature (dht20, bmp280, ds1820) VALUES (?, ?, ?);";
$stmt = $connection -> prepare($sql);
$stmt -> bind_param("ddd", $temp_c_dht20, $temperature_bmp280,$temp_c_ds1820);
$stmt -> execute();
$stmt -> close();

$sql = "INSERT INTO pressure (bmp280) VALUES (?);";
$stmt = $connection -> prepare($sql);
$stmt -> bind_param("d", $pressure_bmp280);
$stmt -> execute();
$stmt -> close();

$sql = "INSERT INTO humidity (dht20) VALUES (?);";
$stmt = $connection -> prepare($sql);
$stmt -> bind_param("d", $humidity_dht20);
$stmt -> execute();
$stmt -> close();

mysqli_close($connection);

?>