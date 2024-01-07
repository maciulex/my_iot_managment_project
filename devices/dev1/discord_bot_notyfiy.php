<?php

    function dc_file_append($text) {
        file_put_contents(
            "G:/node/dc_bot/events.txt",
            $text."\r\n",
            FILE_APPEND

        );
    }   

    function status_change(
        $GROUP_1_STATUS_E,
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
        $SWITCH_2_STATE_E, $db = "pico_devices_dev1"
    ) {
        include(__DIR__."/../../db_credits.php");
        $connection = mysqli_connect($host, $log_account, $log_account_pass, $db);

        $sql = "SELECT * FROM status  WHERE 1 ORDER BY id DESC LIMIT 1,1";
        $stmt = $connection -> query($sql);
        $result = $stmt -> fetch_assoc();
        print_r($result);
        $stmt -> close();

        mysqli_close($connection);
        

        if ($GROUP_1_STATUS_E != $result["group1"]) {
            dc_file_append("Grupa 1 zmiana statusu na: ".(($result["group1"] != "1") ? "Aktywny": "Nie aktywny"));
        }
        if ($GROUP_2_STATUS_E != $result["group2"]) {
            dc_file_append("Grupa 2 zmiana statusu na: ".(($result["group2"] != "1") ? "Aktywny": "Nie aktywny"));
        }
        if ($GROUP_3_STATUS_E != $result["group3"]) {
            dc_file_append("Grupa 3 zmiana statusu na: ".(($result["group3"] != "1") ? "Aktywny": "Nie aktywny"));
        }
        if ($GROUP_1_HARMONOGRAM_E != $result["harmonogram_1"]) {
            dc_file_append("Grupa 1 zmiana harmonogramu na: ".(($result["harmonogram_1"] != "1") ? "Aktywny": "Nie aktywny"));
        }
        if ($GROUP_2_HARMONOGRAM_E != $result["harmonogram_2"]) {
            dc_file_append("Grupa 2 zmiana harmonogramu na: ".(($result["harmonogram_2"] != "1") ? "Aktywny": "Nie aktywny"));
        }
        if ($GROUP_3_HARMONOGRAM_E != $result["harmonogram_3"]) {
            dc_file_append("Grupa 3 zmiana harmonogramu na: ".(($result["harmonogram_3"] != "1") ? "Aktywny": "Nie aktywny"));
        }
        if ($DISABLE_GROUP_1_E != $result["disable_1"]) {
            dc_file_append("Grupa 1 została logicznie: ".(($result["disable_1"] != "1") ? "włączona": "wyłączona"));
        }
        if ($DISABLE_GROUP_2_E != $result["disable_2"]) {
            dc_file_append("Grupa 2 została logicznie: ".(($result["disable_2"] != "1") ? "włączona": "wyłączona"));
        }
        if ($DISABLE_GROUP_3_E != $result["disable_3"]) {
            dc_file_append("Grupa 3 została logicznie: ".(($result["disable_3"] != "1") ? "włączona": "wyłączona"));
        }
        if ($FORCE_ENABLE_GROUP_1_E != $result["force_on_1"]) {
            dc_file_append("Grupa 1, wymuszenie zostało: ".(($result["force_on_1"] != "1") ? "włączony": "wyłączony"));
        }
        if ($FORCE_ENABLE_GROUP_2_E != $result["force_on_2"]) {
            dc_file_append("Grupa 2, wymuszenie zostało: ".(($result["force_on_2"] != "1") ? "włączony": "wyłączony"));
        }
        if ($FORCE_ENABLE_GROUP_3_E != $result["force_on_3"]) {
            dc_file_append("Grupa 3, wymuszenie zostało: ".(($result["force_on_3"] != "1") ? "włączony": "wyłączony"));
        }
        if ($HEAT_AND_OFF_GROUP_1_E != $result["heatAndOff_1"]) {
            dc_file_append("Grupa 1 nagrzej i wyłącz: ".(($result["heatAndOff_1"] != "1") ? "włączony": "wyłączony"));
        }
        if ($HEAT_AND_OFF_GROUP_2_E != $result["heatAndOff_2"]) {
            dc_file_append("Grupa 2 nagrzej i wyłącz: ".(($result["heatAndOff_2"] != "1") ? "włączony": "wyłączony"));
        }
        if ($HEAT_AND_OFF_GROUP_3_E != $result["heatAndOff_3"]) {
            dc_file_append("Grupa 3 nagrzej i wyłącz: ".(($result["heatAndOff_3"] != "1") ? "włączony": "wyłączony"));
        }
        if ($SWITCH_1_STATE_E != $result["switch_up"]) {
            switch (SWITCH_1_STATE_E) {
                case "0":
                    dc_file_append("Przycisk grupa 1 zmiana położenia na: Zawsze wyłączona");
                    break;
                case "1":
                    dc_file_append("Przycisk grupa 1 zmiana położenia na: Kontroler");
                    break;
                case "2":
                    dc_file_append("Przycisk grupa 1 zmiana położenia na: Zawsze włączona");
                    break;
            }
        }
        if ($SWITCH_2_STATE_E != $result["switch_down"]) {
            switch (SWITCH_2_STATE_E) {
                case "0":
                    dc_file_append("Przycisk grupa 2 zmiana położenia na: Zawsze wyłączona");
                    break;
                case "1":
                    dc_file_append("Przycisk grupa 2 zmiana położenia na: Kontroler");
                    break;
                case "2":
                    dc_file_append("Przycisk grupa 2 zmiana położenia na: Zawsze włączona");
                    break;
            }
        }

    }

?>