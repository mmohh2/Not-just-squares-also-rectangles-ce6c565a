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
                $horizontal[$x][$check[$i]] = 1;
                $vertical[$x][$check[$i]] = 1;
                $q = $x;
                $p = $y;
                posCheck($horizontal, $vertical, $check, $input, $row, $x, $i, $y, $q, $p);
            }
        }
    }
}

function posCheck(&$horizontal, &$vertical, $check, $input, $row, $x, $i, &$y, &$q, &$p)
{
    if ($y !== false && $x !== 10 && $y !== 10) {
        if (
            $row[$x][$y] !== $row[$x][$y + 1] &&
            $row[$x][$y] !== $row[$x + 1][$y] &&
            $row[$x][$y] !== $row[$x + 1][$y + 1] && 
            $horizontal[$x][$check[$i]] === 1
        ) {
            $y = stripos($input[$x], $check[$i], $y + 1);
            $horizontal[$x][$check[$i]] = 0;
            $vertical[$x][$check[$i]] = 0;
            if ($y === true && $row[$x + 1][$y + 1] === $check[$i]) {
                $horizontal[$x][$check[$i]] = 1;
                $vertical[$x][$check[$i]] = 1;
                $q = $x;
                $p = $y;
                posCheck($horizontal, $vertical, $check, $input, $row, $x, $i, $y, $q);
            }
        }
        if (
            $row[$x][$y] === $row[$x][$y + 1] &&
            $row[$x][$y] === $row[$x + 1][$y] &&
            $row[$x][$y] === $row[$x + 1][$y + 1]
        ) {
            if ($vertical[$x][$check[$i]] === 1) {
                $vertical[$x][$check[$i]]++;
                $q++;
            }
            if ($horizontal[$x][$check[$i]] === 1) {
                $horizontal[$x][$check[$i]]++;
                $p++;
            }
        }
        if ($horizontal[$x][$check[$i]] >= 2 && $p !== 11) {
            if ($row[$x][$p] === $row[$x][$p + 1] && $row[$x][$p] === $row[$q][$p + 1]) {
                $horizontal[$x][$check[$i]]++;
                $p++;
                posCheck($horizontal, $vertical, $check, $input, $row, $x, $i, $y, $q, $p);
            }
        }
        if ($vertical[$x][$check[$i]] >= 2 && $q !== 11) {
            if ($row[$q][$y] === $row[$q + 1][$y] && $row[$q][$y] === $row[$q + 1][$p]) {
                $vertical[$x][$check[$i]]++;
                $q++;
                posCheck($horizontal, $vertical, $check, $input, $row, $x, $i, $y, $q, $p);
            }
        }

        if ($horizontal[$x][$check[$i]] > 1 && $vertical[$x][$check[$i]] > 1) {
            $stopX = ($horizontal[$x][$check[$i]] - 1) + $x;
            $stopY = ($vertical[$x][$check[$i]] - 1) + $y;
            if ($stopX < 11 || $stopX === 11 && $stopY < 11 || $stopY === 11) {
                if ($x === 0) {
                    echo $check[$i] . "($x,$y) - " . $vertical[$x][$check[$i]] . "x" . $horizontal[$x][$check[$i]]  . PHP_EOL;
                    $horizontal[$x][$check[$i]] = 0;
                    $vertical[$x][$check[$i]] = 0;
                    $q = $x;
                    $p = $y;
                }
                if ($x !== 0 && $row[$x - 1][$y] !== $row[$x][$y]) {
                    echo $check[$i] . "($x,$y) - " . $vertical[$x][$check[$i]] . "x" . $horizontal[$x][$check[$i]]  . PHP_EOL;
                    $horizontal[$x][$check[$i]] = 0;
                    $vertical[$x][$check[$i]] = 0;
                    $q = $x;
                    $p = $y;
                }
            }
        }
    }
}
construct($input, $check);
?>