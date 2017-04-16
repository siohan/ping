<?php
#############################################################################
###                             Script CRON                               ###
###      Récupération des situations mensuelles                           ###
#############################################################################


$path = dirname(dirname(__FILE__));
$absolute_path = str_replace('modules','',$path);
define('ROOT',dirname($absolute_path));
require_once(ROOT.'/config.php');
$message = '';
$link = mysqli_connect($config['db_hostname'],$config['db_username'],$config['db_password'],$config['db_name']) or die("Error " . mysqli_error($link));
/* check connection */
if (mysqli_connect_errno()) {
    $message = "Connection impossible";
echo $message;
    
}

//$now = trim($link->DBTimeStamp(time()), "'");

//on fait un tableau qui récapitule toutes les possibilités (F, Z etc...)
//on récupère les préférences...
$tab= array("Ping_mapi_pref_club_number", "Ping_mapi_pref_idAppli", "Ping_mapi_pref_serie","Ping_mapi_pref_motdepasse","Ping_mapi_pref_saison_en_cours", "Ping_mapi_pref_phase_en_cours","Ping_mapi_pref_ligue", "Ping_mapi_pref_zone","Ping_mapi_pref_dep","Ping_mapi_pref_nom_equipes","Ping_mapi_pref_jour_sit_mens");
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
//echo $Ping_mapi_pref_jour_sit_mens;
$jour = date('d');
if( $jour < $Ping_mapi_pref_jour_sit_mens)
{
	$message.= "L'accès n'est pas encore libre ou changez le paramètre dans l'onglet Configuration";
	echo $message;
	exit;
}	

$designation= '';
$mois_courant = date('n');
//pour test, je change manuellement le mois courant
//$mois_courant = 2;
$annee_courante = date('Y');
//$saison = $this->GetPreference('saison_en_cours');
$mois_francais = array('Janvier', 'Février','Mars', 'Avril', 'Mai', 'Juin', 'Juillet','Août', 'Septembre', 'Octobre','Novembre','Décembre');
//$now = trim($db->DBTimeStamp(time()), "'");
$mois_reel = $mois_courant - 1;
$mois_sm = $mois_francais["$mois_reel"];
$mois_sit_mens = $mois_sm." ".$annee_courante;



//je sélectionne toutes les licences du mois en question donc déjà renseignées
// afin de ne récupérer que celles manquantes
$query = "SELECT licence FROM ".$config['db_prefix']."module_ping_sit_mens WHERE mois = '".$mois_courant."' AND annee = '".$annee_courante."' AND licence IS NOT NULL";
//je les mets ensuite dans un tableau pour faire le NOT IN	
//echo $query."<br />";
$dbresult = $link->query($query);
$lignes = mysqli_num_rows($dbresult);
echo "le nb de résultats est : ".$lignes;
if($dbresult && $lignes >0 )
{
	$lic = array();
	while($row = mysqli_fetch_assoc($dbresult))
	{
		array_push($lic,$row['licence']);
		//var_dump( $lic);
		//$licen = substr(implode(", ", $lic), 3, -3);
		$licen = implode(", ", $lic);

		
	}
	
}
//var_dump($licen);
if($lignes ==0)
{

	$query2 = "SELECT licence FROM ".$config['db_prefix']."module_ping_joueurs WHERE actif=1 ";
}
else
{
	$query2 = "SELECT licence FROM ".$config['db_prefix']."module_ping_joueurs WHERE actif=1 AND licence NOT IN ($licen)";
}
//echo $query2;

$dbresult2 = $link->query($query2);
$row_cnt = mysqli_num_rows($dbresult2);

