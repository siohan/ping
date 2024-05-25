<?php
//cette page récupère l'ensemble des résultats dispo pour une compétition individuelle
 
if( !isset($gCms) ) exit;
if(!$this->CheckPermission('Ping Use'))
{
	$this->SetMessage($this->Lang('needpermission'));
	$this->RedirectToAdminTab('compets');
}

//debug_display($params, 'Parameters');
//var_dump($params['sel']);
$db = cmsms()->GetDb();
$ret = new retrieve_ops;
$epr = new EpreuvesIndivs;
$log = new png_admin_ops;

if(isset($params['idepreuve']) && $params['idepreuve'] != '')
{
	$idepreuve = $params['idepreuve'];
}
if(isset($params['next']))
{
	$idepreuve = $epr->next($idepreuve);
}
	

	
$orga = array('fede'=>$this->GetPreference('fede'), 'zone'=>$this->GetPreference('zone'),'ligue'=>$this->GetPreference('ligue'), 'dep'=>$this->GetPreference('dep'));
if(isset($params['type']) && $params['type'] != '')
{
	$type = $params['type'];
}
else
{
	$type = '';
}
foreach($orga as $value)
{
	$retrieve = $ret->retrieve_divisions($value,$idepreuve,$type="");
}
$nb_divisions = $epr->nb_divisions($idepreuves);
if($nb_divisions >0)
{
	$status = 1;
	$designation = $idepreuve.' : '.$nb_divisions. 'récupérées';
	$action = "retrieve_indivs";
	$log->ecrirejournal($status, $sdeignation, $action);
	$this->Redirect($id, 'retrieve_tours_indivs', $returnid, array("idepreuve"=>$idepreuve));
}
else
{
	//Pas de divisions récupérées, on passe à l'épreuve suivante
	$status = 0;
	$designation = $idepreuve.' : pas de divisions récupérées';
	$action = "retrieve_indivs";
	$log->ecrirejournal($status, $sdeignation, $action);
	$this->Redirect($id, 'retrieve_div_indivs', $returnid, array("idepreuve"=>$idepreuve, "next"=>"1"));
}
