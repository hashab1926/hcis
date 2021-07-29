<?php
function arrayToGet($array)
{
    if (!is_array($array)) return false;

    // set var tampung
    $tampung = '';
    // convert array to object
    $counter = 0;
    foreach ($array as $key => $list) :

        if (strlen($list) > 0) {
            if ($counter == count($array) - 1)
                $tampung .= "{$key}=$list";
            else
                $tampung .= "{$key}=$list&";

            $counter++;
        }
    endforeach;

    return $tampung;
}


function printr($print, $exit = true)
{
    echo '<pre>' . print_r($print, true) . '</pre>';
    if ($exit != false)
        exit(1);
}
