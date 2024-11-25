<?php

class Logger {
    function logError($e) {
        echo "Logger";
        // Mappe med log-filer
        $folder = "../log/";
        $filename = "errors.txt";

        // Ingen mappe ved det navn?
        if (!file_exists($folder)) {
            if (!mkdir($folder, 0777, true))
                die("Kan ikke opprette folder... " . $folder);
        }

        // Hent eksisterende innhold
        $oldContent = file_get_contents($folder . $filename);
        echo $oldContent;

        // Vi vil gjerne vite hvilken fil som kalte på denne funksjonen
        $backfiles = debug_backtrace();
        $location =  basename($backfiles[0]['file']) . ':' . $backfiles[0]['line'];

        // Kombiner med nytt innhold
        $content = date('d.m.Y k\l. H:i:s') . ": [" . $location . "] " . $e  . "\n" . $oldContent; //

        // Skriv det nye innholdet tilbake til loggfilen
        file_put_contents($folder . $filename, $content);
    }
}
