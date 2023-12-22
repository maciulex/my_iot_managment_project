<?php
    $error = "";

    $pico_id    = -1;
    $pico_desc  ="";
    $pico_action="";


    if (!isset($_GET["pico_id"]))   $error .= "no_pico_id;";
    else                            $pico_id    = $_GET["pico_id"];

    if (!isset($_GET["pico_desc"])) $error .= "no_pico_desc;";
    else                            $pico_desc  = $_GET["pico_desc"];

    if (!isset($_GET["action"]))    $error .= "no_action;";
    else                            $pico_action= $_GET["action"];
    
    $pico_request_header = "pico_id=$pico_id;pico_desc=$pico_desc;action=$pico_action;";

    if (strlen($error) > 0) {
        include("report_error.php");
        error_report($error, "request", $pico_request_header);
        exit(501);
    }

    include("log.php");
    log_header_request($pico_request_header);

    switch ($pico_action) {
        case "bootAck":
            if (isset($_GET["boot_mess"])) log_boot_ack($pico_id, $pico_desc,$_GET["boot_mess"]);
            else                           log_boot_ack($pico_id, $pico_desc);
        break;
        case "getTime":
            include("echo/getTimeWithSeparator.php");
            exit(0);
        break;
        case "getHarmonogram":
            include("get_data/getHarmonogram.php");
            echo get_harmonogram($pico_id);
            exit(0);
        break;
        case "report":
            include("devices/dev"+str_val($pico_id)+"/report.php");
            exit(0);
        break;
        default:
            error_report("unknown_action", "request", $pico_request_header);
        break;
    }

?>