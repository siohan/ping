<?php
#################################################################################
###                   Récupération de la situation mensuelle                  ###
###                   Auteur Claude SIOHAN                                    ###
#################################################################################

if( !isset($gCms) ) exit;
//on vérifie les permissions
if (!$this->CheckPermission('Ping Use'))
{
	echo $this->ShowErrors($this->Lang('needpermission'));
	return;
}
//debug_display($params, 'Parameters');
//require_once(dirname(__FILE__).'include/prefs.php');
$db=$gCms->GetDb();

//les préférences
$mois_courant = date('n');
$mois_francais = array('Janvier', 'Février','Mars', 'Avril', 'Mai', 'Juin', 'Juillet','Août', 'Septembre', 'Octobre','Novembre','Décembre');
$annee_courante = date('Y');
$mois_reel = $mois_courant - 1;
$mois_sm = $mois_francais["$mois_reel"];
$mois_sit_mens = $mois_sm." ".$annee_courante;
$saison = $this->GetPreference('saison_en_cours');
$designation = ''; //instanciation du message de sortie

//echo "le mois de la situation mensuelle est : ".$mois_sit_mens;
$now = trim($db->DBTimeStamp(time()), "'");

$licence = '';

	if(!isset($params['licence']) && $params['licence'] =='')
	{
		$designation .= 'Pas de n° de licence';
		$this->SetMessage($designation);
		$this->RedirectToAdminTab('recup');
	}
	else
	{
		$licence = $params['licence'];
	}

//on vérifie que le joueur en question est bien actif
$query = "SELECT CONCAT_WS(' ',nom,prenom) as player, licence FROM ".cms_db_prefix()."module_ping_joueurs WHERE licence = ? AND actif = '1'";
$dbresult = $db->Execute($query, array($licence));
//le joueur ne remplit pas les conditions de la requete, on renvoit avec un message
if ($dbresult && $dbresult->RecordCount() == 0)
{
	$this->SetMessage("Joueur désactivé");
	$this->RedirectToAdminTab('situation');
}
else
{
//le joueur est actif, on va vérifier si sa situation mensuelle est déjà enregistrée
$query = "SELECT licence FROM ".cms_db_prefix()."module_ping_sit_mens WHERE licence = ? AND mois = ? AND annee = ?";
$dbresultat = $db->Execute($query, array($licence,$mois_courant,$annee_courante));
	
	if($dbresultat && $dbresultat->RecordCount()>0){
		//la situation mensuelle est déjà à jour, on passe
		$this->SetMessage('Situation mensuelle déjà à jour !');
		$this->RedirectToAdminTab('joueurs');
		
	}
	else
	{
		
		$row = $dbresult->FetchRow();
		$player = $row['player'];
		$service = new retrieve_ops();
		$sit_mens = $service->retrieve_sit_mens("$licence");
		//$service->retrieve_sit_mens("$licence");
		//on ramène vers la lib qui va traiter la situation mensuelle
		
						
	}//fin de la vérification de la sit_mens en bdd
}//fin du test si le joueur est actif en bdd

$this->SetMessage('Consultez le journal');
$this->RedirectToAdminTab('recup');

#
# EOF
#
?>