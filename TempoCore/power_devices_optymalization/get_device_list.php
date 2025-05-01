<?php
    ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
    function get_devices() {
        include_once __DIR__."/../../db_credits.php";

        $connection = mysqli_connect($host ,$log_account ,$log_account_pass, "pico_devices_id");

        $query = "SELECT * FROM power_devices_id WHERE 1";

        $result = $connection -> query($query);
        $devices = [];
        while ($r = $result -> fetch_assoc()) { 
            $devices[] = [$r["device_id"],$r["device_desc"]];
        }

        mysqli_close($connection);
        return $devices;
    }


?>