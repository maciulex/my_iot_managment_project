<?php
    ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);


    $voltage     = floatval($_GET["V"]);
    $ampere      = floatval($_GET["A"]);
    $kwh         = floatval($_GET["kwh"]);
    $wats        = floatval($_GET["wat"]);
    $powerFactor = floatval($_GET["PF"]);
    $frequency   = floatval($_GET["freq"]);


    include "db_credits.php";

    $db = "pico_devices_dev5";
    $connection = mysqli_connect($host, $log_account, $log_account_pass, $db);
    $sql = "INSERT INTO `power` (`voltage`, `amps`, `wats`, `wathours`, `powerfactor`, `frequency`) VALUES (?,?,?,?,?,?)";
    $stmt = $connection -> prepare($sql);
    $stmt -> bind_param("dddddd",
                    $voltage,
                    $ampere,
                    $wats,
                    $kwh,
                    $powerFactor,
                    $frequency
                );
    $stmt -> execute();
    $stmt -> close();

    mysqli_close($connection);


    echo "fine";

    exit(0);

?>