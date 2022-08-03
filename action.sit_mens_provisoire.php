<?php

if( !isset($gCms) ) exit;
//debug_display($params, 'Parameters');
$db = cmsms()->GetDb();


if(isset($params['template']) && $params['template'] != '')
{
	$template = $params['template'];
}
else {
    $tpl = CmsLayoutTemplate::load_dflt_by_type('Ping::Situation En Live');
    if( !is_object($tpl) ) {
        audit('',$this->GetName(),'Template situation provisoire introuvable');
        return;
    }
    $template = $tpl->get_name();
}

$query="SELECT j.licence , spid, spid_total, spid_errors, maj_spid, pts_spid FROM ".cms_db_prefix()."module_ping_recup_parties AS rc, ".cms_db_prefix()."module_ping_joueurs AS j WHERE rc.licence = j.licence  AND j.actif =1 AND j.type='T'";	

if(isset($params['number']) && $params['number'] >0)
{
	$query.=" ORDER BY pts_spid DESC LIMIT ?";
	$dbresult = $db->Execute($query, array($params['number']));
}
else
{
	$dbresult = $db->Execute($query);
}

$rowclass= 'row1';
$rowarray= array ();

if ($dbresult && $dbresult->RecordCount()>0)
{
		$j_ops = new joueurs;
		
		while($row= $dbresult->FetchRow())
		{
			$onerow= new StdClass();
			$onerow->rowclass= $rowclass;
			$details = $j_ops->details_joueur($row['licence']);
			$onerow->actif = $details['actif'];
			$onerow->joueur= $details['nom'].' '.$details['prenom'];
			$onerow->maj_spid= $details['maj_spid'];
			$onerow->clt=$details['clast'];
			$onerow->somme = $row['pts_spid'];
			$onerow->bilan = $details['clast'] + $row['pts_spid'];
			//$onerow->details= $this->CreateFrontendLink($id, $returnid,'user_results_prov', $contents='Détails',array('licence'=>$row['licence'],'month'=>$mois_courant));
			($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
			$rowarray[]= $onerow;
		}
}
else
{
	echo $db->ErrorMsg();
}
	
$smarty->assign('returnlink', 
		$this->CreateFrontendLink($id,$returnid, 'sit_mens_provisoire',$addtext='Retour'));
$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
$smarty->assign('itemcount', count($rowarray));
$smarty->assign('items', $rowarray);

$tpl = $smarty->CreateTemplate($this->GetTemplateResource($template), null, null, $smarty);
$tpl->display();


#
# EOF
#
?>
