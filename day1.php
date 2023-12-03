<?php
require_once('lib/lib.php');


// 1abc2
// pqr3stu8vwx
// a1b2c3d4e5f
// treb7uchet

// In this example, the calibration values of these four lines are 12, 38, 15, and 77. 
// Adding these together produces 142.

$input = GetInput();

$inputLines = explode("\n", $input);

$numbers_1 = [];
$numbers_2 = [];
foreach($inputLines as $line) {

    $numbers_1 []= GetDigitsFromStr((string) $line);
    $convLine = ConvertToNumberArr((string)$line);
    
    $number2 = reset($convLine);
    end($convLine);
    $number2 .= current($convLine);
    $numbers_2 [] = $number2;
}



$result_1 = array_reduce($numbers_1,  'Sum');
$result_2 = array_reduce($numbers_2,  'Sum');



var_dump($result_1);
var_dump($result_2);

function Sum ($carry, $item) {
    return (int)$carry + (int)$item;
}

function GetDigitsFromStr(string $inputString) : int {

    $line = str_split($inputString);

    $number = GetSingleDigit($line) . GetSingleDigit(array_reverse($line));

    return $number;
}


function GetSingleDigit(array $chars)  {

    foreach($chars as $char) {
        if (is_numeric($char) ){
            return $char;
        }
    }

    return 0;
    
}


function ConvertToNumberArr(String $line) {
    $newStr = [];


    $chars = str_split($line);
    $numberStrWindow = "";

    foreach($chars as $char) {
        if (is_numeric($char) ){
            $newStr []= $char;
            $numberStrWindow = "";

            continue;
        }

        $numberStrWindow .= $char;
        $namedNumber = GetNamedNumber($numberStrWindow);

        if($namedNumber != null) {
            $newStr []= $namedNumber;
            $numberStrWindow = substr($numberStrWindow, -1);
        }
    }

    return $newStr;
}


function GetNamedNumber($str) : ?int {

    return match (true) {
        str_contains($str, "one") => 1,
        str_contains($str, "two") => 2,
        str_contains($str, "three") => 3,
        str_contains($str, "four") =>4,
        str_contains($str, "five") => 5,
        str_contains($str, "six") => 6,
        str_contains($str, "seven") =>7,
        str_contains($str, "eight") => 8,
        str_contains($str, "nine") =>9,
        default => null
    };
}