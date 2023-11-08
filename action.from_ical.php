<?php
if ( !isset($gCms) ) exit; 
$calendrier = file_get_contents('https://calendar.google.com/calendar/ical/auh6kv537lbesd1cf76sn5727c%40group.calendar.google.com/public/basic.ics');

//Ensuite, on définit les expressions régulières qui vont nous permettre de récupérer les informations. On se base sur les balises du format iCal.
// Expressions régulières
$regExpMatch = '/SUMMARY:(.*)/';
$regExpDate = '/DTSTART:(.*)/';
$regExpDesc = '/DESCRIPTION:(.*)/';

/*
Ces expressions régulières vont servir de marqueurs de découpage de chaîne à la fonction preg_match_all.
On récupère en passant le nombre d’occurrences trouvées dans le calendrier (variable $n).
La fonction alimente en sortie un tableau contenant toutes les occurrences trouvées.
*/
$n = preg_match_all($regExpMatch, $calendrier, $matchTableau, PREG_PATTERN_ORDER);
preg_match_all($regExpDate, $calendrier, $dateTableau, PREG_PATTERN_ORDER);
preg_match_all($regExpDesc, $calendrier, $descTableau, PREG_PATTERN_ORDER);

//Enfin, une petite boucle permet de lire le ou les tableaux généré(s), de récupérer les informations intéressantes (par exemple, aucun besoin des termes SUMMARY ou DTSTART, si?), de les mettre en forme puis de les afficher à notre convenance.
for ($j=0 ; $j < $n ; ++$j)
{
// Récupération des données
$annee = substr($dateTableau[0][$j], 8, 4);
$mois = substr($dateTableau[0][$j], 12, 2);
$jour = substr($dateTableau[0][$j], 14, 2);
$heure = substr($dateTableau[0][$j], 17, 2);
$min = substr($dateTableau[0][$j], 19, 2);
$match = substr($matchTableau[0][$j], 8);
$desc = substr($descTableau[0][$j], 12);
// Mise en forme
$date = $jour.'/'.$mois.'/'.$annee;
$horaire = $heure.'h'.$min;
list($compet, $rang, $tv) = explode(' – ', $desc);

// Affichage

echo $rang.$compet.$date.$horaire.$match.$tv;

}

