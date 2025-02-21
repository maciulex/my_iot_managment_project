<?php
    function get_harmonogram($id) {
        include "db_credits.php";

        $db = "pico_devices_dev".strval($id);
        $connection = mysqli_connect($host, $log_account, $log_account_pass, $db);
    
        $sql = "SELECT dotw, hour, min, action FROM `harmonogram` ORDER BY dotw, hour, min ASC;";
        $stmt = $connection -> prepare($sql);
        $stmt -> execute();
        $stmt -> bind_result($dotw, $hour, $min, $action);
        $data = [];
        while ($stmt -> fetch()) {
            $val = strval(($dotw << 5) + $hour)."|".strval($min)."|".strval($action);
            array_push($data,$val);
        }
        $stmt -> close();
    
        mysqli_close($connection);

        return "<||>".implode("||",$data)."<||>";
    }
    function get_harmonogram2($id) {
        include "db_credits.php";

        $db = "pico_devices_dev".strval($id);
        $connection = mysqli_connect($host, $log_account, $log_account_pass, $db);
    
        $sql = "SELECT dotw, time_start, time_end, action FROM `harmonogram` ORDER BY dotw, time_start ASC;";
        $stmt = $connection -> prepare($sql);
        $stmt -> execute();
        $stmt -> bind_result($dotw, $time_start, $time_end, $action);
        $data = [];
        while ($stmt -> fetch()) {
            $val = $dotw."|".$action."|".$time_start."|".$time_end ;
            array_push($data,$val);
        }
        $stmt -> close();
    
        mysqli_close($connection);

        return implode("||",$data);
    }
?>