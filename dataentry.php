<?php

// Functie om input te vragen via CLI
function vraag($vraag) {
    echo $vraag . ": ";
    return trim(fgets(STDIN));
}

// Gegevens verzamelen
echo "=== Urenregistratie ===\n";

$naam = vraag("Naam");
$datum = vraag("Datum (dag-maand-jaar)");
$project = vraag("Projectnaam");
$uren = vraag("Aantal gewerkte uren");
$omschrijving = vraag("Korte omschrijving van werkzaamheden");

// CSV bestand
$bestand = "urenregistratie.csv";

// Controleren of bestand al bestaat
$nieuwBestand = !file_exists($bestand);

// Bestand openen (append mode)
$file = fopen($bestand, 'a');

// Header toevoegen als bestand nieuw is
if ($nieuwBestand) {
    fputcsv($file, ["Naam", "Datum", "Project", "Uren", "Omschrijving"]);
}

// Data schrijven
fputcsv($file, [$naam, $datum, $project, $uren, $omschrijving]);

fclose($file);

echo "\n Uren succesvol opgeslagen in $bestand\n";

// Bestand openen in Excel (Windows)
if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
    exec("start \"\" \"$bestand\"");
}
// Mac
elseif (PHP_OS_FAMILY === 'Darwin') {
    exec("open \"$bestand\"");
}
// Linux
else {
    exec("xdg-open \"$bestand\"");
}
?>