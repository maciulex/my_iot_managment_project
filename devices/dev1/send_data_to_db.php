<?php
    function send_data_to_db($data, $db_pre = "", $db = "pico_devices_dev1") {
        $value = explode("||",$data);
        
        $DARK_SENSOR_E = -127;
        $ESCO_1_E = -127;
        $ESCO_2_E = -127;
        $TEMP_TRESHOLD_FOR_HEAT_AND_OFF_E = -127;
        $GROUP_1_STATUS_E = -127;
        $GROUP_2_STATUS_E = -127;
        $GROUP_3_STATUS_E = -127;
        $GROUP_1_HARMONOGRAM_E = -127;
        $GROUP_2_HARMONOGRAM_E = -127;
        $GROUP_3_HARMONOGRAM_E = -127;
        $DISABLE_GROUP_1_E = -127;
        $DISABLE_GROUP_2_E = -127;
        $DISABLE_GROUP_3_E = -127;
        $FORCE_ENABLE_GROUP_1_E = -127;
        $FORCE_ENABLE_GROUP_2_E = -127;
        $FORCE_ENABLE_GROUP_3_E = -127;
        $HEAT_AND_OFF_GROUP_1_E = -127;
        $HEAT_AND_OFF_GROUP_2_E = -127;
        $HEAT_AND_OFF_GROUP_3_E = -127;
        $TEMP_TRESHOLD_CO_FOR_HEAT_AND_OFF_E = -127;
        $SWITCH_1_STATE_E = -127;
        $SWITCH_2_STATE_E = -127;

        $temp_reset_required = false;
    
        include "db_credits.php";
        $connection = mysqli_connect($host, $log_account, $log_account_pass, $db);
    
        $return_val = [];
        for ($i = 0; $i < count($value); $i++) {
            $row  = explode("|", $value[$i]);
            $id   = intval($row[0]);
            $size = intval($row[1]);
    
            $data = [];
    
            for ($z = 2; $z < $size+2; $z++) {
                array_push($data, intval($row[$z]));
            }
    
            switch ($id) {
                case 12:
                    $DARK_SENSOR_E = $data[0];
                break;
                case 13:
                    $ESCO_1_E = $data[0];
                break;
                case 14:
                    $ESCO_2_E = $data[0];
                break;
                case 17:
                    $TEMP_TRESHOLD_FOR_HEAT_AND_OFF_E = $data[0];
                break;
                case 18:
                    $GROUP_1_STATUS_E = $data[0];
                break;
                case 19:
                    $GROUP_2_STATUS_E = $data[0];
                break;
                case 20:
                    $GROUP_3_STATUS_E = $data[0];
                break;
                case 21:
                    $GROUP_1_HARMONOGRAM_E = $data[0];
                break;
                case 22:
                    $GROUP_2_HARMONOGRAM_E = $data[0];
                break;
                case 23:
                    $GROUP_3_HARMONOGRAM_E = $data[0];
                break;
                case 24:
                    $DISABLE_GROUP_1_E = $data[0];
                break;
                case 25:
                    $DISABLE_GROUP_2_E = $data[0];
                break;
                case 26:
                    $DISABLE_GROUP_3_E = $data[0];
                break;
                case 27:
                    $FORCE_ENABLE_GROUP_1_E = $data[0];
                break;
                case 28:
                    $FORCE_ENABLE_GROUP_2_E = $data[0];
                break;
                case 29:
                    $FORCE_ENABLE_GROUP_3_E = $data[0];
                break;
                case 30:
                    $HEAT_AND_OFF_GROUP_1_E = $data[0];
                break;
                case 31:
                    $HEAT_AND_OFF_GROUP_2_E = $data[0];
                break;
                case 32:
                    $HEAT_AND_OFF_GROUP_3_E = $data[0];
                break;
                case 33:
                    $TEMP_TRESHOLD_CO_FOR_HEAT_AND_OFF_E = $data[0];
                break;
                case 34:
                    $SWITCH_1_STATE_E = $data[0];
                break;
                case 35:
                    $SWITCH_2_STATE_E = $data[0];
                break;
                case 10://temp;
                    $temp_furnace_out    = $data[0]+($data[1]/100);
                    $temp_furnace_return = $data[2]+($data[3]/100);
                    $temp_CO_out         = $data[4]+($data[5]/100);
                    $temp_CO_return      = $data[6]+($data[7]/100);
                    $temp_boiler         = $data[8]+($data[9]/100);
                    
                    print_r($row);
                    echo "<br>";
                    print_r($data);

                    if (
                        $temp_furnace_out       > 120 ||    
                        $temp_furnace_return    > 120 ||        
                        $temp_CO_out            > 120 ||
                        $temp_CO_return         > 120 ||
                        $temp_boiler            > 120
                    ) {
                        $temp_reset_required = true;
                        break;
                    }
    
                    $sql = "INSERT INTO `".$db_pre."temperatura` (output_furnace, return_furnace, output_co, return_co, boiler) VALUES (?,?,?,?,?);";
                    $stmt = $connection -> prepare($sql);
                    $stmt -> bind_param("ddddd", $temp_furnace_out, $temp_furnace_return, $temp_CO_out, $temp_CO_return, $temp_boiler);
                    $stmt -> execute();
                    $stmt -> close();
                    break;
                case 11://pzem;
                    $voltage     = (($data[3]  << 8)  |  $data[4 ]) / 10;
                    $amps        = (($data[7]  << 24) | ($data[8 ] << 16) | ($data[5]  << 8) | $data[6])/1000;
                    $wats        = (($data[11]  << 24)| ($data[12] << 16) | ($data[9]  << 8) | $data[10])/10;
                    $wathours    = (($data[15] << 24) | ($data[16] << 16) | ($data[13] << 8) | $data[14]);
                    $frequency   = (($data[17] << 8)  |  $data[18]) / 10;
                    $powerfactor = (($data[19] << 8)  |  $data[20]) / 100;
    
                    $sql = "INSERT INTO `".$db_pre."power` (voltage, amps, wats, wathours, powerfactor, frequency) VALUES (?,?,?,?,?,?);";
                    $stmt = $connection -> prepare($sql);
                    $stmt -> bind_param("ddiddd", $voltage, $amps, $wats, $wathours, $powerfactor, $frequency);
                    $stmt -> execute();
                    $stmt -> close();
                    break;
            };
    
        }
    
        $sql = "INSERT INTO `".$db_pre."status` (
            group1,
            group2, group3,
            switch_up, switch_down,
            harmonogram_1, harmonogram_2,
            harmonogram_3, heatAndOff_1,
            heatAndOff_2, heatAndOff_3,
            force_on_1, force_on_2,
            force_on_3, disable_1,
            disable_2, disable_3,
            esco_1, esco_2,
            dark_sensor, temp_co_tresh,
            temp_boiler_tresh) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";//22
        $stmt = $connection -> prepare($sql);
        $stmt -> bind_param("iiiiiiiiiiiiiiiiiiiiii", 
            $GROUP_1_STATUS_E,
            $GROUP_2_STATUS_E,
            $GROUP_3_STATUS_E,
            $SWITCH_1_STATE_E,
            $SWITCH_2_STATE_E,
            $GROUP_1_HARMONOGRAM_E,
            $GROUP_2_HARMONOGRAM_E,
            $GROUP_3_HARMONOGRAM_E,
            $HEAT_AND_OFF_GROUP_1_E,
            $HEAT_AND_OFF_GROUP_2_E,
            $HEAT_AND_OFF_GROUP_3_E,
            $FORCE_ENABLE_GROUP_1_E,
            $FORCE_ENABLE_GROUP_2_E,
            $FORCE_ENABLE_GROUP_3_E,
            $DISABLE_GROUP_1_E,
            $DISABLE_GROUP_2_E,
            $DISABLE_GROUP_3_E,
            $ESCO_1_E,
            $ESCO_2_E,
            $DARK_SENSOR_E,
            $TEMP_TRESHOLD_CO_FOR_HEAT_AND_OFF_E,
            $TEMP_TRESHOLD_FOR_HEAT_AND_OFF_E
        );
        $stmt -> execute();
        $stmt -> close();
        mysqli_close($connection);


        include(__DIR__."/discord_bot_notyfiy.php");
        status_change(     $GROUP_1_STATUS_E,
                           $GROUP_2_STATUS_E,
                           $GROUP_3_STATUS_E,
                           $GROUP_1_HARMONOGRAM_E,
                           $GROUP_2_HARMONOGRAM_E,
                           $GROUP_3_HARMONOGRAM_E,
                           $DISABLE_GROUP_1_E,
                           $DISABLE_GROUP_2_E,
                           $DISABLE_GROUP_3_E,
                           $FORCE_ENABLE_GROUP_1_E,
                           $FORCE_ENABLE_GROUP_2_E,
                           $FORCE_ENABLE_GROUP_3_E,
                           $HEAT_AND_OFF_GROUP_1_E,
                           $HEAT_AND_OFF_GROUP_2_E,
                           $HEAT_AND_OFF_GROUP_3_E,
                           $SWITCH_1_STATE_E,
                           $SWITCH_2_STATE_E);
    }


    if ($temp_reset_required == true) {
        file_get_contents("http://192.168.1.2/newSystem/devices/dev1/set_registers.php?registers=15|0");
    }


?>