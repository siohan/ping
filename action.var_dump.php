<?php
#################################################################
#    Première étape de récupération des équipes                 #
#################################################################



if( !isset($gCms) ) exit;
//debug_display($params, 'Parameters');
//require_once(dirname(__FILE__).'/function.calculs.php');

$club_number = $this->GetPreference('club_number');
//echo 'le numéro de club est : '.$club_number;
//$saison = $this->GetPreference('saison_en_cours');
$saison = '2014-2015';
$phase = $this->GetPreference('phase_en_cours');
$licence = '2929378';
$ping = cms_utils::get_module('Ping');
$code = $ping->GetPreference('serie');
echo "le code est : ".$code;
echo "le time est : ".time();
$service = new Service();
//pour récupérer les équipes du championnat seniors FFTT
$type = 'D';
//$link = "http://www.fftt.com/mobile/pxml/xml_organisme.php";
//$link = "http://www.fftt.com/mobile/pxml/xml_epreuve.php";
//$link = "http://www.fftt.com/mobile/pxml/xml_division.php";
//$link = "http://www.fftt.com/mobile/pxml/xml_result_indiv.php";
$link = "http://www.fftt.com/mobile/pxml/xml_histo_classement.php";
$link.="?serie=".$code;
$this->code = Service::GetPassword();
$this->tm = Service::GetTimestamp();
$link.="&tm=".$this->tm;
$this->tmc = Service::GetEncryptedTimestamp();
$link.="&tmc=".$this->tmc;
$link.="&id=SW011";
$link.="&numlic=292271";
//$link.="&action=poule";
//$link.="&organisme=29";
//$link.="&epreuve=1072";
//$link.="&type=I";
$ini = file_get_contents($link);
$xml = simplexml_load_string($ini);
var_dump($xml);
//echo "<br /><a target=\"_blank\" href=".$link.">".$link."</a>";
//LE FLOC'H Pierre
//GUICHAOUA - LE GOFF Antoine
/*
$nom = "DELANOË Adrien";
$nom_global = ping_admin_ops::get_name($nom);

$nom_reel = addslashes($nom_global[0]);//le nom
$prenom_reel = $nom_global[1];//le prénom


echo "le nom est :".$nom_reel." le prénom est : ".$prenom_reel."<br />";

$result = $service->getJoueursByName($nom_reel,$prenom = "$prenom_reel");
*/

//$result = $service->getEquipesByClub("$club_number");
//$result = $service->getEpreuves('100001');

//Pour récupérer toutes les autres équipes des autres championnat
//$result = $service->getEquipesByClub("$club_number");
//$result = $service->getRencontre("");
//$result = $service->getClub("$club_number");
//pour récupérer les parties FFTT d'un joueur
//$result = $service->getJoueurParties("$licence");	
//var_dump($result);
/**/
//on va tester si la variable est bien un tableau   

# EOF
#

?>