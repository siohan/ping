<?php
###########################################################
##             Script Cron                               ##
##       Récupération des joueurs                        ##
###########################################################
$path = dirname(dirname(__FILE__));
$absolute_path = str_replace('modules','',$path);
define('ROOT',dirname($absolute_path));
require_once(ROOT.'/config.php');

$link = mysqli_connect($config['db_hostname'],$config['db_username'],$config['db_password'],$config['db_name']) or die("Error " . mysqli_error($link));
/* check connection */
if (mysqli_connect_errno()) {
    $message = "Connection impossible";
echo $message;
    
}

//$now = trim($link->DBTimeStamp(time()), "'");

//on fait un tableau qui récapitule toutes les possibilités (F, Z etc...)
//on récupère les préférences...
$tab= array("Ping_mapi_pref_club_number", "Ping_mapi_pref_idAppli", "Ping_mapi_pref_serie","Ping_mapi_pref_motdepasse","Ping_mapi_pref_saison_en_cours", "Ping_mapi_pref_phase_en_cours","Ping_mapi_pref_ligue", "Ping_mapi_pref_zone","Ping_mapi_pref_dep","Ping_mapi_pref_nom_equipes");
foreach($tab as $value)
{
	

	$query = "SELECT sitepref_value FROM ".$config['db_prefix']."siteprefs WHERE sitepref_name LIKE '".$value."'";
	//echo $query;
	$result = $link->query($query); 
	//var_dump($result);
	if($result)
	{
		while ($row = mysqli_fetch_assoc($result)) 
		{
        		$$value = $row['sitepref_value'];
			//var_dump($row);
			//echo $$value."<br/>";
    		}
	}

}
//
$mois_courant = date('n');//Mois au format 1, 2, 3 etc....
$annee_courante = date('Y');//l'année au format 0000
$mois_francais = array('Janvier', 'Février','Mars', 'Avril', 'Mai', 'Juin', 'Juillet','Août', 'Septembre', 'Octobre','Novembre','Décembre');
//$now = trim($db->DBTimeStamp(time()), "'");
$mois_reel = $mois_courant - 1;//pour afficher le mois au format français
$mois_sm = $mois_francais["$mois_reel"];
$mois_sit_mens = $mois_sm." ".$annee_courante;
$jour = date('j');
//
$designation = '';


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
	//$this->SetMessage($message);
//	$this->RedirectToAdminTab('joueurs');
}
else 
{
	$page = "xml_licence_b";
	$service = new Servicen();
	//paramètres nécessaires 
	$var="club=".$club_number;
	$lien = $service->GetLink($page,$var);
	//echo $lien;
	//var_dump($lien);
	$xml = simplexml_load_string($lien, 'SimpleXMLElement', LIBXML_NOCDATA);
	//var_dump($xml);
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
		//on supprime l'existant ? Oui.
		$query2 = "DELETE FROM ".cms_db_prefix()."module_ping_joueurs";
		$dbresult2 = $db->Execute($query2);
	
	
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

					if($dbresultat)
					{
						
						//on le pousse dans la table des récupération
						$query = "SELECT licence FROM ".cms_db_prefix()."module_ping_recup_parties WHERE licence = ? ";
						$dbresult = $db->Execute($query, array($licence));
						$count = $dbresult->RecordCount();
						if($count==0)//on est ok , pas d'enregistrement correspondant
						{
							//on fait la totale en récupérant toutes les données ?
							//où on laisse l'admin le faire ?
							//pour l'heure on fait le mini
							$query2 = "INSERT INTO ".cms_db_prefix()."module_ping_recup_parties (id, saison, datemaj, licence, sit_mens,fftt,maj_fftt,spid,maj_spid,maj_total,spid_total) VALUES('', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
							$dbresult2 = $db->Execute($query2, array($saison,$now,$licence,'Janvier 2000',0,0,0,0,0,0));

							//on teste la requete
							if(!$dbresult2)
							{
								//une erreur ? laquelle ?
								$message = $db->ErrorMsg();
								$status = 'Pb Joueur poussé';
								$action = 'push_player';
								ping_admin_ops::ecrirejournal($now,$status,$message,$action);
								

							}
							else //tout s'est bien passé
							{
								//on écrit dans le journal
								$status = 'Joueur poussé';
								$designation = 'joueur poussé : '.$licence;
								$action = 'push_player';
								ping_admin_ops::ecrirejournal($now,$status,$designation,$action);
								
							}

						}
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