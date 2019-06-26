<?php
#################################################################################
###           RECUPERATION DES PARTIES SPID                                   ###
#################################################################################
if( !isset($gCms) ) exit;
if (!$this->CheckPermission('Ping Use'))
{
	echo $this->ShowErrors($this->Lang('needpermission'));
	return;
}
//debug_display($params, 'Parameters');
$compteur = 0;
$licence = '';
if(isset($params['licence']) && $params['licence'] !='')
{
	$licence = $params['licence'];
}
else
{
	$this->SetMessage('pas de numéro de licence !');
	$this->RedirectToAdminTab('joueurs');
}

$designation = '';
$spid_calcul = $this->GetPreference('spid_calcul');
/*
if($spid_calcul == 1)
{

*/
	$query = "SELECT CONCAT_WS(' ', j.nom, j.prenom) AS player, adh.cat FROM ".cms_db_prefix()."module_ping_joueurs as j, ".cms_db_prefix()."module_adherents_adherents AS adh WHERE j.licence = adh.licence AND j.licence = ?";
	$dbretour = $db->Execute($query, array($licence));
	if ($dbretour && $dbretour->RecordCount() > 0)
	{
	    	$service = new retrieve_ops;
		$ping_ops = new ping_admin_ops;
		$spid_ops = new spid_ops;
		while ($row= $dbretour->FetchRow())
	      	{
			$compteur++;
			$player = $row['player'];
			$cat = $row['cat'];
			//return $player;
			
			$resultats = $service->spid_sans_calcul($licence);//,$player,$cat);
			$ping_ops->compte_spid($licence);
			$ping_ops->compte_spid_errors($licence);
			$spid_ops->recalcul($licence);
			
			//var_dump($resultats);
		}

	}
	else
	{
		$designation.="Joueur introuvable";
	}
/*
}
else
{
	$service = new retrieve_ops();
	$resultats = $service->retrieve_parties_spid($licence);
}
*/


	
$this->SetMessage("$designation");
$this->RedirectToAdminTab('recup');

#
# EOF
#
?>