<?php
##########################################################################
##        Cette page récupère les équipes                               ##
##########################################################################

$path = dirname(dirname(__FILE__));
$absolute_path = str_replace('modules','',$path);
define('ROOT',dirname($absolute_path));
require_once(ROOT.'/config.php');

$link = mysqli_connect($config['db_hostname'],$config['db_username'],$config['db_password'],$config['db_name']) or die("Error " . mysqli_error($link));
/* check connection */
if (mysqli_connect_errno()) {
    $message = "Connection impossible";
    
}

/*
echo $config['db_hostname'];
echo $config['db_username'];
echo $config['db_password'];
echo $config['db_name'];
echo $config['db_prefix'];
*/
	


$tab= array("Ping_mapi_pref_club_number", "Ping_mapi_pref_idAppli", "Ping_mapi_pref_serie","Ping_mapi_pref_motdepasse","Ping_mapi_pref_saison_en_cours", "Ping_mapi_pref_phase_en_cours");
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


	$tm = substr(date('YmdHisu'),0,17);//le timestamp
	$tmc = hash_hmac("sha1",$tm,$Ping_mapi_pref_motdepasse);
	$page = "xml_equipe";
	$var1 = "numclu=".$Ping_mapi_pref_club_number;
	$compteur = 0;//on initialise un compteur
	//on fait une boucle pour les autres équipes ?
	$tabarray = array("M", "F", "");
	foreach($tabarray as $value)
	{
		
	if($value == "")
	{
		$var2="";
	}
	else
	{
		$var2="&type=".$value;
	}
	
	
		$chaine = 'http://www.fftt.com/mobile/pxml/'.$page.'.php?serie='.$Ping_mapi_pref_serie.'&tm='.$tm.'&tmc='.$tmc.'&id='.$Ping_mapi_pref_idAppli.'&'.$var1.$var2; 
		//echo "<a target=\"_blank\" href=\"".$chaine."\">".$chaine."</a><br/>";
		$lien =  file_get_contents($chaine);
		//var_dump($lien);
		$xml = simplexml_load_string($lien, 'SimpleXMLElement', LIBXML_NOCDATA);
		//var_dump($xml);
		$i=0;
		//on initialise un deuxième compteur
	
		foreach($xml as $cle =>$tab)
		{

			$i++;
			$libequipe = mysqli_real_escape_string($link, (isset($tab->libequipe)?"$tab->libequipe":""));
			$idepreuve = (isset($tab->idepr)?"$tab->idepr":"");
			$newphase = explode ("-",$libequipe);
			//echo "la phase est ".$newphase[1];
			$phase = substr($newphase[1], -1);
			$new_equipe = htmlentities($newphase[0], ENT_QUOTES,  "UTF-8");
			//echo "la phase est ".$phase;

			$libdivision = htmlentities((isset($tab->libdivision)?"$tab->libdivision":""), ENT_QUOTES,  "UTF-8");
			$liendivision = (isset($tab->liendivision)?"$tab->liendivision":"");
			$tableau = parse_str($liendivision, $output);
			//echo $tableau;
			$idpoule = $output['cx_poule'];
			$iddiv = $output['D1'];
			$idorga = $output['organisme_pere'];




			//$type_compet = $type;


			$query2 = "SELECT phase, libequipe, libdivision FROM ".$config['db_prefix']."module_ping_equipes WHERE libequipe LIKE '".$new_equipe."' AND saison LIKE '".$Ping_mapi_pref_saison_en_cours."' AND phase = $phase AND libdivision LIKE '".$libdivision."'";
			//echo $query2;

			$result2 = $link->query($query2); 
			$row_cnt = mysqli_num_rows($result2);
			//echo "le nb de résultats est : ".$row_cnt;
				if($row_cnt == 0) 
				{
					//On va essayer de créer un tag pour aider à afficher les équipes
					//On récupère le mast_insert_id d'abord
					$query3 = "SHOW TABLE STATUS LIKE '".$config['db_prefix']."module_ping_equipes' ";
					$dbresult = $link->query($query3);
				
						while ($row = mysqli_fetch_assoc($dbresult)) 
						{
							$record_id = $row['Auto_increment'];
						}
					
				
					//$tag = ping_admin_ops::tag_equipe($record_id);
					$tag = "{Ping action=\'equipe\' record_id=\'".$record_id."\' }";
					$query4 = "INSERT INTO ".$config['db_prefix']."module_ping_equipes (id, saison, phase, libequipe, libdivision, liendivision, idpoule, iddiv, type_compet, tag, idepreuve) VALUES ('', '".$Ping_mapi_pref_saison_en_cours."', '".$Ping_mapi_pref_phase_en_cours."', '".$new_equipe."', '".$libdivision."', '".$liendivision."','".$idpoule."', '".$iddiv."', '".$type_compet."', '".$tag."','".$idepreuve."')";
					//echo $query4;
					$compteur++;
					$dbresultat = $link->query($query4);
				//	Execute($query,array($saison, $phase, $new_equipe, $libdivision, $liendivision, $idpoule, $iddiv, $type_compet, $tag, $idepreuve));

			

				}
				elseif(!$result2)
				{
					//zut une erreur ds la requete
					$message.= mysqli_error($link);
				}
				elseif($row_cnt >0)
				{
					//
				}
			
		unset($var);

		}// fin du foreach
	}
//on envoie un mail qui donne les infos
// Dans le cas où nos lignes comportent plus de 70 caractères, nous les coupons en utilisant wordwrap()
$message = $compteur." equipe(s) insérée(s)";
$message = wordwrap($message, 70, "\r\n");

// Envoi du mail
mail('claude.siohan@gmail.com', '[Cron] equipes', $message);


?>
