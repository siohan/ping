<?php

if( !isset($gCms) ) exit;
$db =& $this->GetDb();
global $themeObject;
$now = trim($db->DBTimeStamp(time()), "'");
$mois_courant = date('n');
$annee_courante = date('Y');
$saison_courante = $this->GetPreference('saison_en_cours');

#
#EOF
#
?>