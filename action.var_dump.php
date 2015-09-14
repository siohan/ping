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
$idAppli = $this->GetPreference('idAppli');
echo $idAppli;
$service = new Servicen();
//$serviceping = new Serviceping();
//pour récupérer les équipes du championnat seniors FFTT
//$type = 'D';
//$link = "http://www.fftt.com/mobile/pxml/xml_organisme.php";
//$link = "http://www.fftt.com/mobile/pxml/xml_epreuve.php";
//$link = "http://www.fftt.com/mobile/pxml/xml_division.php";
//$link = "http://www.fftt.com/mobile/pxml/xml_result_indiv.php";
$link = "http://www.fftt.com/mobile/pxml/xml_club_detail.php";
//$link = "http://www.fftt.com/mobile/pxml/xml_histo_classement.php";
$this->serie = Servicen::GetSerie();
//$code = "GWHBVVUHR97LX4D";
echo "le numero de serie est : ".$this->serie."<br />";
$link.="?serie=".$this->serie;
$this->code = Servicen::GetPassword();
echo "le mot de passe crypté est : ".$this->code."<br />";
$this->tm = Servicen::GetTimestamp();
$link.="&tm=".$this->tm;
$this->tmc = Servicen::GetEncryptedTimestamp();
$link.="&tmc=".$this->tmc;
$this->idAppli = Servicen::GetIdAppli();
$link.="&id=".$this->idAppli;
echo "le numero de application est : ".$this->idAppli."<br />";
//$link.="&numlic=292271";
//$link.="&action=poule";
//$link.="&organisme=29";
//$link.="&epreuve=1072";
//$link.="&type=I";
$link.="&club=".$club_number;
#$link.="&epr=1072&res_division=3048&cx_tableau=36310";

echo "<br /><a target=\"_blank\" href=".$link.">".$link."</a>";

$ini = file_get_contents($link);
$xml = simplexml_load_string($ini);


var_dump($xml);
#$ini = file_get_contents($link);
#$xml = simplexml_load_string($ini);
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

//$result = $serviceping->getEquipesByClub("$club_number");
//$result = $serviceping->getEpreuves('100001',$type='E');
//$result = $service->getDivisions("29", "1072");
//Pour récupérer toutes les autres équipes des autres championnat
//$result = $service->getEquipesByClub("$club_number");
//$result = $service->getRencontre("");
//$result = $serviceping->getClub("$club_number");
//pour récupérer les parties FFTT d'un joueur
//$result = $service->getJoueurParties("$licence");	
//var_dump($result);
/**/
//on va tester si la variable est bien un tableau   

# EOF
#

?>