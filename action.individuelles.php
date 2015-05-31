<?php
if( !isset($gCms) ) exit;
##############################################################################
# auteur : Claude SIOHAN                                                   ###
# Cette page récupère les compétitions individuelles                      ###
##############################################################################
//debug_display($params, 'Parameters');
require_once(dirname(__FILE__).'/include/prefs.php');


$db =& $this->GetDb();
global $themeObject;
$parms = array();
$result= array ();
$mois_en_cours = date('m');
$mois_en_cours2 = $mois_en_cours - 1;
//on établit la liste des compétitions individuelles du calendrier
$query1 = "SELECT *,MONTH(cal.date_debut) AS mois_ref FROM ".cms_db_prefix()."module_ping_calendrier AS cal, ".cms_db_prefix()."module_ping_type_competitions AS tc WHERE cal.type_compet = tc.code_compet";
//il s'agit de compétitions individuelles ?
$query1.=" AND tc.indivs = 1 ";
$parametres = 0;
/*
$jour = date('j');
if($jour < 10)
{
	$query1.= " AND MONTH(cal.date_debut) < " .$mois_en_cours2. "";
}
else
{
	$query1.= " AND MONTH(cal.date_debut) < " .$mois_en_cours. "";
}
*/

if(isset($params['type_compet']) && $params['type_compet'] !='')
{
	$parametres++;
	$type_compet = $params['type_compet'];
	//on regarde si un N° de journée est en paramètre également
	$query1.=" AND tc.code_compet = ?";
	$parms['type_compet'] = $type_compet;
	
		
			
}
if(isset($params['date_debut']) && $params['date_debut'] !='')
{
	$parametres++;
	$date_debut = $params['date_debut'];
	
	$query1.=" AND cal.date_debut = ?";
	$parms['date_debut'] = $date_debut;
}
if(isset($params['date_fin']) && $params['date_fin'] !='')
{
	$parametres++;
	$date_fin = $params['date_fin'];
	
	$query1.=" AND cal.date_fin = ?";
	$parms['date_fin'] = $date_fin;
}


