<?php
    $result = "NO data";
    if (isset($_GET["registers"])){
        $result = file_get_contents("http://192.168.1.45?action=getRegisters&registers=%3C||%3E".$_GET["registers"]."%3C||%3E");
    } else {
        $result = file_get_contents("http://192.168.1.45?action=getRegisters&registers=%3C||%3E10|11|12|13|14|17|18|19|20|21|22|23|24|25|26|27|28|29|30|31|32|33|34|35%3C||%3E");
    }


    //include "send_data_to_db.php";
    //send_data_to_db($result, "manual_");

    echo $result;
?>