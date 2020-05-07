<?php
$input = file_get_contents("input.txt");
$check = array("A","E","I","O","U");

function construct($input, $check)
{
    $input = str_split($input, 13);
    for ($z = 0; $z < count($input); $z++) {
        if ($z !== 11) {
            $input[$z] = substr($input[$z], 0, -1);
        }
        $row[$z] = str_split($input[$z]);
    }
    for ($x = 0; $x < count($input); $x++) {
        for ($i = 0; $i < count($check); $i++) {
            $y = stripos($input[$x], $check[$i]);
            if ($y !== false && $x !== 11) {
                $count[$x][$check[$i]] = 1; 
                $q = $x;
                posCheck($count, $check, $input, $row, $x, $i, $y, $q);
            }
        }
    }
}

function posCheck(&$count, $check, $input, $row, $x, $i, &$y, &$q)
{
    if ($y !== false && $x !== 10 && $y !== 10) {
        if (
            $row[$x][$y] !== $row[$x][$y + 1] &&
            $row[$x][$y] !== $row[$x + 1][$y] &&
            $row[$x][$y] !== $row[$x + 1][$y + 1] &&
            $count[$x][$check[$i]] === 1
        ) {
            $y = stripos($input[$x], $check[$i], $y + 1);
            $q = $x;
            if ($y === true && $row[$x + 1][$y + 1] === $check[$i]) {
                posCheck($count, $check, $input, $row, $x, $i, $y, $q);
            }
        }
        if (
            $row[$q][$y] === $row[$q][$y + 1] &&
            $row[$q][$y] === $row[$q + 1][$y] &&
            $row[$q][$y] === $row[$q + 1][$y + 1]
        ) {
            $count[$x][$check[$i]]++;
            if ($y !== 10) {
                $y++;
            }
            if ($q !== 10) {
                $q++;
            }
            posCheck($count, $check, $input, $row, $x, $i, $y, $q);
        }
        if (
            $row[$x][$y] !== $row[$x][$y + 1] ||
            $row[$x][$y] !== $row[$x + 1][$y] ||
            $row[$x][$y] !== $row[$x + 1][$y + 1]
        ) {
            if ($count[$x][$check[$i]] > 1 && $y !== false) {
                $stop = ($count[$x][$check[$i]] - 1) + $x;
                $y = $y - ($count[$x][$check[$i]] - 1);
                if ($row[$x][$y] === $row[$x][$y] && $stop < 11 || $stop === 11) {
                    echo $check[$i] . " / " . $x . ", $y - " . $count[$x][$check[$i]] . "x" . $count[$x][$check[$i]]  . PHP_EOL;
                    $count[$x][$check[$i]] = 0;
                    $q = $x;
                }
            }
        }              
    }
}
construct($input, $check);
?>