<?php
    $result = "NO data";
    if (!isset($_GET["registers"])){
        exit(501);
    }

    $regi = $_GET["registers"];
    $regi = explode("||", $regi);
    foreach ($regi as $key => $value) {
        $value = explode("|", $value);
        if ($value[0] == "16") {
            include "../../db_credits.php";
            $d = file_get_contents("http://192.168.1.45?action=getRegisters&registers=%3C||%3E11%3C||%3E");
            $d = explode("|", $d);
            $wathours    = ((intval($d[17]) << 24) | (intval($d[18]) << 16) | (intval($d[15]) << 8) | intval($d[16]));

            $db = "pico_devices_dev1";
            $connection = mysqli_connect($host, $log_account, $log_account_pass, $db);
            
            $sql = "INSERT INTO `power_before_reset` (val) VALUES (?);";
            $stmt = $connection -> prepare($sql);
            $stmt -> bind_param("i", $wathours);
            $stmt -> execute();
            $stmt -> close();

            mysqli_close($connection);
        }
    }

    $result = file_get_contents("http://192.168.1.45?action=sendRegisters&registers=%3C||%3E".$_GET["registers"]."%3C||%3E");


    echo $result;
?>