<?php
    function error_report($error, $type, $reportData, $ip) {
        include "db_credits.php";

        $db = "pico_errors";
        $connection = mysqli_connect($host, $log_account, $log_account_pass, $db);
    
        $sql = "INSERT INTO `$type` (val, known_vals, ip) VALUES (?, ?, ?);";
        $stmt = $connection -> prepare($sql);
        $stmt -> bind_param("sss", $error, $reportData,$ip);
        $stmt -> execute();
        $stmt -> close();
    
        mysqli_close($connection);
    }

?>