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
$nom_equipes = $this->GetPreference('nom_equipes');
$saison_courante = (isset($params['saison'])?$params['saison']:$this->GetPreference('saison_en_cours'));
//on établit la liste des compétitions individuelles du calendrier
$query1 = "SELECT cal.date_debut,tc.name,cal.idepreuve AS id_ep,MONTH(cal.date_debut) AS mois_ref, cal.numjourn FROM ".cms_db_prefix()."module_ping_calendrier AS cal, ".cms_db_prefix()."module_ping_type_competitions AS tc WHERE cal.idepreuve = tc.idepreuve AND cal.saison = ?";
//il s'agit de compétitions individuelles ?
$query1.=" AND tc.indivs = 1 ";
$parametres = 0;
$i=0;

$parms['saison'] = $saison_courante;
if(isset($params['type_compet']) && $params['type_compet'] !='')
{
	$parametres++;
	$type_compet = $params['type_compet'];
	//on regarde si un N° de journée est en paramètre également
	$query1.=" AND tc.code_compet = ?";
	$parms['type_compet'] = $type_compet;
	
		
			
}
if(isset($params['idepreuve']) && $params['idepreuve'] != '')
{
	$idepreuve = $params['idepreuve'];
	$query1.= " AND tc.idepreuve = ?";
	$parms['idepreuve'] = $idepreuve;
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
/*
if(isset($params['tour']) && $params['tour'] !='')
{
	$parametres++;
	$tour = $params['tour'];
	
	$query1.=" AND cal.numjourn = ?";
	$parms['numjourn'] = $tour;
}
*/
$query1.=" ORDER BY cal.date_debut ASC";
//echo $query1;
	$result1 = $db->Execute($query1,$parms);
$lignes = $result1->RecordCount();
//echo "le nb de lignes est : ".$lignes;
	if($result1 && $result1->RecordCount()>0)
	{
		$rowclass= 'row1';
		$rowarray= array ();
		
		while($row1 = $result1->FetchRow())
		{
			//on récupère les résultats
			$i++;
			$date_debut = $row1['date_debut'];
			$date_fin = $row1['date_fin'];
			$numjourn = $row1['numjourn'];
			$name = $row1['name'];
			$idepreuve2 = $row1['id_ep'];
			//echo "le id de epreuve est : ".$idepreuve2;
			$mois_ref = $row1['mois_ref'];		
			
			//on instancie ce qui va faire les entêtes
			$onerow= new StdClass();
			$onerow->rowclass= $rowclass;
			$onerow->name = $name;
			$onerow->date_event = $date_debut;
			$onerow->idepreuve = $idepreuve2;
			$onerow->valeur = $i;//très important pour les boucles
			//echo "la valeur de i est : ".$i;
			
				//on est dans la FFTT
				//$query2 = "SELECT cla.idepreuve,cla.iddivision,dv.libelle,cla.tableau,cla.tour, cla.rang,cla.nom, cla.points  FROM ".cms_db_prefix()."module_ping_div_classement AS cla , ".cms_db_prefix()."module_ping_divisions AS dv WHERE dv.idepreuve = cla.idepreuve AND dv.iddivision = cla.iddivision AND dv.idepreuve = ? AND cla.club LIKE ? ";//AND dv.date_debut = ?";
				$query2 = "SELECT cla.idepreuve,cla.iddivision,dv.libelle,cla.tableau,cla.tour, cla.rang,cla.nom, cla.points  FROM ".cms_db_prefix()."module_ping_div_classement AS cla , ".cms_db_prefix()."module_ping_div_tours AS dv WHERE dv.idepreuve = cla.idepreuve AND dv.iddivision = cla.iddivision AND dv.tableau = cla.tableau AND dv.idepreuve = ? AND cla.club LIKE ? AND dv.date_debut = ?";
				//$query2 = "SELECT CONCAT_WS(' ', j.nom, j.prenom) AS joueur, j.licence, SUM(vd) AS vic, count(vd) AS sur, SUM(pointres) AS pts FROM ".cms_db_prefix()."module_ping_parties AS sp, ".cms_db_prefix()."module_ping_joueurs AS j  WHERE sp.licence = j.licence AND sp.date_event BETWEEN ? AND ?";
				$parms['idepreuve'] = $idepreuve2;
				$club = "%".$nom_equipes."%";		
				//$parms['club'] = '%'.$nom_equipes.'%';
				
				
				//echo $query2;
				$result2 = $db->Execute($query2,array($idepreuve2,$club,$date_debut));
				$query2.=" ORDER BY dv.libelle,cla.tour ASC";
				echo $query2;
				$lignes2 = $result2->RecordCount();	
				//echo "le nb de lignes2 est : ".$lignes2;
					if($result2 && $result2->RecordCount()>0)
					{
						$rowclass= 'row1';
						$rowarray2= array();
						$compteur = 0;
						
						//echo "le compteur est : ".$compteur;
						while($row2 = $result2->FetchRow())
						{
							//on récupère les résultats
							$idepreuve = $row2['idepreuve'];
							$iddivision = $row2['iddivision'];
							//nouvelle requete pour extraire le libellé du tableau, plus agréable et plus compréhensible
							$query3 = "SELECT libelle FROM ".cms_db_prefix()."module_ping_divisions WHERE idepreuve = ? AND iddivision = ?";
							$dbresult3 = $db->Execute($query3, array($idepreuve, $iddivision));
							$row3 = $dbresult3->FetchRow();
							$libelle2 = $row3['libelle'];
							$onerow2= new StdClass();
							$onerow2->rowclass= $rowclass;
							$onerow2->idepreuve = $row2['idepreuve'];
							$onerow2->libelle = $libelle2;//$row2['libelle'];
							$onerow2->iddivision = $row2['iddivision'];
							$onerow2->tableau = $row2['tableau'];
							$onerow2->rang= $row2['rang'];
							$onerow2->nom= $row2['nom'];
							$onerow2->tour= $row2['tour'];
							//$onerow2->points= $row2['points'];
							$onerow2->compteur = $compteur;
							$onerow2->details = $this->CreateFrontendLink($id, $returnid, 'details',$contents='Détails', array('record_id'=>$row2['tableau']));
							
							$rowarray2[]  = $onerow2;	
						}	

						
						$smarty->assign('prods_'.$i,$rowarray2);
						$smarty->assign('itemscount_'.$i, count($rowarray2));
						unset($rowarray2);
						

					}//fin du if $result1

			$rowarray[]  = $onerow;
									
		}
		$smarty->assign('items', $rowarray);
		//var_dump($rowarray);
		$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
		$smarty->assign('itemcount', count($rowarray));
		
	//	$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
	//	$smarty->assign('itemcount', count($rowarray));		
		
	}//fin du if $result1

echo $this->ProcessTemplate('individuelles3.tpl');


#
# EOF
#
?>