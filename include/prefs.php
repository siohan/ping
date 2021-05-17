<?php

if( !isset($gCms) ) exit;
$db =& $this->GetDb();
global $themeObject;
$now = trim($db->DBTimeStamp(time()), "'");
$mois_courant = date('n');
$annee_courante = date('Y');
//$annee_courante = 2020;//pour tester
$jour_courant = date('d');
$saison_courante = $this->GetPreference('saison_en_cours');
$module_dir = $this->GetModuleURLPath();
$tableau = array("1"=>"Janvier","2"=>"Février","3"=>"Mars","4"=>"Avril","5"=>"Mai","6"=>"Juin","7"=>"Juillet","9"=>"Septembre","10"=>"Octobre","11"=>"Novembre","12"=>"Décembre");
$liste_mois = array("Janvier"=>"1", "Février"=>"2","Mars"=>"3","Avril"=>"4","Mai"=>"5","Juin"=>"6","Juillet"=>"7","Septembre"=>"9","Octobre"=>"10","Novembre"=>"11", "Décembre"=>"12");
$liste_mois_fr = array("Janvier", "Février","Mars","Avril","Mai","Juin","Juillet","Septembre","Octobre","Novembre", "Décembre");
$mois_courts = array('Jan','Fév','Mar','Avr','Mai','juin','juil','aout', 'Sept','Oct', 'Nov', 'Déc');
$annee = date('Y');
$mois = date('n');
$mois_liste_tableau = $mois - 1;
$mois_tableau = $mois_courts[$mois_liste_tableau];
//$annee ='2014';
//$mois ='4';
if($mois>=7   && $mois <=12)
{
	//echo "case1";
	$annee1 = $annee;
	$annee2 = $annee+1;
	$phase = 1;
	$saison_en_cours = $annee1.'-'.$annee2;
	//$this->SetPreference('phase_en_cours', $phase);
	//$this->SetPreference('saison_en_cours', $saison_en_cours);
	$annee_fin = $annee2;
}
elseif($mois >=1 && $mois<7)
{
	//echo "case2";
	$phase = 2;
	$annee1 = $annee-1;
	$annee2 = $annee;
	$saison_en_cours = $annee1.'-'.$annee2;
//	$this->SetPreference('phase_en_cours', $phase);
//	$this->SetPreference('saison_en_cours', $saison_en_cours);
	$annee_fin = $annee2;
	
}
$this->GetPreference('annee_fin');
if($annee_fin != $this->GetPreference('annee_fin'))
{
	//ON change de saison !
	
}
$saisondropdown = array();
for($i = 2013; $i<=$annee_courante; $i++)
{
	$annee1 = $i;
	$annee2 = $i+1;
	//echo $annee1.'-'.$annee2.'<br />';
	$saison = $annee1.'-'.$annee2;
	$saisondropdown[$saison]=$saison;
}


//var_dump($saisondropdown);
//echo "année déduite : ". $saison_en_cours;
#
#EOF
#
?>