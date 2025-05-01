<?php
    function log_header_request($request_header, $ip) {
        include "db_credits.php";

        $db = "pico_log";
        $connection = mysqli_connect($host, $log_account, $log_account_pass, $db);
    
        $sql = "INSERT INTO `request_headers` (val,ip) VALUES (?,?);";
        $stmt = $connection -> prepare($sql);
        $stmt -> bind_param("ss", $request_header,$ip);
        $stmt -> execute();
        $stmt -> close();
    
        mysqli_close($connection);
    }

    function log_boot_ack($pico_id, $pico_desc, $ip, $additional_data = "") {
        include "db_credits.php";

        $db = "pico_boot";
        $connection = mysqli_connect($host, $log_account, $log_account_pass, $db);
    
        $sql = "INSERT INTO `boot` (pico_id, pico_desc, additional_data, ip) VALUES (?,?,?,?);";
        $stmt = $connection -> prepare($sql);
        $stmt -> bind_param("isss", $pico_id, $pico_desc, $additional_data, $ip);
        $stmt -> execute();
        $stmt -> close();
    
        mysqli_close($connection);
    }
?>