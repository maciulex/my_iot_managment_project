<?php
    function log_header_request($request_header) {
        include "db_credits.php";

        $db = "pico_log";
        $connection = mysqli_connect($host, $log_account, $log_account_pass, $db);
    
        $sql = "INSERT INTO `request_headers` (val) VALUES (?);";
        $stmt = $connection -> prepare($sql);
        $stmt -> bind_param("s", $request_header);
        $stmt -> execute();
        $stmt -> close();
    
        mysqli_close($connection);
    }

    function log_boot_ack($pico_id, $pico_desc, $additional_data = "") {
        include "db_credits.php";

        $db = "pico_boot";
        $connection = mysqli_connect($host, $log_account, $log_account_pass, $db);
    
        $sql = "INSERT INTO `boot` (pico_id, pico_desc, additional_data) VALUES (?,?,?);";
        $stmt = $connection -> prepare($sql);
        $stmt -> bind_param("iss", $pico_id, $pico_desc, $additional_data);
        $stmt -> execute();
        $stmt -> close();
    
        mysqli_close($connection);
    }
?>