<?php

if( !isset($gCms) ) exit;
$db = cmsms()->GetDb();
global $themeObject;
$now = trim($db->DBTimeStamp(time()), "'");
$mois_courant = date('n');
$annee_courante = date('Y');

$jour_courant = date('d');
$saison_courante = $this->GetPreference('saison_en_cours');

$tableau = array("1"=>"Janvier","2"=>"Février","3"=>"Mars","4"=>"Avril","5"=>"Mai","6"=>"Juin","7"=>"Juillet","9"=>"Septembre","10"=>"Octobre","11"=>"Novembre","12"=>"Décembre");
$liste_mois = array("Janvier"=>"1", "Février"=>"2","Mars"=>"3","Avril"=>"4","Mai"=>"5","Juin"=>"6","Juillet"=>"7","Septembre"=>"9","Octobre"=>"10","Novembre"=>"11", "Décembre"=>"12");
$liste_mois_fr = array("Janvier", "Février","Mars","Avril","Mai","Juin","Juillet","Septembre","Octobre","Novembre", "Décembre");
$mois_courts = array('Jan','Fév','Mar','Avr','Mai','juin','juil','aout', 'Sept','Oct', 'Nov', 'Déc');
$tableau_mois_courts = array("1"=>"Jan","2"=>"Fév","3"=>"Mar","4"=>"Avr","5"=>"Mai","6"=>"Juin","7"=>"Juil","9"=>"Sept","10"=>"Oct","11"=>"Nov","12"=>"Déc");

$annee = date('Y');
$mois = date('n');
$mois_liste_tableau = $mois - 1;
$mois_tableau = $mois_courts[$mois_liste_tableau];

if($mois>=7   && $mois <=12)
{
	
	$annee1 = $annee;
	$annee2 = $annee+1;
	$phase = 1;
	$saison_en_cours = $annee1.'-'.$annee2;
	$annee_fin = $annee2;
	if($saison_en_cours != $this->GetPreference('saison_en_cours'))
	{
		//$this->SetPreference('saison_en_cours', $saison_en_cours);
	}
	
}
elseif($mois >=1 && $mois<7)
{
	$phase = 2;
	$annee1 = $annee-1;
	$annee2 = $annee;
	$saison_en_cours = $annee1.'-'.$annee2;
	if($phase != $this->GetPreference('phase_en_cours'))
	{
		//$this->SetPreference('phase_en_cours', $phase);
	}
	$annee_fin = $annee2;
	
}

$saisondropdown = array();
for($i = 2021; $i<=$annee_courante; $i++)
{
	$annee1 = $i;
	$annee2 = $i+1;
	$saison = $annee1.'-'.$annee2;
	$saisondropdown[$saison]=$saison;
}

#
#EOF
#
?>
