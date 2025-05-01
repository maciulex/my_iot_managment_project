<?php
    ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
    set_time_limit(600);
    include __DIR__."/get_device_list.php";

    $devices = get_devices() ;
    print_r($devices);

    include __DIR__."/../../db_credits.php";
    $connection = mysqli_connect($host ,$optymalizer_account ,$optymalizer_account_pass);


    for ($device_indeks = 0; $device_indeks < count($devices); $device_indeks++) {
        $cache = [];
        //$cache["2025"] = ["value": x, "id":null:INT]
        //[2025] <- usage from whole year
        //[id]   <- id in db or null if not exists


        $device_db_name = "pico_devices_dev".strval($devices[$device_indeks][0]);
        $connection -> select_db($device_db_name);

        $query = "SELECT * FROM power WHERE in_optymalization = 0 ORDER BY id ASC";
        $result = $connection -> query($query);
        $last_id = -1;
        while ($row = $result -> fetch_assoc()) {
            $last_id = $row["id"];

            $date_time = strtotime($row["time"]);
            $year_week = date('Y-W'      , $date_time);
            $year      = date("Y"      , $date_time);
            $month     = date("Y-m"    , $date_time); 
            $day       = date("Y-m-d"  , $date_time); 
            $hour      = date("Y-m-d H", $date_time).":00"; 

            $types_id  = [$year_week, $year, $month, $day, $hour];
            $types_names = ["week","year","month","day","hour"];
            foreach ($types_id as $iter =>$id) {
                if (isset($cache[$id])) {
                    //if already in cache just add;
                    $cache[$id]["value"] += $row["change"];
                } else {
                    //check if data preexists in db
                    $exist_check = "SELECT * FROM power_calculation_optymalization WHERE `date` = \"$id\"";
                    $result_ex_ch = $connection -> query($exist_check);
                    if ($r = $result_ex_ch -> fetch_assoc()) {
                        $cache[$id]["value"] = $row["change"] + $r["value"];
                        $cache[$id]["id"] = intval($r["id"]);
                        $cache[$id]["type"] = $types_names[$iter]; 

                    } else {
                        $cache[$id]["value"] = $row["change"];
                        $cache[$id]["id"] = -1;
                        $cache[$id]["type"] = $types_names[$iter]; 
                    }
                }
            }


        }

        $update = 'UPDATE power SET in_optymalization = 1 WHERE in_optymalization = 0 and id <= '.$last_id;

        foreach ($cache as $id => $values){
            if ($values["id"] > -1) {
                $sql = 'UPDATE power_calculation_optymalization SET value = '.$values["value"].' WHERE id = '.$values["id"];
                $connection -> query($sql);
            } else {
                $sql = 'INSERT INTO power_calculation_optymalization (date, value,type) VALUES ("'.$id.'",'.$values["value"].', "'.$values["type"].'")';
                $connection -> query($sql);
            }
        }
        $connection ->query($update);

    }
    
    mysqli_close($connection);
?>