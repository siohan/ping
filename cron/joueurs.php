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

	$tm = substr(date('YmdHisu'),0,17);//le timestamp
	$tmc = hash_hmac("sha1",$tm,$Ping_mapi_pref_motdepasse);
	$page = "xml_liste_joueur";
	
	//paramètres nécessaires 
	$var = "club=".$Ping_mapi_pref_club_number;
	$chaine = 'http://www.fftt.com/mobile/pxml/'.$page.'.php?serie='.$Ping_mapi_pref_serie.'&tm='.$tm.'&tmc='.$tmc.'&id='.$Ping_mapi_pref_idAppli.'&'.$var; 
	//echo "<a target=\"_blank\" href=\"".$chaine."\">".$chaine."</a><br/>";
	$lien =  file_get_contents($chaine);
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
		$query = "UPDATE ".$config['db_prefix']."module_ping_joueurs SET actif = '".$actif."' WHERE licence = '".$licence."'";
		$dbresult = $link->query($query);//, array($actif, $licence));
				
	}// fin du foreach
	//on redirige sur l'onglet joueurs
	$message = $a." mises à jour";
	//on envoie un mail qui donne les infos
	// Dans le cas où nos lignes comportent plus de 70 caractères, nous les coupons en utilisant wordwrap()
	
	$message = wordwrap($message, 70, "\r\n");

	// Envoi du mail si autorisation
	if($Ping_mapi_pref_email_notification == 'Oui')
	{
		if($Ping_mapi_pref_email_succes == 'Oui')
		{
				if( $a >0)//seulement s'il y a des résultats
				{
					mail($Ping_mapi_pref_email_admin_ping, '[Cron] joueurs 2', $message);
				}
		}
		else
		{
			mail($Ping_mapi_pref_email_admin_ping, '[Cron] joueurs 2', $message);
		}
	}



	

#
# EOF
#
?>