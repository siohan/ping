<?php
if( !isset($gCms) ) exit;
debug_display($params, 'Parameters');
require_once(dirname(__FILE__).'/include/prefs.php');


$db =& $this->GetDb();
global $themeObject;

$result= array ();
//$query= "SELECT * FROM ".cms_db_prefix()."module_ping_points WHERE joueur = ? ORDER BY id ASC";
//$query = "SELECT CONCAT_WS(' ' , j.nom, j.prenom) AS joueur, j.licence,sum(p.vd) AS victoires, sum(p.pointres) AS total, count(*) AS sur FROM ".cms_db_prefix()."module_ping_parties_spid as p, ".cms_db_prefix()."module_ping_joueurs AS j WHERE p.licence = j.licence AND p.saison = ? GROUP BY joueur ORDER BY joueur";
$query = "SELECT CONCAT_WS(' ' , j.nom, j.prenom) AS joueur, j.licence, p.date_event, p.epreuve, p.nom, p.numjourn, p.classement, p.victoire, p.ecart, p.pointres FROM ".cms_db_prefix()."module_ping_parties_spid as p, ".cms_db_prefix()."module_ping_joueurs AS j WHERE p.licence = j.licence AND p.saison = ? ";
$parms['saison'] = $saison_courante;
//echo $query;
//y a t-il des options ?
	
	
	if(isset($params['type_compet']) && $params['type_compet'] !='')
	{
		$type_compet = $params['type_compet'];
		//on regarde si un N° de journée est en paramètre également
		
			if(isset($params['tour']) && $params['tour'] !='')
			{
				$numjourn = $params['tour'];
				$query2 = "SELECT cal.numjourn,comp.name FROM ".cms_db_prefix()."module_ping_calendrier AS cal, ".cms_db_prefix()."module_ping_type_competitions AS comp WHERE cal.type_compet = comp.code_compet AND cal.type_compet = ? AND cal.numjourn = ?";
				$dbresultat2 = $db->Execute($query2, array($type_compet, $numjourn));
				
					if($dbresultat2)
					{
						$row2 = $dbresultat2->FetchRow();
						$name = $row2['name'];						
						$query.=" AND p.epreuve = ? AND p.numjourn = ?";
						$parms['epreuve'] = $name;
						$parms['numjourn'] = $numjourn;
						
						
					}
					else {
						
						$message = $db->ErrorMsg();
						echo "Pb Query".$message;
					}
				

				
			}
			else
			{
				//le N° de journée n'est pas configuré merde !
				$query3 = "SELECT comp.name FROM ".cms_db_prefix."module_ping_calendrier AS cal, ".cms_db_prefix()."module_ping_type_competitions AS comp WHERE cal.type_compet = comp.code_compet AND cal.type_compet = ? ";
				$dbresultat3 = $db->Execute($query3, array($type_compet, $numjourn));
				
					if($dbresultat3)
					{
						$row3 = $dbresultat3->FetchRow();
						$name = $row3['name'];
						$parms['epreuve'] = $name;
					}
				
				$query.=" AND p.epreuve = ? ";
				
			}
		
		//on récupère un tableau de journées possible
	}
	
	
$query.=" ORDER BY p.date_event, joueur";


$dbresult= $db->Execute($query, $parms);
$rowclass= 'row1';
$rowarray= array ();
if ($dbresult && $dbresult->RecordCount() > 0)
  {
    while ($row= $dbresult->FetchRow())
      {
	$onerow= new StdClass();
	$onerow->rowclass= $rowclass;
	$onerow->epreuve= $row['epreuve'];
	$onerow->joueur= $this->CreateLink($id, 'bar-charts2', $returnid, $row['joueur'],array('licence'=>$row['licence'])) ;
	$onerow->date_event= $row['date_event'];
	$onerow->numjourn= $row['numjourn'];
	$onerow->nom= $row['nom'];
	$onerow->classement= $row['classement'];
	$onerow->ecart= $row['ecart'];
	$onerow->victoire= $row['victoire'];
	$onerow->pointres= $row['pointres'];	
	($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
	$rowarray[]= $onerow;//disabled by Claude
	
      }
  }

/**/
$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
$smarty->assign('itemcount', count($rowarray));
$smarty->assign('items', $rowarray);				
//faire apparaitre les points totaux et somme victoire en bas ? Ce serait pas mal
/**/
echo $this->ProcessTemplate('individuelles.tpl');


#
# EOF
#
?>