<?php
#############################################################################
###          RÉCUPERATION DE TOUTES LES SITUATIONS MENSUELLES             ###
#############################################################################
if( !isset($gCms) ) exit;
//on vérifie les permissions
if (!$this->CheckPermission('Ping Use'))
{
	echo $this->ShowErrors($this->Lang('needpermission'));
	return;
}
//debug_display($params, 'Parameters');
//require_once(dirname(__FILE__).'/function.calculs.php');
$db=$gCms->GetDb();
//$db =& $this->GetDb();
$mois_courant = date('n');
//pour test, je change manuellement le mois courant
//$mois_courant = 2;
$annee_courante = date('Y');
$saison = $this->GetPreference('saison_en_cours');
$mois_francais = array('Janvier', 'Février','Mars', 'Avril', 'Mai', 'Juin', 'Juillet','Août', 'Septembre', 'Octobre','Novembre','Décembre');
$now = trim($db->DBTimeStamp(time()), "'");
$mois_reel = $mois_courant - 1;
$mois_sm = $mois_francais["$mois_reel"];
$mois_sit_mens = $mois_sm." ".$annee_courante;

$message = '';
//je sélectionne toutes les licences du mois en question donc déjà renseignées
// afin de ne récupérer que celles manquantes
$query = "SELECT licence FROM ".cms_db_prefix()."module_ping_sit_mens WHERE mois = ? AND annee = ?";
//je les mets ensuite dans un tableau pour faire le NOT IN	

$dbresult = $db->Execute($query, array($mois_courant, $annee_courante));
$row = $dbresult->GetRows();
$lic = array();
//$lic = $row[0]['licence'];
//echo "La valeur est : ".$lic;
$lignes = $dbresult->RecordCount();
for($i=0;$i<=$lignes;$i++)
{
	array_push($lic,$row[$i]['licence']);
	//var_dump( $lic);
	$licen = substr(implode(", ", $lic), 3, -3);
	
}
var_dump($licen);
if($lignes ==0)
{
	$query2 = "SELECT licence FROM ".cms_db_prefix()."module_ping_joueurs WHERE actif=1";
}
else
{
	$query2 = "SELECT licence FROM ".cms_db_prefix()."module_ping_joueurs WHERE actif=1 AND licence NOT IN ($licen)";
}
//echo $query2;
$dbresult = $db->Execute($query2);

if ($dbresult && $dbresult->RecordCount() > 0)
  {
	$service = new retrieve_ops();
 	//on instancie un compteur 
	

    	while ($dbresult && $row = $dbresult->FetchRow())
      	{
		$licence2 = $row['licence'];
			
		$result = $service->retrieve_sit_mens("$licence2");
		
        }//fin du while

	$this->SetMessage('Consultez le journal');
	$this->RedirectToAdminTab('situation');

  }
  

#
# EOF
#
?>