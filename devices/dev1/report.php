<?php
    if (!isset($_GET["vals"])) {
        include("report_error.php");
        error_report("no_report_data", "request", "");
        exit(501);
    }

    include "send_data_to_db.php";
    send_data_to_db($_GET["vals"], "");
    

?>