if ($dbresult2 && $row_cnt > 0)
{

	$compt = 0;
    	while ($row = mysqli_fetch_assoc($dbresult2))
      	{
		$compt++;
		$licence2 = $row['licence'];
		//echo "<br />Licence : ".$licence2."<br />";	
		$page = "xml_joueur";
		$var = "licence=".$licence2;
		$tm = substr(date('YmdHisu'),0,17);//le timestamp
		$tmc = hash_hmac("sha1",$tm,$Ping_mapi_pref_motdepasse);
		$chaine = 'http://www.fftt.com/mobile/pxml/'.$page.'.php?serie='.$Ping_mapi_pref_serie.'&tm='.$tm.'&tmc='.$tmc.'&id='.$Ping_mapi_pref_idAppli.'&'.$var; 
		//echo "<a target=\"_blank\" href=\"".$chaine."\">".$chaine."</a><br/>";
		$lien =  file_get_contents($chaine);
		
		$xml = simplexml_load_string($lien,'SimpleXMLElement', LIBXML_NOCDATA);
		//var_dump($xml);
		/**/
		if($xml === FALSE)
		{
			$lignes = 0;
			$array = 0;
			$result = 0;
			echo "pas de résultat pour la licence : ".$licence2."<br />";
			//var_dump($xml);
		}
		else
		{
			$array = json_decode(json_encode((array)$xml), TRUE);
			//var_dump($array);
			$lignes = count($array['joueur']);
		}


			if($lignes == 0)
			{
				//le service est coupé ou la licence est inactive

				$message.="Licence introuvable ou service coupé pour ".$licence2;
			//	echo $message;
			}
			else
			{
				foreach($xml as $result)
				{
					$licence2 = (isset($result->licence)?"$result->licence":"");
					$nom = mysqli_real_escape_string($link,(isset($result->licence)?"$result->nom":""));
					$prenom = mysqli_real_escape_string($link,(isset($result->licence)?"$result->prenom":""));
					$natio = (isset($result->licence)?"$result->natio":"");
					$clglob = (isset($result->licence)?"$result->clglob":"");
					$point = (isset($result->licence)?"$result->point":"");
					$aclglob = (isset($result->licence)?"$result->aclglob":"");
					$apoint = (isset($result->licence)?"$result->apoint":"");
					$clnat = (isset($result->licence)?"$result->clnat":"");
					$categ = (isset($result->licence)?"$result->categ":"");
					$rangreg = (isset($result->licence)?"$result->rangreg":"");
					$rangdep = (isset($result->licence)?"$result->rangdep":"");
					$valcla = (isset($result->licence)?"$result->valcla":"");
					$clpro = (isset($result->licence)?"$result->clpro":"");
					$valinit = (isset($result->licence)?"$result->valinit":"");
					//$progmois = (isset($result->licence)?"$result->progmois":"");
					//$progann = (isset($result->licence)?"$result->progann":"");

					//on peut faire qqs traitements pour calculer les progressions par exemples
					$progmoisplaces = $aclglob - $clglob;//progression en termes de places
					$progmois = $point - $apoint;//progression du mois en termes de points
					$progann = $point - $valinit; //progression à l'année en termes de points





				}
				$query2 = "INSERT INTO ".$config['db_prefix']."module_ping_sit_mens (id,datecreated, datemaj, mois, annee, phase, licence, nom, prenom, categ,points, apoint,clglob, aclglob, clnat, rangreg, rangdep, progmoisplaces, progmois, progann, valinit, valcla,saison) VALUES ('', '".$now."','".$now."','".$mois_courant."', '".$annee_courante."', '".$phase."', '".$licence2."', '".$nom."', '".$prenom."', '".$categ."', '".$point."','".$apoint."','".$clglob."', '".$aclglob."', '".$clnat."', '".$rangreg."', '".$rangdep."', '".$progmoisplaces."', '".$progmois."', '".$progann."','".$valinit."', '".$valcla."', '".$Ping_mapi_pref_saison_en_cours."')";
				//echo "<br />".$query2."<br />";;
				/**/
				$dbresultat = $link->query($query2);


					if(!$dbresultat)
					{
					
						$message.= mysqli_error($link);
						echo $message;

					}
					else
					{
					
						
						$message.= "Situation ok pour ".$nom." ".$prenom;
						echo $message;
						//ping_admin_ops::ecrirejournal($now,$status, $designation,$action);
						//on met la table recup à jour pour le joueur
						//Attention s'il s'agit d'un ajout !!
						//on vérifie d'abord l'existence du joueur ds la bdd
						/*
						$query4 = "SELECT licence FROM ".cms_db_prefix()."module_ping_recup_parties WHERE licence = ?";
						$dbresult4 = $db->Execute($query4, array($licence2));
						if($dbresult4->RecordCount() == 0)
						{
							$query3 = "INSERT INTO ".cms_db_prefix()."module_ping_recup_parties (id, saison, datemaj, licence, sit_mens) VALUES ('', ?, ?, ?, ?)";
							$dbresult3 = $db->Execute($query3, array($saison,$now, $licence2, $mois_sit_mens));

						}
						else
						{
							$query3 = "UPDATE ".cms_db_prefix()."module_ping_recup_parties SET datemaj = ? , sit_mens = ? WHERE licence = ?";
							$dbresult3 = $db->Execute($query3, array($now, $mois_sit_mens, $licence2));
						}
						*/


					}
					unset($message);

					//$message.="<li>La licence est ok</li>";
			/*	*/
			}
		
		if($compt % 2 == 0)
		{
			sleep(1);
		}
/**/	
	//sleep(1);
	
        }//fin du while
//echo "le nb de licences analysées est :".$compt;
	

}
elseif(!$dbresult2)
{
	//la requete ne fonctionne pas, pk ?
	$error_msg = mysqli_error($link);
	echo $error_msg;
}
else
{
	//il n'y a pas encore de résultats
	echo "Pas de résultats disponibles";
}
//on envoie un mail qui donne les infos
// Dans le cas où nos lignes comportent plus de 70 caractères, nous les coupons en utilisant wordwrap()
$message = $compt." situation(s) mensuelle(s) insérée(s)";
$message = wordwrap($message, 70, "\r\n");

// Envoi du mail si autorisation
if($Ping_mapi_pref_email_notification == 'Oui')
{
	if($Ping_mapi_pref_email_succes == 'Oui')
	{
			if($compteur >0)//seulement s'il y a des résultats
			{
				mail($Ping_mapi_pref_email_admin_ping, '[T2T] situation mensuelle', $message);
			}
	}
	else
	{
		mail($Ping_mapi_pref_email_admin_ping, '[T2T] situation mensuelle', $message);
	}
}
# EOF
#
?>