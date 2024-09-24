<?php

function vytvorRadek($sirka, $current = 0, $radek = "") {
    if ($current >= $sirka) {
        return $radek;
    }
   
    return vytvorRadek($sirka, $current + 1, $radek . "#");
}

function vytvorObdelnik($sirka, $vyska, $current = 0, $obdelnik = "") {
    if ($current >= $vyska) {
        return $obdelnik; 
    }

    $radek = vytvorRadek($sirka);
    $obdelnik .= $radek . "<br>";

    return vytvorObdelnik($sirka, $vyska, $current + 1, $obdelnik);
}

function tiskniObdelnik($sirka, $vyska) {
    echo vytvorObdelnik($sirka, $vyska); 
}

$sirka = 10;
$vyska = 5;

tiskniObdelnik($sirka, $vyska);

?>
