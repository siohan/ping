<?php

if( !isset($gCms) ) exit;
$db =& $this->GetDb();
global $themeObject;
$now = trim($db->DBTimeStamp(time()), "'");
$mois_courant = date('n');
$annee_courante = date('Y');
$saison_courante = $this->GetPreference('saison_en_cours');
$module_dir = $this->GetModuleURLPath();
$tableau = array("1"=>"Janvier","2"=>"Février","3"=>"Mars","4"=>"Avril","5"=>"Mai","6"=>"Juin","7"=>"Juillet","9"=>"Septembre","10"=>"Octobre","11"=>"Novembre","12"=>"Décembre");
$liste_mois = array("Janvier"=>"1", "Février"=>"2","Mars"=>"3","Avril"=>"4","Mai"=>"5","Juin"=>"6","Juillet"=>"7","Septembre"=>"9","Octobre"=>"10","Novembre"=>"11", "Décembre"=>"12");

#
#EOF
#
?>