<?php
###########################################################
##             Script Cron                               ##
##       Récupération des joueurs                        ##
##                                                       ##
##                  ATTENTION !                          ##
##      Ce script doit impérativement être utilisé       ##
##           avec l'autre script joueurs2 !!             ##
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
$now = date("Y-m-d H:i:s");//trim($db->DBTimeStamp(time()), "'");
$mois_reel = $mois_courant - 1;//pour afficher le mois au format français
$mois_sm = $mois_francais["$mois_reel"];
$mois_sit_mens = $mois_sm." ".$annee_courante;
$jour = date('j');
//
$designation = '';


	$tm = substr(date('YmdHisu'),0,17);//le timestamp
	$tmc = hash_hmac("sha1",$tm,$Ping_mapi_pref_motdepasse);
	$page = "xml_licence_b";
	//paramètres nécessaires 
	$var="club=".$Ping_mapi_pref_club_number;
	$chaine = 'http://www.fftt.com/mobile/pxml/'.$page.'.php?serie='.$Ping_mapi_pref_serie.'&tm='.$tm.'&tmc='.$tmc.'&id='.$Ping_mapi_pref_idAppli.'&'.$var; 
	//echo "<a target=\"_blank\" href=\"".$chaine."\">".$chaine."</a><br/>";
	$lien =  file_get_contents($chaine);
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
		$query2 = "DELETE FROM ".$config['db_prefix']."module_ping_joueurs";
		$dbresult2 = $link->query($query2);
	
	
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

				$query = "SELECT licence FROM ".$config['db_prefix']."module_ping_joueurs WHERE licence = '".$licence."'";
				$dbresult = $link->query($query);
				$row_cnt = mysqli_num_rows($dbresult);
				if($row_cnt == 0) 
				{
					$query = "INSERT INTO ".$config['db_prefix']."module_ping_joueurs (id, licence, nom, prenom,actif, sexe, type, certif, validation, echelon, place, point, cat) VALUES ('', '".$licence."','".$nom."', '".$prenom."','".$actif."', '".$sexe."', '".$type."', '".$certif."', '".$validation."', '".$echelon."','".$place."','".$point."', '".$cat."')";
					$dbresultat = $link->query($query);//,array($licence,$nom, $prenom,$actif, $sexe, $type, $certif, $validation, $echelon,$place,$point, $cat));
					$i++;

					if($dbresultat)
					{
						
						//on le pousse dans la table des récupération
						$query = "SELECT licence FROM ".$config['db_prefix']."module_ping_recup_parties WHERE licence = '".$licence."' ";
						$dbresult = $link->query($query);
						$count = mysqli_num_rows($dbresult);
						if($count==0)//on est ok , pas d'enregistrement correspondant
						{
							//on fait la totale en récupérant toutes les données ?
							//où on laisse l'admin le faire ?
							//pour l'heure on fait le mini
							$query2 = "INSERT INTO ".$config['db_prefix']."module_ping_recup_parties (id, saison, datemaj, licence, sit_mens,fftt,maj_fftt,spid,maj_spid,maj_total,spid_total) VALUES('', '".$saison."','".$now."','".$licence."','Janvier 2000',0,0,0,0,0,0)";
							$dbresult2 = $link->query($query2);
							$count2 = mysqli_num_rows($dbresult2);
							//on teste la requete
							
						}
						
					}
			
				}
				else
				{
					//le joueur existe déjà , on fait un upgrade
					//on vérifie
					$a++;
					$query = "UPDATE ".$config['db_prefix']."module_ping_joueurs SET actif = '".$actif.",sexe = '".$sexe."', type = '".$type."', certif = '".$certif."', validation = '".$validation."', echelon = '".$echelon."', place = '".$place."', point = '".$point."', cat = '".$cat." WHERE licence = '".$licence."'";
					$dbresult = $link->query($query);//, array($actif,$sexe, $type, $certif,$validation, $echelon, $place, $point, $cat, $licence));
				}		

		
			}// fin du foreach
	}
//on envoie un mail qui donne les infos
// Dans le cas où nos lignes comportent plus de 70 caractères, nous les coupons en utilisant wordwrap()
$message = $i." joueur(s) inséré(s) ".$a ."joueur(s) modifié(s)";
$message = wordwrap($message, 70, "\r\n");

// Envoi du mail si autorisation
if($Ping_mapi_pref_email_notification == 'Oui')
{
	if($Ping_mapi_pref_email_succes == 'Oui')
	{
			if($i >0 || $a >0)//seulement s'il y a des résultats
			{
				mail($Ping_mapi_pref_email_admin_ping, '[Cron] joueurs 1', $message);
			}
	}
	else
	{
		mail($Ping_mapi_pref_email_admin_ping, '[Cron] joueurs 1', $message);
	}
}
	



	

#
# EOF
#
?>