$query1.=" ORDER BY cal.date_debut DESC";
if(count($parametres)>0)
{
	$result1 = $db->Execute($query1,$parms);
}
else
{
	$result1 = $db->Execute($query1);
}
//il faudra ajouter qqch pour différencier les saisons
//il faudra aussi construire dynamiquement les tableau de licences sous forme d'array
/*
$array_I = ping_admin_ops::array_code_compet($type_compet='I');
$array_J = ping_admin_ops::array_code_compet($type_compet='J');
$array_V = ping_admin_ops::array_code_compet($type_compet='V');
echo $array_V;
var_dump($array_V);
*/

	if($result1 && $result1->RecordCount()>0)
	{
		$rowclass= 'row1';
		$rowarray= array ();
		
		while($row1 = $result1->FetchRow())
		{
			//on récupère les résultats
			$date_debut = $row1['date_debut'];
			$date_fin = $row1['date_fin'];
			$numjourn = $row1['numjourn'];
			$name = $row1['name'];
			$code = $row1['code_compet'];
			$mois_ref = $row1['mois_ref'];		
			
			//on instancie ce qui va faire les entêtes
			$onerow= new StdClass();
			$onerow->rowclass= $rowclass;
			$onerow->name = $name;
			$onerow->date_event = $date_debut;
			$onerow->valeur = $i;//très important pour les boucles
			
			$array = ping_admin_ops::array_code_compet($type_compet=$code);
			//echo "le mois de référence est : ".$mois_ref;
			if($mois_ref == $mois_en_cours && $jour <10)
			{
				//on est dans le spid
				$spid =1;
				$query2 = "SELECT CONCAT_WS(' ', j.nom, j.prenom) AS joueur, j.licence, SUM(victoire) AS vic, count(victoire) AS sur, SUM(pointres) AS pts FROM ".cms_db_prefix()."module_ping_parties_spid AS sp, ".cms_db_prefix()."module_ping_joueurs AS j  WHERE sp.licence = j.licence AND sp.date_event BETWEEN ? AND ?";
			//	$tab = 'array'.'_'.$code;
			//	var_dump($$tab);
				$query2.=" AND j.licence IN ( '" . implode($array, "', '") . "' )";
				$query2.=" GROUP BY joueur,j.licence";
				//echo $query2;
			}
			else
			{
				//on est dans la FFTT
				$query2 = "SELECT CONCAT_WS(' ', j.nom, j.prenom) AS joueur, j.licence, SUM(vd) AS vic, count(vd) AS sur, SUM(pointres) AS pts FROM ".cms_db_prefix()."module_ping_parties AS sp, ".cms_db_prefix()."module_ping_joueurs AS j  WHERE sp.licence = j.licence AND sp.date_event BETWEEN ? AND ?";
			//	$tab = 'array'.'_'.$code;
			//	var_dump($$tab);
				$query2.=" AND j.licence IN ( '" . implode($array, "', '") . "' )";
				$query2.=" GROUP BY joueur,j.licence";
				//echo $query2;
			}
			
			$result2 = $db->Execute($query2, array($date_debut, $date_fin));
			
				if($result2 && $result2->RecordCount()>0)
				{
					//$i=0;
					$rowarray2 = array();
					$compteur = 0;
					
					while($row2 = $result2->FetchRow())
					{
						$licence = $row2['licence'];
						$onerow2 = new StdClass();
						$onerow2->joueur = $row2['joueur'];
						$onerow2->vic = $row2['vic'];
						$onerow2->sur = $row2['sur'];
						$onerow2->pts = $row2['pts'];
						
						if($mois_ref == $mois_courant)
						{
							$onerow2->details = $this->CreateLink($id, 'user_results_prov', $returnid, "Détails",array('licence'=>$licence,'date_debut'=>$date_debut, 'date_fin'=>$date_fin)) ;
						}
						else
						{
							$onerow2->details = $this->CreateLink($id, 'user_results', $returnid, "Détails",array('licence'=>$licence,'date_debut'=>$date_debut, 'date_fin'=>$date_fin)) ;
						}
						
						$onerow2->compteur = $compteur;
						/*
						//on commence la troisième requete 
						//on récupère le détail
						$query3 = "SELECT * FROM ".cms_db_prefix()."module_ping_parties_spid WHERE licence = ? AND date_event = ?";
						$dbresult3 = $db->Execute($query3, array($licence,$date_debut));
						
						if($dbresult3 && $dbresult3->RecordCount()>0)
						{
							//un nouveau while et oui !
							while($row3 = $dbresult3->FetchRow())
							{
								$onerow3 = new StdClass();
								$onerow3->joueur = $row2['joueur'];
								$onerow3->joueur = $row2['joueur'];
								$onerow3->joueur = $row2['joueur'];
								$onerow3->joueur = $row2['joueur'];
							}
						}
						*/
						
					$rowarray2[] = $onerow2;	
					}//fin du deuxième while
					
					$smarty->assign('prods_'.$i,$rowarray2);
					$smarty->assign('itemscount_'.$i, count($rowarray2));
					unset($rowarray2);
					//unset($$tab);
					$i++;	
					
				}//fin du $result2
				
			$rowarray[]  = $onerow;
			$smarty->assign('items', $rowarray);
				
		}//fin du premier while
				
		
	}//fin du if $result1
$smarty->assign('validation', 'Oui');	
$smarty->assign('indivs_courant',
		$this->CreateLink($id,'individuelles_prov',$returnid,'>> compétitions en cours de validation'));
$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
$smarty->assign('itemcount', count($rowarray));
$smarty->assign('items', $rowarray);				
//faire apparaitre les points totaux et somme victoire en bas ? Ce serait pas mal
/**/
echo $this->ProcessTemplate('individuelles3.tpl');


#
# EOF
#
?>