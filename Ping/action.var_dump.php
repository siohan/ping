<?php
#################################################################
#    Première étape de récupération des équipes                 #
#################################################################



if( !isset($gCms) ) exit;
debug_display($params, 'Parameters');
//require_once(dirname(__FILE__).'/function.calculs.php');

$club_number = $this->GetPreference('club_number');
echo 'le numéro de club est : '.$club_number;
//$saison = $this->GetPreference('saison_en_cours');
$saison = '2014-2015';
$phase = $this->GetPreference('phase_en_cours');
$licence = '5310809';


$service = new Service();
//pour récupérer les équipes du championnat seniors FFTT
$type = 'D';
$result = $service->getOrganismes("$type")

//$result = $service->getEquipesByClub("$club_number");
//$result = $service->getEpreuves('100001');

//Pour récupérer toutes les autres équipes des autres championnat
//$result = $service->getEquipesByClub("$club_number");
//$result = $service->getRencontre("");

//pour récupérer les parties FFTT d'un joueur
//$result = $service->getJoueurParties("$licence");	
var_dump($result);
/**/
//on va tester si la variable est bien un tableau   

# EOF
#

?>