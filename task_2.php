<?php
$path = "counter.txt";

if (!counter($path)) {
    $path = "counter_".uniqid() .".txt";
    counter($path);
    // ToDo needed collision collector
}

/**
 * @param string $path
 * @return bool
 */
function counter($path = '')
{
    if (empty($path)) {
        return false;
    }
    if (file_exists($path)) {
        $amount = (int)file_get_contents($path) + 1;
        $f = fopen($path, "r+");
        if (flock($f, LOCK_EX)) {
            ftruncate($f, 0);
            fwrite($f, $amount);
            fflush($f);
            flock($f, LOCK_UN);
        } else {
            return false;
        }
        fclose($f);
    } else {
        return (bool)file_put_contents($path, 1, LOCK_EX);
    }
    return true;
}


