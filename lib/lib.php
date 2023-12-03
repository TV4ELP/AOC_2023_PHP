<?php 

function GetInput() : string {

    $inputName = pathinfo($_SERVER["SCRIPT_NAME"])["filename"] . ".txt";

    $content = @file_get_contents($inputName);
    return $content;
}

function PrintLN($str) : void {
    echo ($str .  PHP_EOL);
}