<?php
    function ping($id,$ip) {
        include "db_credits.php";

        $db = "pico_boot";
        $connection = mysqli_connect($host, $log_account, $log_account_pass, $db);
    
        $sql = 'INSERT INTO ping (pico_id, ip) VALUES ('.$id.', "'.$ip.'");';
        $stmt = $connection -> prepare($sql);
        $stmt -> execute();
        $stmt -> close();
    
        mysqli_close($connection);
    }
?>