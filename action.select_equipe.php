<?php
if( !isset( $gCms) ) exit;
$db = cmsms()->GetDb();
//debug_display($params, 'Parameters');
$saison = (isset($params['saison'])?$params['saison']:$this->GetPreference('saison_en_cours'));
$phase = (isset($params['phase'])?$params['phase']:$this->GetPreference('phase_en_cours'));
//$nom_equipes = $this->GetPreference('nom_equipes');
$record_id = '';
$parms = array();

$query = "SELECT CONCAT_WS(':', id,libdivision,libequipe,friendlyname) AS liste_equipes FROM  ".cms_db_prefix()."module_ping_equipes AS eq WHERE saison  = ? AND phase = ? ";
$query.= " ORDER BY idepreuve ASC, numero_equipe ASC";


$parms['saison'] = $saison;
$parms['phase'] = $phase;
//en parametres possibles : 
#le championnat recherché ou non

//on effectue la requete
$dbresult = $db->Execute($query,$parms);
$row = $dbresult->FetchRow();
$liste_equipes = $row['liste_equipes'];
$smarty = $tpl->CreateTemplate($this->GetTemplateResource('select_equipe.tpl'), null, null, $smarty);
$tpl->assign('liste_equipes', $liste_equipes);
$tpl->display();
#
#EOF
#
?>
