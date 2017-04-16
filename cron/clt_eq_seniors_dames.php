<?php
$path = dirname(dirname(__FILE__));
$absolute_path = str_replace('modules','',$path);
define('ROOT',dirname($absolute_path));
require_once(ROOT.'/config.php');

$link = mysqli_connect($config['db_hostname'],$config['db_username'],$config['db_password'],$config['db_name']) or die("Error " . mysqli_error($link));
/* check connection */
if (mysqli_connect_errno()) {
    $message = "Connection impossible";
    
}

$tab= array("Ping_mapi_pref_club_number", "Ping_mapi_pref_idAppli", "Ping_mapi_pref_serie","Ping_mapi_pref_motdepasse","Ping_mapi_pref_saison_en_cours", "Ping_mapi_pref_phase_en_cours","Ping_mapi_pref_email_admin_ping");
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

$error = 0;
$designation = '';
$full = 0;//variable pour récupérer l'ensemble des résultats ou une seule, par défaut 0 cad toutes
$record_id = '';
$lignes = 0;

//on fait une requete générale et on affine éventuellement
$query = "SELECT iddiv, idpoule, id as id_equipe FROM ".$config['db_prefix']."module_ping_equipes WHERE saison LIKE '".$Ping_mapi_pref_saison_en_cours."' AND phase = '".$Ping_mapi_pref_phase_en_cours."' AND idepreuve = '2012'";

$result = $link->query($query); 
$row_cnt = mysqli_num_rows($result);
//bon tt va bien, tt est Ok
//on fait la boucle
//echo $row_cnt;
if($row_cnt >0)
{
	while( $row = mysqli_fetch_assoc($result))
	{
		$iddiv = $row['iddiv'];
		$idpoule = $row['idpoule'];
		$id_equipe = $row['id_equipe'];	
		echo "id_equipe :".$id_equipe."<br />";
		$tm = substr(date('YmdHisu'),0,17);//le timestamp
		$tmc = hash_hmac("sha1",$tm,$Ping_mapi_pref_motdepasse);	
		
		$page = 'xml_result_equ';
		$var = "action=classement&auto=1&D1=".$iddiv."&cx_poule=".$idpoule;
		$chaine = 'http://www.fftt.com/mobile/pxml/'.$page.'.php?serie='.$Ping_mapi_pref_serie.'&tm='.$tm.'&tmc='.$tmc.'&id='.$Ping_mapi_pref_idAppli.'&'.$var; 
		echo "<a target=\"_blank\" href=\"".$chaine."\">".$chaine."</a><br/>";
		$lien =  file_get_contents($chaine);
		//var_dump($lien);
		$xml = simplexml_load_string($lien, 'SimpleXMLElement', LIBXML_NOCDATA);
		//var_dump($xml);
		$i=0;
		//on initialise un deuxième compteur
		if($xml === FALSE)
		{
			$array = 0;//$ping->SetMessage("Le service est coupé");
			//$ping->RedirectToAdminTab('equipes');
		}
		else
		{
			$array = json_decode(json_encode((array)$xml), TRUE);
			$lignes = count($array['classement']);
		}
		//var_dump($xml);//$result = $service->getPouleClassement($iddiv, $idpoule);
		//var_dump($result);

		//on vérifie que le resultat est bien un array

		//tt va bien, on continue
		//on supprime tt ce qui était ds la bdd pour cette poule
		if(!is_array($array))
		{
			$status = "Ko";
			$designation= "le service est coupé pour l'équipe ".$record_id;
			
		
		}
		else
		{
			
	
			$query2 = "DELETE FROM ".$config['db_prefix']."module_ping_classement WHERE iddiv = '".$iddiv."' AND idpoule= '".$idpoule."'  AND saison = '".$Ping_mapi_pref_saison_en_cours."' AND idequipe = '".$id_equipe."'";
			//echo $query2;
			$result2 = $link->query($query2); 
			$row_cnt = mysqli_num_rows($result2);
			
			
			$i=0;//on initialise un compteur 
			//on récupère le résultat et on fait le foreach
			$i = 0;//un compteur pour le nb de résultats enregistrés
			foreach($xml as $cle =>$tab)
			{
				$poule = (isset($tab->poule)?"$tab->poule":"");
				$clt = (isset($tab->clt)?"$tab->clt":"");
				$equipe = (isset($tab->equipe)?"$tab->equipe":"");
				$joue = (isset($tab->joue)?"$tab->joue":"");
				$pts = (isset($tab->pts)?"$tab->pts":"");

				$query3 = "INSERT INTO ".$config['db_prefix']."module_ping_classement (id,idequipe, saison, iddiv, idpoule, poule, clt, equipe, joue, pts) VALUES ('', '".$record_id."','".$saison."', '".$iddiv."', '".$idpoule."','".$poule."', '".$clt."', '".$equipe."', '".$joue."','".$pts."')";
				//echo $query2;
				$dbresultat = $link->query($query3); 
				if(!$dbresultat)
				{
					$message.= mysqli_error($link);
				}
				
				
			}
			
		
			
			
		}
		sleep(1);
		
			
		
		
	}
	
}
else
{
	echo "Pas de résultats ou requete incorrecte";
}




#
#EOF
#
?>