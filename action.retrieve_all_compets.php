<?php

if( !isset($gCms) ) exit;

$db = cmsms()->GetDb();
global $themeObject;
//debug_display($params, 'Parameters');
//créations de liens de récupération des compétitions
//on récupère d'abord les préférences de zones, ligues et département
$orga = array('fede'=>$this->getPreference('fede'), 'zone'=>$this->GetPreference('zone'),'ligue'=>$this->GetPreference('ligue'), 'dep'=>$this->GetPreference('dep'));
$ret_ops = new retrieve_ops;
foreach($orga as $value)
{
	$ret_ops->retrieve_compets($value,$type='I');
	$ret_ops->retrieve_compets($value,$type='E');
}
$this->SetMessage('Compétitions récupérées');
$this->Redirect($id, 'defaultadmin', $returnid, array('__activetab'=>'compets', 'indivs_suivies'=>'1' ));

#
# EOF
#
?>
