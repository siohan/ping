<?php
if( !isset ( $gCms ) ) exit;
//debug_display($params, 'Parameters');
$db =& $this->GetDb();
//on vérifie les permissions d'abord
if(! $this->CheckPermission('Ping Use')) exit;
require_once(dirname(__FILE__).'/include/prefs.php');
$error = 0;
$designation = '';

$idpoule = '';
	if(isset($params['idpoule']) && $params['idpoule'] !='' )
	{
		$idpoule = $params['idpoule'];
	}
	else
	{
		$error++;
	}
	
$iddiv = '';
	if(isset($params['iddiv']) && $params['iddiv'] !='')
	{
		$iddiv = $params['iddiv'];
	}
	else
	{
		$error++;
	}
$record_id = '';
	if(isset($params['record_id']) && $params['record_id'] !='')
	{
		$record_id = $params['record_id'];
	}
	else
	{
		$error++;
	}
$code_compet = '';
	if(isset($params['type_compet']) && $params['type_compet'] !='')
	{
		$code_compet = $params['type_compet'];
	}
	else
	{
		$error++;
	}
if($error>0)
{
	$this->SetMessage('Paramètres manquants');
	$this->RedirectToAdminTab('equipes');
	
}
//bon tt va bien, tt est Ok
$service = new Service();
$result = $service->getPouleClassement($iddiv, $idpoule);
//var_dump($result);

//on vérifie que le resultat est bien un array

if(!is_array($result) || count($result)==0) 
{
	//on revient à la case départ
	$this->SetMessage('Le service est coupé');
	$this->RedirectToAdminTab('equipes');
	
}
//tt va bien, on continue
//on supprime tt ce qui était ds la bdd pour cette poule
$query = "DELETE FROM ".cms_db_prefix()."module_ping_classement WHERE iddiv = ? AND idpoule= ? AND idequipe = ? AND saison = ?";
$dbresult = $db->Execute($query, array($iddiv, $idpoule, $record_id,$saison_courante));

//on récupère le résultat et on fait le foreach
foreach($result as $cle =>$tab)
{
	$poule = $tab['poule'];
	$clt = $tab['clt'];
	$equipe = $tab['equipe'];
	$joue = $tab['joue'];
	$pts = $tab['pts'];
	
	$query2 = "INSERT INTO ".cms_db_prefix()."module_ping_classement (id,idequipe, saison, code_compet, iddiv, idpoule, poule, clt, equipe, joue, pts) VALUES ('', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
	//echo $query2;
	$dbresultat = $db->Execute($query2, array($record_id,$saison_courante,$code_compet, $iddiv, $idpoule,$poule, $clt, $equipe, $joue,$pts));
	
	if(!$dbresultat)
	{
		$designation.= $db->ErrorMsg();
		$status = 'Ok';
		$action = 'getPouleclassement';
		$this->SetMessage("$designation");
		ping_admin_ops::ecrirejournal($now,$status,$designation,$action);
	}
	
}

$this->SetMessage('Classement récupéré');
$this->RedirectToAdminTab('equipes');



#
#EOF
#
?>