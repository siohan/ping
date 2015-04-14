<?php
if( !isset($gCms) ) exit;
//debug_display($params, 'Parameters');
if(!$this->CheckPermission('Ping Use'))
{
	$this->SetMessage($this->Lang('needpermission'));
	$this->RedirectToAdminTab('joueurs');
}
$now = trim($db->DBTimeStamp(time()), "'");
$saison = $this->GetPreference('saison_en_cours');
$club_number = $this->GetPreference('club_number');
//
$mois_courant = date('n');//Mois au format 1, 2, 3 etc....
$annee_courante = date('Y');//l'année au format 0000
$mois_francais = array('Janvier', 'Février','Mars', 'Avril', 'Mai', 'Juin', 'Juillet','Août', 'Septembre', 'Octobre','Novembre','Décembre');
$now = trim($db->DBTimeStamp(time()), "'");
$mois_reel = $mois_courant - 1;//pour afficher le mois au format français
$mois_sm = $mois_francais["$mois_reel"];
$mois_sit_mens = $mois_sm." ".$annee_courante;
//
$designation = '';

if(!isset($club_number) || $club_number =='')
{
	$this->SetMessage('Le numéro de club n\'est pas défini !');
	$this->RedirectToAdminTab('configuration');
}
$service = new Service();
$result = $service->getJoueursByClub("$club_number");

//var_dump($result);
if (!is_array($result))
{
	$this->SetMessage('Service coupé');
	$this->RedirectToAdminTab('joueurs');
}
/**/
$i =0;
foreach($result as $cle =>$tab)
{
	$licence = $tab[licence];
	$nom = $tab[nom];
	$prenom = $tab[prenom];
	$actif = 1;	
	//$designation = 'récupération des joueurs';
	
	$query = "SELECT licence FROM ".cms_db_prefix()."module_ping_joueurs WHERE licence = ?";
	$dbresult = $db->Execute($query, array($licence));
	
	if($dbresult  && $dbresult->RecordCount() == 0) 
	{
		$query = "INSERT INTO ".cms_db_prefix()."module_ping_joueurs (id, licence, nom, prenom,actif) VALUES ('', ?, ?, ?, ?)";
		$dbresultat = $db->Execute($query,array($licence,$nom, $prenom,$actif));
		$i++;
		
		if(!$dbresultat)
		{
			$designation.= $db->ErrorMsg();
		}
		else
		{
			//on écrit dans le journal
			$status = 'Ok';
			$message = "Inclusion de ".$nom." ".$prenom;
			$action = "retrieve_users";
			ping_admin_ops::ecrirejournal($now,$status,$message,$action);
		}
		
		//on va chercher la situation mensuelle si elle est accessible
		
		$sit_mens = '';	
		//on réalise aussi une inclusion dans la table des situations mensuelles
		//si l'accès est libre cad après le 10 de chq mois
		if(date('n')>=10)
		{
			$query = "SELECT licence FROM ".cms_db_prefix()."module_ping_recup_parties WHERE licence = ? AND saison = ?";
			$dbresult = $db->Execute($query, array($licence,$saison));

			if($dbresult->RecordCount()==0)
			{
				ping_admin_ops::retrieve_sit_mens($licence);
				$sit_mens = $mois_sit_mens;

			}


		}
		else
		{
			$sit_mens = $mois_sit_mens;
		}
		
		//on fait l'ajout dans la table table_recup
		// on part du principe que si le joueur n'existe pas dans la table joueurs alors il n'existe pas non plus ailleurs
		$fftt = 0;
		$spid = 0;
		$query2 ="INSERT INTO ".cms_db_prefix()."module_ping_recup_parties (id,saison,datemaj,licence, sit_mens, fftt, spid) VALUES ('', ?, ?, ?, ?, ?, ?)";
		$result = $db->Execute($query2, array($saison, $now, $licence, $sit_mens, $fftt, $spid));
		
	}		
	
	
		
}// fin du foreach


	$designation.= "Inclusion de  ".$i." joueurs (voir journal)";
	$this->SetMessage("$designation");
	$this->RedirectToAdminTab('joueurs');
/**/
#
# EOF
#
?>