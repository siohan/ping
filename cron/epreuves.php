<?php
#################################################################
#                      Script CRON                             ##
#      Première étape de récupération des compétitions         ##
#################################################################


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
$tab= array("Ping_mapi_pref_club_number", "Ping_mapi_pref_idAppli", "Ping_mapi_pref_serie","Ping_mapi_pref_motdepasse","Ping_mapi_pref_saison_en_cours", "Ping_mapi_pref_phase_en_cours","Ping_mapi_pref_ligue", "Ping_mapi_pref_zone","Ping_mapi_pref_dep");
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
//$tab['fede'] = '100001';
//les paramètres obligatoires

$fede = '100001';
$tableau = array($fede,$Ping_mapi_pref_ligue, $Ping_mapi_pref_zone, $Ping_mapi_pref_dep);//fédé, zone, ligue et département
$tableau_type_epreuves = array('E','I');//par equipes ou individuelles
foreach($tableau as $valeur)
{
	echo "l'organisateur est : ".$valeur."<br />";
	foreach($tableau_type_epreuves as $valeur2)
	{
		echo "la valeur est :".$valeur2."<br />";
		$page = "xml_epreuve";
		//echo $page;
		$var = "organisme=".$valeur."&type=".$valeur2;
		//echo $var;
		$tm = substr(date('YmdHisu'),0,17);//le timestamp
		$tmc = hash_hmac("sha1",$tm,$Ping_mapi_pref_motdepasse);
		$chaine = 'http://www.fftt.com/mobile/pxml/'.$page.'.php?serie='.$Ping_mapi_pref_serie.'&tm='.$tm.'&tmc='.$tmc.'&id='.$Ping_mapi_pref_idAppli.'&'.$var; 
		echo "<a target=\"_blank\" href=\"".$chaine."\">".$chaine."</a><br/>";
		$lien =  file_get_contents($chaine);
		//echo "le lien est : ".$lien;
		$xml = simplexml_load_string($lien, 'SimpleXMLElement', LIBXML_NOCDATA);

		if($xml === FALSE)
		{
			// Le service est coupé
			$array = 0;
		}
		else
		{
			$array = json_decode(json_encode((array)$xml), TRUE);
			$lignes = count($array['epreuve']);
		}

		var_dump($xml);
		/**/
		//on va tester si la variable est bien un tableau   
			if(!is_array($array) || $lignes == 0)  {

				$Message = "Le service est coupé ou il n'y a pas encore de résultats";
				//$ping->RedirectToAdminTab('epreuves');
			}

		///on initialise un compteur général $i
		$i=0;
		//on initialise un deuxième compteur
		$compteur=0;
		foreach($xml as $cle =>$tab)
		{

			$i++;
			$idepreuve = (isset($tab->idepreuve)?"$tab->idepreuve":"");
			$idorga  = (isset($tab->idorga)?"$tab->idorga":"");
			$libelle = (isset($tab->libelle)?"$tab->libelle":"");
			// 1- on vérifie si cette épreuve est déjà dans la base
			$query = "SELECT idepreuve FROM ".$config['db_prefix']."module_ping_type_competitions WHERE idepreuve = '".$idepreuve."'";
			echo $query;
			$dbresult = $link->query($query);
			$row_cnt = mysqli_num_rows($dbresult);
			echo "<br />le nb de résultats est : ".$row_cnt;

				if($dbresult  && $row_cnt == 0) 
				{
					$query1 = "SHOW TABLE STATUS LIKE '".$config['db_prefix']."module_ping_equipes' ";
					$dbresult1 = $link->query($query1);
					while ($row = mysqli_fetch_assoc($dbresult1)) 
					{
						$record_id = $row['Auto_increment'];
					}
					
					//$tag = ping_admin_ops::tag($record_id, $idepreuve, $indivs);
					$tag = "{Ping action=\'";

					if($valeur2 =='I')
					{
						$tag.="individuelles\'";
					}
					else
					{
						$tag.="par-equipes\'";
					}
					$tag.=" idepreuve=\'$idepreuve\'";
					$tag.="}";
					
					$query2 = "INSERT INTO ".$config['db_prefix']."module_ping_type_competitions (id, name, indivs, idepreuve,tag, idorga) VALUES ('', '".$libelle."','".$indivs."','".$idepreuve."','".$tag."','".$idorga."')";
					echo $query2;
					$compteur++;
					$dbresultat = $link->query($query2);

					if(!$dbresultat)
					{
						$designation .= mysqli_error($link);
						echo $designation;			
					}

				}
				elseif($row_cnt >0)
				{
					echo "<br />Déjà en bdd<br />";
				}
				else
				{
					echo "la requete de sélection de la compétition ne fonctionne pas <br/>";
					echo $link->ErrorMsg();
				}
				//fin du if $dbresult


		}// fin du foreach
		unset($tm);
		unset($tmc);
		sleep(1);
	}//fin du deuxième foreach
	
	//unset($valeur);
	
	
	
}//fin du foreach premier
//on envoie un mail qui donne les infos
// Dans le cas où nos lignes comportent plus de 70 caractères, nous les coupons en utilisant wordwrap()
$message = $compteur." épreuve(s) insérée(s)";
$message = wordwrap($message, 70, "\r\n");
//on envoie les mails en cas de succès uniquement ? Une nouvelle préférence ?
if ($compteur >0)
{
	//on vérifie que l'adresse mail est bien renseignée
	// Envoi du mail
	mail($Ping_mapi_pref_email_admin_ping, '[Cron] épreuves', $message);
}



#
# EOF
#

?>