<?php
    function getOwnHarmonogram() {
        include "db_credits.php";

        $db = "pico_devices_dev6";
        $connection = mysqli_connect($host, $log_account, $log_account_pass, $db);

        $sql = "SELECT `id`, `weekday`, `time`, `action`, `action_on_startup` FROM `harmonogram` ORDER BY weekday, time, id ASC;";
        $stmt = $connection -> prepare($sql);
        $stmt -> execute();
        $stmt -> bind_result($id, $weekday, $time, $action, $action_on_startup);
        
        $data = [];
        while ($stmt -> fetch()) {
            $val = strval($weekday)."|".strval($time)."|".strval($action)."|".strval($action_on_startup);
            array_push($data,$val);
        }
        
        $stmt -> close();

        mysqli_close($connection);

        return "<||>".implode("||",$data)."<||>";
    }
?>