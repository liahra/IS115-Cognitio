<?php
date_default_timezone_set('Europe/Oslo');
// Diverse funksjoner som er kjekke og ha
// Gjør forfallsdato og klokkeslett om til noe leselig
function readableDate($unreadableDate) {
    return date('d.m.Y', strtotime($unreadableDate));
}

function readableClock($unreadableClock) {
    return date('H:i', strtotime($unreadableClock));
}

// Gjør status om til norsk
function getStatus($status) {
    return match ($status) {
        'not-started' => "Ikke startet",
        'pending' => "Pågår",
        'completed' => "Fullført",
        'inactive' => "Slettet"
    };
}

function formatNorwegianDateTime($dateTimeString) {
    $dateTime = date_create($dateTimeString);
    $norwegianMonths = [
        'jan.', 'feb.', 'mars', 'apr.', 'mai', 'juni',
        'juli', 'aug.', 'sep.', 'okt.', 'nov.', 'des.'
    ];
    $day = date_format($dateTime, 'j');
    $monthIndex = (int)date_format($dateTime, 'n') - 1;
    $year = date_format($dateTime, 'Y');
    $time = date_format($dateTime, 'H:i');
    return "$day. {$norwegianMonths[$monthIndex]} $year kl. $time";
}

function isPastDueDate($due){
    // Gjør due date om til timestamp
    $delivery = strtotime($due);

    // Sammenligne med nå
    return $delivery < time();
}

function isLate($due, $status){
    $pastDueDate = isPastDueDate($due);

    // Er aktiviteten ikke fullført?    
    $active = $status === "not-started" || $status === "pending";

    return $pastDueDate && $active;
}

?>