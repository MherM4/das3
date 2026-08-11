<?php

if (!function_exists('stringToColor')) {
    function stringToColor($string) {
        $hash = crc32($string);
        $colors = ['#e6194b', '#3cb44b', '#ffe119', '#4363d8', '#f58231', '#911eb4', '#469990'];
        return $colors[abs($hash) % count($colors)];
    }
}
