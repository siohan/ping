<?php
################################################################
##                       Script Cron                          ##
##                 Récupération des tours                     ##
################################################################

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
//on récupère tous les tours possibles
$query = "SELECT * FROM ".$config['db_prefix']."module_ping_divisions WHERE saison = '".$Ping_mapi_pref_saison_en_cours."' AND uploaded IS NULL";
echo $query;
$dbresult = $link->query($query);
$row_cnt = mysqli_num_rows($dbresult);
echo "Le nb de résultats est : ".$row_cnt;
if($dbresult && $row_cnt >0)
{
	while($row = mysqli_fetch_assoc($dbresult))
	{
		$idepreuve = $row['idepreuve'];
		$iddivision = $row['iddivision'];
		
		
		$page = "xml_result_indiv";
		$var ="epr=".$idepreuve."&res_division=".$iddivision;

	
			//on doit récupérer le lien du groupe depuis la FFTT


			$var.="&action=poule";

			$tm = substr(date('YmdHisu'),0,17);//le timestamp
			$tmc = hash_hmac("sha1",$tm,$Ping_mapi_pref_motdepasse);
			$chaine = 'http://www.fftt.com/mobile/pxml/'.$page.'.php?serie='.$Ping_mapi_pref_serie.'&tm='.$tm.'&tmc='.$tmc.'&id='.$Ping_mapi_pref_idAppli.'&'.$var; 
			echo "<a target=\"_blank\" href=\"".$chaine."\">".$chaine."</a><br/>";
			$lien =  file_get_contents($chaine);
			$xml = simplexml_load_string($lien, 'SimpleXMLElement', LIBXML_NOCDATA);
			var_dump($xml);
			if($xml === FALSE)
			{
				//le service est coupé
				$array = 0;
				$lignes = 0;
			}
			else
			{
				$array = json_decode(json_encode((array)$xml), TRUE);
				$lignes = count($array['tour']);
			}
			//echo "le nb de lignes est : ".$lignes;
			foreach($xml as $value)
			{
				//$libelle = $tab['libelle'];
				//$lien = $tab['lien'];
				$i = 0; //on insère un compteur
				$libelle = htmlentities($value->libelle);
				//on va extraire le tour
				$tour1 = explode(" ",$libelle);
				$tour2 = trim($tour1[0],'T');

				$lien = htmlentities($value->lien);
				$tab1 = explode("&",$value->lien);

				$tableau = trim($tab1[2], 'cx_tableau=');

				if($tableau != '')
				{

					//On a récupéré les éléments, on peut faire l'insertion dans notre bdd
					//on va d'abord vérifier si ces éléments sont présents ou on créé un index sur la table
					$query = "INSERT INTO ".$config['db_prefix']."module_ping_div_tours (id, idepreuve,iddivision,libelle, tour, tableau, lien,saison) VALUES ('','".$idepreuve."','".$iddivision."','".$libelle."','".$tour2."', '".$tableau."','".$lien."','".$Ping_mapi_pref_saison_en_cours."')";
					echo $query;
					$dbresult = $link->query($query);
					$i++;
					//et si on continuait ?
					//reprendre les infos ci dessus pour les traiter !
					//on pourrait préparer les différents tags : poule, classement, partie.
					//on met à jour la table divisions pour dire qu'on a bien uploadé
					$uploaded = 1;
					$query2 = "UPDATE ".$config['db_prefix']."module_ping_divisions SET uploaded = 1 WHERE iddivision = '".$iddivision."' ";
					echo $query2;
					$dbresult2 = $link->query($query2);

				}




			}
			
			$message.= $i." tour(s) inséré(s) pour l\'épreuve ".$idepreuve;
			
			
		
	}
}
elseif(!$dbresult)
{
	//pas de résultats ou erreur de la requete ?
	$message.= mysqli_error($link);
	echo "erreur MySQL : ".$message;
}
else
{
	echo "La vérité est ailleurs";
	$message.="Pas encore de résultats disponibles";
}
//on envoie un mail qui donne les infos
// Dans le cas où nos lignes comportent plus de 70 caractères, nous les coupons en utilisant wordwrap()

$envoi_message = wordwrap($message, 70, "\r\n");
echo $envoi_message;
// Envoi du mail
mail('claude.siohan@gmail.com', '[Cron] tours', $envoi_message);

#
# EOF
#
//echo $this->ProcessTemplate('details_rencontre.tpl');
?>