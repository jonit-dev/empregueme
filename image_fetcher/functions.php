<?php

function to_bytes($val)
{
    $val = trim($val);
    $last = strtolower($val[strlen($val)-1]);
    switch($last) {
        case 'g':
            $val *= 1024;
        case 'm':
            $val *= 1024;
        case 'k':
            $val *= 1024;
    }

    return $val;
}

function to_human($bytes, $precision = 2)
{
    $unit = array('B','KB','MB','GB','TB','PB','EB');

    return @round(
        $bytes / pow(1024, ($i = floor(log($bytes, 1024)))), $precision
    ).' '.$unit[$i];
}