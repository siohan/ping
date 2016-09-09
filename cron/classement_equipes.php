<?php
if( !isset ( $gCms ) ) exit;
//debug_display($params, 'Parameters');
$db =& $this->GetDb();
//on vérifie les permissions d'abord
if(! $this->CheckPermission('Ping Use')) exit;
require_once(dirname(__FILE__).'/include/prefs.php');
$saison = $this->GetPreference('saison_en_cours');
$phase = $this->GetPreference('phase_en_cours');
$error = 0;
$designation = '';
$full = 0;//variable pour récupérer l'ensemble des résultats ou une seule, par défaut 0 cad toutes
$record_id = '';
$lignes = 0;

//on fait une requete générale et on affine éventuellement
$query = "SELECT iddiv, idpoule, id as id_equipe FROM ".cms_db_prefix()."module_ping_equipes WHERE saison = ? ";//AND phase = ?";
$parms['saison'] = $saison;
//$parms['phase']  = $phase;

if(isset($params['record_id']) && $params['record_id'] !='')
{
	$record_id = $params['record_id'];
	$query.=" AND id = ?";
	$parms['id'] = $record_id;
	$full = 1;
}

$dbresult = $db->Execute($query, $parms);

//bon tt va bien, tt est Ok
//on fait la boucle
if($dbresult && $dbresult->RecordCount()>0)
{
	while( $dbresult && $row = $dbresult->FetchRow())
	{
		$iddiv = $row['iddiv'];
		$idpoule = $row['idpoule'];
		$id_equipe = $row['id_equipe'];		
		$service = new retrieve_ops();
		if($full == '0')//toutes les équipes sont sélectionnées
		{
			$retrieve = $service->retrieve_all_classements($iddiv,$idpoule,$record_id=$id_equipe);
			sleep(1);
		}
		else
		{
			$retrieve = $service->retrieve_all_classements($iddiv,$idpoule,$record_id=$params['record_id']);
		}
		//$idequipe = $row['id']
		
	}
	$this->RedirectToAdminTab('equipes');
}
else
{
	echo "Pas de résultats ou requete incorrecte";
}




#
#EOF
#
?>