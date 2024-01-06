<?php
    if (!isset($_GET[""])) {
        include("report_error.php");
        error_report("", "request", $pico_request_header);
        exit(501);
    }

    function error_report($error, $type, $reportData) {
        include "db_credits.php";

        $db = "pico_errors";
        $connection = mysqli_connect($host, $log_account, $log_account_pass, $db);
    
        $sql = "INSERT INTO `$type` (val, known_vals) VALUES (?, ?);";
        $stmt = $connection -> prepare($sql);
        $stmt -> bind_param("ss", $error, $reportData);
        $stmt -> execute();
        $stmt -> close();
    
        mysqli_close($connection);
    }

?>