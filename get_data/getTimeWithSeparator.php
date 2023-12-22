<?php
    function module_get_date_with_separator() {
        date_default_timezone_set("Europe/Warsaw");

        $time = date("H:i:sa");
        $date = date("Y-m-d");
        $time = explode(":", $time);
        $time[2] = $time[2][0].$time[2][1];
        $time = implode("-", $time);
        $weekDay = date('w');
        return "<||>".$time."-".$date."-".$weekDay."<||>";
    }
?>