<?php
if( !isset($gCms) ) exit;
//debug_display($params, 'Parameters');
if(!$this->CheckPermission('Ping Use'))
{
	$this->SetMessage($this->Lang('needpermission'));
	$this->RedirectToAdminTab('joueurs');
}
require_once(dirname(__FILE__).'/include/prefs.php');
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
$jour = date('j');
//
$designation = '';

if(!isset($club_number) || $club_number =='')
{
	$this->SetMessage('Le numéro de club n\'est pas défini !');
	$this->RedirectToAdminTab('configuration');
}

//$service = new ServiceB();
//$result = $service->getLicencesByClub("$club_number");

//ci-dessous, on met à jour les joueurs se trouvant dans la base classement de la FFTT
if(isset($params['direction']) && $params['direction']== "fftt")
{
	$page = "xml_liste_joueur";
	$service = new Servicen();
	//paramètres nécessaires 
	$var = "club=".$club_number;
	$lien = $service->GetLink($page,$var);
	$xml = simplexml_load_string($lien);
	
	$i =0;//compteur pour les nouvelles inclusions
	$a = 0;//compteur pour les mises à jour
	foreach($xml as $tab)
	{
		$licence = (isset($tab->licence)?"$tab->licence":"");
		$actif = 1;
			
			//le joueur existe déjà , on fait un upgrade
			//on vérifie
		$a++;
		$query = "UPDATE ".cms_db_prefix()."module_ping_joueurs SET actif = ? WHERE licence = ?";
		$dbresult = $db->Execute($query, array($actif, $licence));
				
	}// fin du foreach
	//on redirige sur l'onglet joueurs
	$message = $a." mises à jour";
	$this->SetMessage($message);
	$this->RedirectToAdminTab('joueurs');
}
else 
{
	$page = "xml_licence_b";
	$service = new Servicen();
	//paramètres nécessaires 
	$var="club=".$club_number;
	$lien = $service->GetLink($page,$var);
	echo $lien;
	var_dump($lien);
	$xml = simplexml_load_string($lien, 'SimpleXMLElement', LIBXML_NOCDATA);
	var_dump($xml);
	if($xml === FALSE)
	{
		$array = 0;
		$lignes = 0;
	}
	else
	{
		$array = json_decode(json_encode((array)$xml), TRUE);
		$lignes = count($array['licence']);
	}
	//echo "le nb de lignes est : ".$lignes;
	if($lignes == 0)
	{
		$message = "Pas de lignes à récupérer !";
		$this->SetMessage("$message");
		//$this->RedirectToAdminTab('joueurs');
	}
	else
	{
		
	
	
			$i =0;//compteur pour les nouvelles inclusions
			$a = 0;//compteur pour les mises à jour
			foreach($xml as $tab)
			{
				//$licence = (isset($tab->licence)?"$tab->licence":"");
				$licence = (isset($tab->licence)?"$tab->licence":"");
				$nom = (isset( $tab->nom)?"$tab->nom":"");
				$prenom = (isset($tab->prenom)?"$tab->prenom": "");
				$nclub = (isset($tab->numclub)?"$tab->numclub":"");
				$actif = 0;
				$sexe = (!empty($tab->sexe)?"$tab->sexe":"");
				$type = (!empty($tab->type)?"$tab->type" :"");
				$certif = (!empty($tab->certif)?"$tab->certif":"");
				$validation = (!empty($tab->validation)?"$tab->validation":"");
				$echelon = (!empty($tab->echelon)?"$tab->echelon":"");

				$place = (!empty($tab->place)?"$tab->place":"");
				$point = (!empty($tab->point)?"$tab->point":"");
				$cat = (!empty($tab->cat)?"$tab->cat":"");


				//$designation = 'récupération des joueurs';

				$query = "SELECT licence FROM ".cms_db_prefix()."module_ping_joueurs WHERE licence = ?";
				$dbresult = $db->Execute($query, array($licence));

				if($dbresult  && $dbresult->RecordCount() == 0) 
				{
					$query = "INSERT INTO ".cms_db_prefix()."module_ping_joueurs (id, licence, nom, prenom,actif, sexe, type, certif, validation, echelon, place, point, cat) VALUES ('', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
					$dbresultat = $db->Execute($query,array($licence,$nom, $prenom,$actif, $sexe, $type, $certif, $validation, $echelon,$place,$point, $cat));
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
			
				}
				else
				{
					//le joueur existe déjà , on fait un upgrade
					//on vérifie
					$a++;
					$query = "UPDATE ".cms_db_prefix()."module_ping_joueurs SET actif = ?,sexe = ?, type = ?, certif = ?, validation = ?, echelon = ?, place = ?, point = ?, cat = ? WHERE licence = ?";
					$dbresult = $db->Execute($query, array($actif,$sexe, $type, $certif,$validation, $echelon, $place, $point, $cat, $licence));
				}		

		
			}// fin du foreach
	$this->Redirect($id,'retrieve_users',$returnid,$params = array("direction"=>"fftt"));
	
	}//fin du else
}

	

#
# EOF
#
?>