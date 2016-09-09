<?php
#################################################################
#                     Tâche CRON                               ##
#    Première étape de récupération des divisions              ##
#################################################################

$path = dirname(dirname(__FILE__));
$absolute_path = str_replace('modules','',$path);
define('ROOT',dirname($absolute_path));
require_once(ROOT.'/config.php');
$message = '';
$link = mysqli_connect($config['db_hostname'],$config['db_username'],$config['db_password'],$config['db_name']) or die("Error " . mysqli_error($link));
/* check connection */
if (mysqli_connect_errno()) {
    $message.= "Connection impossible";
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


$error = 0;//on instancie une variable d'erreur
//on vérifie que tous les paramètres nécessaires sont renseignés (idorga et type et idepreuve)
/**/

	//on fait donc une requete générale pour retrouver toutes les divisions possibles des compets déjà enregistrées
	$query = "SELECT name,idepreuve,idorga FROM ".$config['db_prefix']."module_ping_type_competitions WHERE indivs = '1'";
	echo $query;
	$dbresult = $link->query($query);
	$row_cnt = mysqli_num_rows($dbresult);
	echo "le nb de résultats est : ".$row_cnt;
	//on récupère le tableau des fédé, zone, ligue et comité
	$fede = 100001;
	
	$tableau = array($fede, $Ping_mapi_pref_zone, $Ping_mapi_pref_ligue, $Ping_mapi_pref_dep);
	//var_dump($tableau);
	
	if($dbresult && $row_cnt>0)
	{
		//Ok on a des résultats, on continue
		//on instancie la classe
		//$service = new retrieve_ops();
		while($row = mysqli_fetch_assoc($dbresult))
		{
			$name = $row['name'];
			$idepreuve = $row['idepreuve'];
			//$idorga = $row['idorga'];
			foreach($tableau as $valeur)
			{
			
				$type = 'I';
				$page="xml_division";
				//on instancie la classe service
				//$service = new Servicen();


					$var = "organisme=".$valeur."&epreuve=".$idepreuve."&type=".$type;
						//echo $valeur;
						if($valeur == $fede) {$scope = 'F';}
						if($valeur == $Ping_mapi_pref_zone) {$scope = 'Z';}
						if($valeur == $Ping_mapi_pref_ligue) {$scope = 'L';}
						if($valeur == $Ping_mapi_pref_dep) {$scope = 'D';}
						//
						$tm = substr(date('YmdHisu'),0,17);//le timestamp
						$tmc = hash_hmac("sha1",$tm,$Ping_mapi_pref_motdepasse);
						$chaine = 'http://www.fftt.com/mobile/pxml/'.$page.'.php?serie='.$Ping_mapi_pref_serie.'&tm='.$tm.'&tmc='.$tmc.'&id='.$Ping_mapi_pref_idAppli.'&'.$var; 
						echo "<a target=\"_blank\" href=\"".$chaine."\">".$chaine."</a><br/>";
						$lien =  file_get_contents($chaine);
						$xml = simplexml_load_string($lien, 'SimpleXMLElement', LIBXML_NOCDATA);
						//var_dump($xml);
						if($xml === FALSE )
						{
							//le service est coupé
							$array = 0;
							$lignes = 0;
							$message.=" Pas de résultats pour l\'épreuve ".$name;
							echo $message;
						}
						else
						{
							$array = json_decode(json_encode((array)$xml), TRUE);

							if(isset($array['division']))
							{
								$lignes = count($array['division']);


								//echo "le nb de lignes est : ".$lignes;
								$i=0;
								//on initialise un deuxième compteur
								$compteur=0;

								foreach($xml as $value)
								{

									$i++;
									$iddivision = htmlentities($value->iddivision);
									$libelle = mysqli_real_escape_string($link,htmlentities($value->libelle));

									// 1- on vérifie si cette épreuve est déjà dans la base
									$query2 = "SELECT iddivision FROM ".$config['db_prefix']."module_ping_divisions WHERE iddivision = '".$iddivision."' AND idorga = '".$valeur."' AND idepreuve = '".$idepreuve."'";
									echo "<br />".$query2."<br />";
									$dbresult2 = $link->query($query2);
									$row_cnt2 = mysqli_num_rows($dbresult2);
									echo "Le nb de résultats de la deuxième requete est : ".$row_cnt2;

										if($dbresult  && $row_cnt2 == 0) 
										{
											$query = "INSERT INTO ".$config['db_prefix']."module_ping_divisions (id, idorga, idepreuve,iddivision,libelle,saison,indivs,scope) VALUES ('', '".$valeur."','".$idepreuve."','".$iddivision."','".$libelle."','".$Ping_mapi_pref_saison_en_cours."','".$indivs."','".$scope."')";
											echo "<br />".$query;
											$compteur++;
											$dbresultat = $link->query($query);

											if(!$dbresultat)
											{
												$message_error = mysqli_error($link);
												echo $message_error;			
											}

										}
										elseif(!$dbresult)
										{
											//une erreur ds la requete
											$message_error = mysqli_error($link);
											echo $message_error;
										}


								}// fin du foreach

							}
						unset($scope);
						}
					//}//fin du premier foreach
			}
			sleep(1);	
		}
		
	}
	elseif(!$dbresult)
	{
		//Erreur en bdd, on fait quoi ?
		$message.= mysqli_error($link);
		echo $message;
	}
	else
	{
		//pas de résultats
	}
/**/
#
# EOF
#
 
?>