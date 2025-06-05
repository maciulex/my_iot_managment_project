<?php
    ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);

    $voltage     = floatval($_GET["V"])/10;
    $ampere      = floatval($_GET["A"])/1000;
    $kwh         = floatval($_GET["kwh"]);
    $wats        = floatval($_GET["wat"])/10;
    $powerFactor = floatval($_GET["PF"])/100;
    $frequency   = floatval($_GET["freq"])/10;
    $temp        = floatval($_GET["temp"]);



    include "db_credits.php";

    $db = "pico_devices_dev8";
    $connection = mysqli_connect($host, $log_account, $log_account_pass, $db);
    if ($voltage > 100 && $voltage < 300) {
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
    }
    if ($temp > -60 && $temp < 500) {
        $sql = "INSERT INTO `temperature` (`temp`) VALUES (?)";
        $stmt = $connection -> prepare($sql);
        $stmt -> bind_param("d",
                        $temp
                    );
        $stmt -> execute();
        $stmt -> close();
    }
    
    
    //optymalization part (?) :sadge:
    
    
    //$query = "SELECT"
    
    
    mysqli_close($connection);

    echo "fine";

    exit(0);

?>