<?php
#######################################################################################
###                      GESTION DES DOUBLONS                                       ###
### Cette page gère les doublons qui ne peuvent pas être pris en compte ds le spid  ###
###        Même joueur        (licence)                                             ###
###        Même adversaire    (advnompre)                                           ###
###        Même Date          (date_event)                                          ###
###        Même victoire      (victoire : 0 ou 1)                                   ###
### Voir si on ajoutera ensuite le numéro de journée                                ###
#######################################################################################
if(!isset($gCms) ) exit;
require_once(dirname(__FILE__).'/include/prefs.php');
//dans ce script on recherche les doublons de rencontre dans la FFTT pour les inclure dans la base spid
//on recherche donc d'abord les "doublons " de la FFTT
//ex : un jour peut rencontrer deux fois un même joueur dans une epreuve individuelle
$designation ='';
/*
$query = "SELECT DISTINCT licence, date_event, advnompre FROM ".cms_db_prefix()."module_ping_parties as t1 WHERE  EXISTS (
              SELECT *
              FROM ".cms_db_prefix()."module_ping_parties t2
              WHERE t1.id <> t2.id
              AND   t1.licence = t2.licence
              AND   t1.date_event = t2.date_event
              AND   t1.advnompre = t2.advnompre ) AND t1.saison = ?";

*/
$query = "SELECT licence, date_event, advnompre, vd,count(*) FROM ".cms_db_prefix()."module_ping_parties WHERE saison = ? AND numjourn !=0 GROUP BY date_event, licence, advnompre, vd HAVING count(*) > 1";

//$query = "SELECT p.licence, p.date_event, p.advnompre,sp.date_event FROM ".cms_db_prefix()."module_ping_parties AS p LEFT JOIN ".cms_db_prefix()."module_ping_parties_spid AS sp ON p.licence = sp.licence WHERE p.date_event = sp.date_event AND p.advnompre = sp.nom AND p.saison  = ?";
$dbresult = $db->Execute($query,array($saison_courante));
//on sait que chaque enregistrement en doublons doit être dupliqué
//il est même inutile de faire une vérification
$lignes = $dbresult->RecordCount();
echo "le nb de lignes ets :".$lignes;
	if ($dbresult && $dbresult->RecordCount() > 0)
  	{
    		while ($row= $dbresult->FetchRow())
      		{
		//on prend les données nécessaires pour le spid afin de les insérer
			$licence = $row['licence'];
			$date_event = $row['date_event'];
			$advnompre = $row['advnompre'];
			$victoire = $row['vd'];
			
			$query2 = "INSERT INTO ".cms_db_prefix()."module_ping_parties_spid (id) VALUES ('')";
		//	$dbresultat2 = $db->Execute($query2, array());
			
			
	
		}
	
	}
	else
	{
		$designation.="Joueur introuvable";
		$this->SetMessage("$designation");
		$this->RedirectToAdminTab('joueurs');
	}
#
#EOF
#
?>