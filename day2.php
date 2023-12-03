<?php
require_once('lib/lib.php');


$input = GetInput();

$inputLines = explode("\n", $input);

$games = [];
foreach($inputLines as $line) {
    $gameObj = GetMaxCubesOfGame($line);
    $games[$gameObj->id] = $gameObj;
}

$possibleGames = [];

foreach($games as $game) {
    if($game->IsValid(12, 13, 14)) {
        $possibleGames []= $game->id;
    }
}

$result = array_reduce($possibleGames, "Sum");
var_dump($result);

$result2 = array_reduce($games, "Res2");
var_dump($result2);

function Sum ($carry, $item) {
    return (int)$carry + (int)$item;
}

function Res2 ($carry, Game $item) {
    return (int)$carry + $item->Power();
}



//Game 1: 3 blue, 4 red; 1 red, 2 green, 6 blue; 2 green
function GetMaxCubesOfGame($gameline) : Game {
    $startOfGameId = stripos($gameline, " ");
    $endOfGameId = stripos($gameline, ":");

    $gameId = substr($gameline, $startOfGameId, $endOfGameId - $startOfGameId);

    $gameObj = new Game((int) $gameId);

    // +1 weil hinter dem ":" anfangen wollen
    $gameLineWithoutId = substr($gameline, $endOfGameId + 1);
    //Semikolons mit normalen trennern ersetzen. Die einzelnen durchläufe in game sind uns egal
    //Das einzig relevante ist die max anzahl an cubes in einem game pro farbe
    $gameLineWithoutId = str_replace(";", ",", $gameLineWithoutId);

    $colourCountChunkArr = explode(",", $gameLineWithoutId);

    foreach($colourCountChunkArr as $colourCountChunk) {
        $colourCountChunk = trim($colourCountChunk);

        $numberColourArray = explode(" ", $colourCountChunk);

        match ($numberColourArray[1]) {
            "red" => $gameObj->AddRed($numberColourArray[0]),
            "green" => $gameObj->AddGreen($numberColourArray[0]),
            "blue" => $gameObj->AddBlue($numberColourArray[0])
        };
    }

    return $gameObj;
}



class Game {
    public $id;
    private $max_red;
    private $max_green;
    private $max_blue;

    public function __construct($id) {
        $this->id = $id;
    }

    public function Power() {
        return $this->max_green * $this->max_blue * $this->max_red;
    }

    public function AddBlue($val) {
        if($val > $this->max_blue) {
            $this->max_blue = $val;
        }
    }

    public function AddRed($val) {
        if($val > $this->max_red) {
            $this->max_red = $val;
        }
    }

    public function AddGreen($val) {
        if($val > $this->max_green) {
            $this->max_green = $val;
        }
    }

    public function IsValid ($redVal, $greenVal, $blueVal) : bool {
        $isValid = $redVal >= $this->max_red && $greenVal >= $this->max_green && $blueVal >= $this->max_blue;
        return $isValid;
    }
}