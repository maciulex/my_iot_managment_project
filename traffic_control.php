<?php
    $error = "";

    $pico_id    = -1;
    $pico_desc  ="";
    $pico_action="";
    $client_ip = $_SERVER['REMOTE_ADDR'];

    if (!isset($_GET["pico_id"]))   $error .= "no_pico_id;";
    else                            $pico_id    = $_GET["pico_id"];

    // if ($pico_id == intval(7)) sleep(20);

    if (!isset($_GET["pico_desc"])) $error .= "no_pico_desc;";
    else                            $pico_desc  = $_GET["pico_desc"];

    if (!isset($_GET["action"]))    $error .= "no_action;";
    else                            $pico_action= $_GET["action"];
    
    $pico_request_header = "pico_id=$pico_id;pico_desc=$pico_desc;action=$pico_action;";
    
    if (strlen($error) > 0) {
        include("report_error.php");
        error_report($error, "request", $pico_request_header,$client_ip);
        exit(501);
    }

    include("log.php");
    log_header_request($pico_request_header, $client_ip);
    $additional_data = "";
    switch ($pico_action) {
        case "bootAck":
            if (isset($_GET["boot_mess"])) $additional_data.=$_GET["boot_mess"]." ";
            if (isset($_GET["version"]))   $additional_data.="version:".$_GET["version"];

            log_boot_ack($pico_id, $pico_desc, $client_ip, $additional_data);
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
        case "getHarmonogram2":
            include("get_data/getHarmonogram.php");
            echo get_harmonogram2($pico_id);
            exit(0);
            break;
        case "getOwnHarmonogram":
            include("devices/dev".strval($pico_id)."/getHarmonogram.php");
            echo getOwnHarmonogram();
            exit(0);
            break;
        case "ping":
            include("set_data/ping.php");
            ping($pico_id, $client_ip);
            break;
        case "report":
        case "raport":
            include("devices/dev".strval($pico_id)."/report.php");
            exit(0);
        break;
        default:
            include("report_error.php");
            error_report("unknown_action", "request", $pico_request_header, $client_ip);
        break;
    }

?>