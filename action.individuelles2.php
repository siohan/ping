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
$saison_courante = (isset($params['saison'])?$params['saison']:$this->GetPreference('saison_en_cours'));
//on établit la liste des compétitions individuelles du calendrier
$query1 = "SELECT * FROM ".cms_db_prefix()."module_ping_divisions AS dv LEFT JOIN ".cms_db_prefix()."module_ping_div_tours AS tours ON dv.idepreuve = tours.idepreuve WHERE dv.iddivision = tours.iddivision AND dv.saison  = '2015-2016'";
//il s'agit de compétitions individuelles ?
//$query1.=" AND tc.indivs = 1 ";
$parametres = 0;

$parms['saison'] = $saison_courante;

if(isset($params['idepreuve']) && $params['idepreuve'] != '')
{
	$idepreuve = $params['idepreuve'];
	$query1.= " AND dv.idepreuve = ?";
	$parms['idepreuve'] = $idepreuve;
}


//$query1.=" ORDER BY cal.date_debut DESC";

	$result1 = $db->Execute($query1,$parms);

	if($result1 && $result1->RecordCount()>0)
	{
		$rowclass= 'row1';
		$rowarray= array ();
		
		while($row1 = $result1->FetchRow())
		{
			//on récupère les résultats
			$idepreuve = $row1['idepreuve'];
			$tableau = $row1['tableau'];
			//on instancie ce qui va faire les entêtes
			$onerow= new StdClass();
			$onerow->rowclass= $rowclass;
			$onerow->idepreuve = $idepreuve;
			$onerow->iddivision = $row1['iddivision'];
			$onerow->tableau = $tableau;
			$onerow->valeur = $i;//très important pour les boucles
			
				$query2 = "SELECT * FROM ".cms_db_prefix()."module_ping_div_classement WHERE tableau = ?";
				echo $query2;
				$result2 = $db->Execute($query2, array($tableau));
				$lignes = $result2->RecordCount();
				$spid =0;
				//$onerow->spid = $spid;
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
						
							
						
							$onerow2->compteur = $compteur;
							
						
							$rowarray2[] = $onerow2;	
						}//fin du deuxième while
					
						$smarty->assign('prods_'.$i,$rowarray2);
						$smarty->assign('itemscount_'.$i, count($rowarray2));
						unset($rowarray2);
						//unset($$tab);
						$i++;	
					
					}//fin du $result2
				}
				
			unset($array);	
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
echo $this->ProcessTemplate('individuelles2.tpl');


#
# EOF
#
?>