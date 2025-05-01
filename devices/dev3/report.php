<?php
    ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
    $internal  = [

    ];
    $external  = [

    ];
    $power  = [

    ];
    $service  = [

    ];
    foreach($_POST as $key => $value) {
        if (strpos($key, "internal_")        !== false) {
            $k = substr($key, 9);
            $internal[$k] = $value;
        } else if (strpos($key, "external_") !== false) {
            $k = substr($key, 9);
            $external[$k] = $value;
        } else if (strpos($key, "power_")    !== false) {
            $k = substr($key, 6);
            $power[$k] = $value;
        } else if (strpos($key, "service_")  !== false) {
            $k = substr($key, 8);
            $k = explode("_", $k);
            $service[$k[1]][$k[0]] = $value;
        }
    }
    //file_put_contents("test0.txt", print_r( $_POST    ,true));
    //file_put_contents("test1.txt", print_r( $internal ,true));
    //file_put_contents("test2.txt", print_r( $external ,true));
    //file_put_contents("test3.txt", print_r( $power    ,true));
    //file_put_contents("test4.txt", print_r( $service  ,true));



    include "db_credits.php";

    $db = "pico_devices_dev3";
    $connection = mysqli_connect($host, $log_account, $log_account_pass, $db);
    $sql = "INSERT INTO `status` (`id`, `group1`, `group2`, `group3`, 
                                        `switch_up`, `switch_down`, 
                                        `harmonogram_1`, `harmonogram_2`, `harmonogram_3`, 
                                        `heatAndOff_1`, `heatAndOff_2`, `heatAndOff_3`, 
                                        `force_on_1`, `force_on_2`, `force_on_3`, 
                                        `disable_1`, `disable_2`, `disable_3`, 
                                        `esco_1`, `esco_2`, `dark_sensor`, 
                                        `temp_co_tresh`, `temp_boiler_tresh`, `time`) VALUES 
                                    (?, ?, ?, ?, 
                                        ?, ?, 
                                        ?, ?, ?, 
                                        ?, ?, ?, 
                                        ?, ?, ?, 
                                        ?, ?, ?, 
                                        ?, ?, ?, 
                                        ?, ?, CURRENT_TIMESTAMP);";
    $stmt = $connection -> prepare($sql);
    $stmt -> bind_param("iiiissiiiiiiiiiiiiiiiii",
                    $internal["id"],
                    $internal["group1"],$internal["group2"],$internal["group3"],
                    $internal["switch_up"],$internal["switch_down"],
                    $internal["harmonogram_1"],$internal["harmonogram_2"],$internal["harmonogram_3"],
                    $internal["heatAndOff_1"],$internal["heatAndOff_2"],$internal["heatAndOff_3"],
                    $internal["force_on_1"],$internal["force_on_2"],$internal["force_on_3"],
                    $internal["disable_1"],$internal["disable_2"],$internal["disable_3"],
                    $internal["esco_1"],$internal["esco_2"],$internal["dark_sensor"],
                    $internal["temp_co_tresh"],$internal["temp_boiler_tresh"]
                );
    $stmt -> execute();
    $stmt -> close();

    $sql = "INSERT INTO `status_external` (`id`, `harmonogram_1`, `harmonogram_2`, `harmonogram_3`, 
                                                `heatAndOff_1`, `heatAndOff_2`, `heatAndOff_3`, 
                                                `force_on_1`, `force_on_2`, `force_on_3`, 
                                                `disable_1`, `disable_2`, `disable_3`, 
                                                `temp_co_tresh`, `temp_boiler_tresh`, `time`) VALUES 
                                            (?, ?, ?, ?, 
                                             ?, ?, ?, 
                                             ?, ?, ?, 
                                             ?, ?, ?, 
                                             ?, ?, CURRENT_TIMESTAMP);";
    $stmt = $connection -> prepare($sql);
    $stmt -> bind_param("iiiiiiiiiiiiiii",
                    $external["id"],
                    $external["harmonogram_1"],$external["harmonogram_2"],$external["harmonogram_3"],
                    $external["heatAndOff_1"],$external["heatAndOff_2"],$external["heatAndOff_3"],
                    $external["force_on_1"],$external["force_on_2"],$external["force_on_3"],
                    $external["disable_1"],$external["disable_2"],$external["disable_3"],
                    $external["temp_co_tresh"],$external["temp_boiler_tresh"]
                );
    $stmt -> execute();
    $stmt -> close();

    $sql = "INSERT INTO `power` (`id`, 
                                 `voltage`, `amps`, `wats`, 
                                 `wathours`, `powerfactor`, `frequency`, `time`) VALUES 
                                 (?, 
                                 ?, ?, ?, 
                                 ?, ?, ?, CURRENT_TIMESTAMP);";
    $stmt = $connection -> prepare($sql);
    $stmt -> bind_param("idddidd",
                    $power["id"],
                    $power["voltage"],$power["amps"],$power["wats"],
                    $power["wathours"],$power["powerfactor"],$power["frequency"]
                );
    $stmt -> execute();
    $stmt -> close();
    foreach ($service as $val) {
        $sql = "INSERT INTO `services` (`id`, `name`,`status`, `sub_status`, 
                                        `timestamp`, `work_time`, `exec_main_status`, 
                                        `start_with_system`) 
                                        VALUES (null,?, ?, ?, ?, ?, ?, ?);";
        $stmt = $connection -> prepare($sql);
        $stmt -> bind_param("ssssiii",
                        $val["name"],
                        $val["ActiveState"],$val["SubState"],$val["ActiveEnterTimestamp"],
                        $val["timeRunning"],$val["ExecMainStatus"],$val["UnitFileState"]
                    );
        $stmt -> execute();
        $stmt -> close();
    }

    mysqli_close($connection);


    echo "fine";

    exit(0);

?>