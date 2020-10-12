<?php
function say($msg, $nl = 1)
{
    $printDate = true;

    if ($msg == "OK!" || $msg == "ERROR!") {
        $printDate = false;
    }

    if ($printDate) {
        echo "[" . Date("Y-m-d H:i:s") . "] ";
    }

    echo $msg;
    for ($i = 0; $i < $nl; $i++) {
        echo "\n";
    }

}
