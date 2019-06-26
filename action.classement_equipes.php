<?php
if( !isset( $gCms) ) exit;
$db =& $this->GetDb();
//debug_display($params, 'Parameters');
$saison = (isset($params['saison'])?$params['saison']:$this->GetPreference('saison_en_cours'));
$phase = (isset($params['phase'])?$params['phase']:$this->GetPreference('phase_en_cours'));
//$nom_equipes = $this->GetPreference('nom_equipes');
$record_id = '';
$parms = array();
if(isset($params['template']) && $params['template'] !="")
{
	$template = trim($params['template']);
}
else {
    $tpl = CmsLayoutTemplate::load_dflt_by_type('Ping::Résultats pour une équipe');
    if( !is_object($tpl) ) {
        audit('',$this->GetName(),'Template résultats pour une équipe introuvable');
        return;
    }
    $template = $tpl->get_name();
}
$query = "SELECT cl.id AS row_id,cl.clt, cl.joue,cl.equipe,cl.pts,cl.vic, cl.nul, cl.def, cl.pg, cl.pp, cl.pf,eq.libequipe,eq.friendlyname, eq.numero_equipe, eq.idpoule FROM ".cms_db_prefix()."module_ping_classement AS cl, ".cms_db_prefix()."module_ping_equipes AS eq WHERE eq.id = cl.idequipe ";
//$query.=" AND cl.equipe LIKE ? ";
$query.= "AND cl.equipe = eq.libequipe  AND cl.saison = ? AND phase = ?";


$parms['saison'] = $saison;
$parms['phase'] = $phase;
//en parametres possibles : 
#le championnat recherché ou non
#une equipe précise ou non
	if(isset($params['idepreuve']) && $params['idepreuve'] !='')
	{
		$idepreuve = $params['idepreuve'];
		$query.=" AND eq.idepreuve = ?";
		$parms['idepreuve'] = $idepreuve;
		
	}


//on aordonne la table
$query.= " ORDER BY eq.numero_equipe ASC";


//on effectue la requete
$dbresult = $db->Execute($query,$parms);//array($equipes,$saison,$phase,$idepreuve));
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
		//$onerow->equipe = $row['equipe'];		
		$rowarray[]  = $onerow;
			
	}

}
else
{
	 echo " pas de resultat";
	$designation = $db->ErrorMsg();
	echo $designation;
}

$smarty->assign('items', $rowarray);
$smarty->assign('itemcount', count($rowarray));
$tpl = $smarty->CreateTemplate($this->GetTemplateResource($template),null,null,$smarty);
$tpl->display();//echo $this->ProcessTemplate('classement.tpl');
#
#EOF
#
?>