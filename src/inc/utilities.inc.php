<?php

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

?>