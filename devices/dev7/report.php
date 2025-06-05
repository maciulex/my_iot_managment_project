<?php
    ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);


    $test     = floatval($_GET["somedataheader"]);



    include "db_credits.php";

    $db = "pico_devices_dev7";
    $connection = mysqli_connect($host, $log_account, $log_account_pass, $db);
    $sql = "INSERT INTO `db_test` (`val`) VALUES (?)";
    $stmt = $connection -> prepare($sql);
    $stmt -> bind_param("d",
                    $test
                );
    $stmt -> execute();
    $stmt -> close();

    mysqli_close($connection);

    echo "fine";
    echo $_GET["somedataheader"];

    exit(0);

?>