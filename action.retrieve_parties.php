<?php
if( !isset($gCms) ) exit;
if (!$this->CheckPermission('Ping Use'))
{
	echo $this->ShowErrors($this->Lang('needpermission'));
	return;
}

//debug_display($params, 'Parameters');
//require_once(dirname(__FILE__).'/function.calculs.php');

$now = trim($db->DBTimeStamp(time()), "'");
$mois_courant = date('n');
$annee_courante = date('Y');
$saison = $this->GetPreference('saison_en_cours');
$licence = '';
if(isset($params['licence']) && $params['licence'] !='')
{
	$licence = $params['licence'];
}
else
{
	$this->SetMessage('Il manque le numéro de licence');
	$this->RedirectToAdminTab('fftt');
}

$designation = '';
$query = "SELECT CONCAT_WS(' ', nom, prenom) AS player FROM ".cms_db_prefix()."module_ping_joueurs WHERE licence = ?";
$dbretour = $db->Execute($query, array($licence));

	if ($dbretour && $dbretour->RecordCount() > 0)
  	{
    		while ($row= $dbretour->FetchRow())
      		{
			$player = $row['player'];
			//return $player;
		}
	
	}
	else
	{
		$this->SetMessage("Joueur introuvable");
		$this->RedirectToAdminTab('recup');
	}

//on redirige vers la méthode ...
$service = new retrieve_ops();
//$service = new Servicen();
$retrieve = $service->retrieve_parties_fftt($licence);

$this->SetMessage("$designation");
$this->RedirectToAdminTab('recup');

#
# EOF
#
?>