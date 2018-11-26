<?php
$bigNumber1 = '23324345456456456567567123451111111111111999999999999';
$bigNumber2 = '1111111111111111115431854265874165841068401684584684';

function sumBigNumbers($bigNumber1, $bigNumber2, $base = 10)
{
    $sum = [];
    $len1 = strlen($bigNumber1);
    $len2 = strlen($bigNumber2);
    if ($len1 > $len2) {
        $buffer = str_pad('', ($len1 - $len2), 0);
        $capacity = $len1;
        $bigNumber2 = $buffer . $bigNumber2;
    } else {
        $buffer = str_pad('', ($len2 - $len1), 0);
        $capacity = $len2;
        $bigNumber1 = $buffer . $bigNumber1;
    }

    $capacity = (int)($capacity / $base) + (!empty($capacity % $base) ? 1 : 0);

    $arr1 = [];
    $arr2 = [];
    for ($i = 0; $i < $capacity; $i++) {
        $arr1[] = substr($bigNumber1, $i * $base, $base);
        $arr2[] = substr($bigNumber2, $i * $base, $base);
    }
    $arr1 = array_reverse($arr1);
    $arr2 = array_reverse($arr2);

    $transfer = 0;
    foreach ($arr1 as $key => $item) {
        $part = $arr1[$key] + $arr2[$key] + $transfer;
        if ($part > 10 * $base) {
            $transfer = 0;
        } else {
            $transfer = 1;
            $part = substr($part, 1);
        }
        $sum[] = $part;
    }

    return implode('', array_reverse($sum));
}

