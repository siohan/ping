<?php
if( !isset( $gCms) ) exit;
$db = cmsms()->GetDb();
//debug_display($params, 'Parameters');
$phase = (isset($params['phase'])?$params['phase'] : $this->GetPreference('phase_en_cours'));
if(isset($params['idepreuve']) && $params['idepreuve'] !='')
{
	$idepreuve = $params['idepreuve'];	
}
if(!empty($this->GetPreference('details_rencontre_page')) )
{
	$cg_ops = new CMSMSExt;
	$alias_page = $this->GetPreference('details_rencontre_page');
	$landing_page = $cg_ops->resolve_alias_or_id($alias_page);
	
}
//$nom_equipes = $this->GetPreference('nom_equipes');
$record_id = '';
$parms = array();
if(isset($params['template']) && $params['template'] !="")
{
	$template = trim($params['template']);
}
else {
    $tpl = CmsLayoutTemplate::load_dflt_by_type('Ping::Classements Club');
    if( !is_object($tpl) ) {
        audit('',$this->GetName(),'Template résultats pour une équipe introuvable');
        return;
    }
    $template = $tpl->get_name();
}
$query = "SELECT cl.id AS row_id,cl.clt, cl.joue,cl.equipe,cl.pts,cl.vic, cl.nul, cl.def, cl.pg, cl.pp, cl.pf,eq.libequipe,eq.friendlyname, eq.numero_equipe, eq.idpoule FROM ".cms_db_prefix()."module_ping_classement AS cl, ".cms_db_prefix()."module_ping_equipes AS eq WHERE eq.id = cl.idequipe ";
//$query.=" AND cl.equipe LIKE ? ";
$query.= "AND cl.equipe = eq.libequipe AND eq.phase = ?";



$parms['phase'] = $phase;

	
$query.=" AND eq.idepreuve = ?";
$parms['idepreuve'] = $idepreuve;

//on ordonne la table
$query.= " ORDER BY eq.numero_equipe ASC";
if(isset($params['number']) && $params['number'] > 0)
{
	$number = (int) $params['number'];
	$query.=" LIMIT ?";
	$parms['number'] = $number;
}

//on effectue la requete
$dbresult = $db->Execute($query,$parms);
//echo $query;
$rowarray = array();
if($dbresult && $dbresult->RecordCount()>0)
{
	while($row = $dbresult->FetchRow())
	{
		$classement = $row['clt'];
		$idpoule = $row['idpoule'];
		if($classement == '0' || $classement =='-')
		{
			//il faut sélectionner un id au dessus
			$query2 = "SELECT clt FROM ".cms_db_prefix()."module_ping_classement WHERE id < ? AND idpoule = ? AND saison = ? AND clt !='0' ORDER BY id DESC LIMIT 1";
			$dbresult2 = $db->Execute($query2, array($row['row_id'],$idpoule,$saison));
			$row2 = $dbresult2->FetchRow();
			$classement = $row2['clt'];
		}
		$joue = $row['joue'];
		$friendlyname = $row['friendlyname'];
		
	
		$onerow= new StdClass();
		if($friendlyname !='')
		{
			$onerow->equipe= $row['friendlyname'];
		}
		else
		{
			$onerow->equipe= $row['equipe'];
		}
		$onerow->clt=  $classement;		
		$onerow->joue= $row['joue'];
		$onerow->pts= $row['pts'];
		$onerow->vic= $row['vic'];
		$onerow->nul= $row['nul'];
		$onerow->def= $row['def'];
		$onerow->pg= $row['pg'];//points gagnés
		$onerow->pp= $row['pp'];//points perdus
		$onerow->diff = $row['pg'] - $row['pp'];
		//$onerow->equipe = $row['equipe'];		
		$rowarray[]  = $onerow;
			
	}

}
else
{
	 /* 
	  * echo " pas de resultat";
		$designation = $db->ErrorMsg();
		echo $designation;
	*/
}

$smarty->assign('items', $rowarray);
$smarty->assign('itemcount', count($rowarray));
$smarty->assign('landing_page', $landing_page);
$tpl = $smarty->CreateTemplate($this->GetTemplateResource($template),null,null,$smarty);
$tpl->display();//echo $this->ProcessTemplate('classement.tpl');
#
#EOF
#
?>
