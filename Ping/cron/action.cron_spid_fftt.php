<?php
#############################################################
###          Vérification entre Spid et FFTT              ###
#############################################################
if(!isset($gCms)) exit;
$db =& $this->GetDb();
global $themeObject;

require_once(dirname(__FILE__).'/include/prefs.php');
$designation = '';
//$query = "SEL";
//$query = "SELECT sp.id,p.date_event,sp.licence as licence_spid, p.licence as licence_fftt,sp.nom as nom_spid, p.advnompre AS nom_fftt, sp.numjourn AS numjourn_spid, p.numjourn AS numjourn_fftt, sp.victoire AS victoire_spid, p.vd AS victoire_fftt, sp.coeff AS coeff_spid, p.coefchamp AS coeff_fftt, sp.pointres AS points_spid, p.pointres AS points_fftt FROM ".cms_db_prefix()."module_ping_parties_spid AS sp, ".cms_db_prefix()."module_ping_parties AS p WHERE sp.licence = p.licence AND sp.nom = p.advnompre AND sp.date_event = p.date_event AND sp.saison = ? AND (sp.pointres !=p.pointres) ORDER BY sp.id DESC";
$query = "SELECT sp.id AS record_id,p.date_event,sp.licence as licence_spid, p.licence as licence_fftt,sp.nom as nom_spid, p.advnompre AS nom_fftt, sp.numjourn AS numjourn_spid, p.numjourn AS numjourn_fftt, sp.victoire AS victoire_spid, p.vd AS victoire_fftt, sp.coeff AS coeff_spid, p.coefchamp AS coeff_fftt, sp.pointres AS points_spid, p.pointres AS points_fftt FROM ".cms_db_prefix()."module_ping_parties_spid AS sp, ".cms_db_prefix()."module_ping_parties AS p WHERE sp.licence = p.licence AND sp.nom = p.advnompre AND sp.date_event = p.date_event AND sp.saison = ? AND ((sp.pointres !=p.pointres) OR (sp.numjourn !=p.numjourn) OR (sp.coeff != p.coefchamp)) ORDER BY sp.id ASC";
$dbresult = $db->Execute($query, array($saison_courante));
//$row = $dbresult->FetchRow();
$lic = array();
//$lic = $row[0]['licence'];
//echo "La valeur est : ".$lic;
$lignes = $dbresult->RecordCount();
for($i=0;$i<=$lignes;$i++)
{
	//array_push($lic,$row[$i]['id'], $row[$i]['numjourn_fftt']);
	//array_push($lic[$i],array($row['id'], $row['numjourn_fftt']));
	//$licen = substr(implode(", ", $lic), 0, -3);
}

//var_dump($dbresult);

/**/

$rowarray = array();
$i = 0;
	if($dbresult && $dbresult->RecordCount()>0)
	{
		while($row = $dbresult->FetchRow())
		{
			//pb si doublons ou triplons  !!!
			//faut donc vérifier d'abord dans la table fftt, ben oui !
			//on prend donc les éléments pour vérifier
			//on instancie une variable pour dire si c'est ok ou ko 
			$doublons = 0;
			$licence_joueur = $row['licence_spid'];
			$date_event  = $row['date_event'];
			
			
			$query3 = "SELECT count() FROM ".cms_db_prefix()."module_ping_parties WHERE licence = ? AND date_event = ? AND a = ?";
			
			
			$record_id = $row['record_id'];
			$numjourn_fftt = $row['numjourn_fftt'];
			//echo "le n° FFTT est : ".$numjourn_fftt." pour le N° ".$record_id."<br />";
			$coefchamp = $row['coeff_fftt'];
			$pointres = $row['points_fftt'];
			$vd = $row['victoire_fftt'];
			if($pointres !='')
			{
				
			
				$query2 = "UPDATE ".cms_db_prefix()."module_ping_parties_spid SET numjourn = ?, coeff = ?, pointres = ?, victoire = ? WHERE id = ?";
				//echo $query2;
				$dbresultat = $db->Execute($query2, array($numjourn_fftt, $coefchamp,$pointres,$vd, $record_id));
				$i++;
					if(!$dbresultat)
					{
						$designation.= $db->ErrorMsg();

					}
			}
		}
		
		$designation.="Rectification de ".$i." partie(s)";
		
		
	}
	else
	{
		$designation.="Pas de résultats à modifier";
	}
	//echo $designation;

$this->SetMessage("$designation");
$this->RedirectToAdminTab('spid');
	

#EOF
#
?>