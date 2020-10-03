<?php
function say($msg, $nl = 1) {
    $printDate = TRUE;

    if($msg == "OK!") $printDate = FALSE;

    if($printDate) echo "[".Date("Y-m-d H:i:s")."] ";
    echo $msg;
    for($i = 0; $i < $nl; $i++) {
        echo "\n";
    }

}