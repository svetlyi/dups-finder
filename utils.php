<?php

function status_bar($done, $info="") {
    printf("%s\r", str_repeat(' ', 100));
    printf("%s[%9.80s]\r", $done, $info);
}

function progress_bar($done, $total, $info="", $width=50) {
    $perc = round(($done * 100) / $total);
    $bar = round(($width * $perc) / 100);
    printf("%s%%[%s>%s]%s\r", $perc, str_repeat("=", $bar), str_repeat(" ", $width-$bar), $info);
}

function printit(string $message) {
    $str = sprintf("%s" . PHP_EOL, $message);
    echo $str;
    return $str;
}