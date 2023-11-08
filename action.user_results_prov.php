<?php
if( !isset($gCms) ) exit;
//debug_display($params, 'Parameters');
$db = cmsms()->GetDb();
//global $themeObject;
require_once(dirname(__FILE__).'/include/prefs.php');
$licence = '';
$date_event = '';
$affiche = 1;
$saison = $this->GetPreference('saison_en_cours');
/*
if(isset($params['template']) && $params['template'] !="")
{
	$template = trim($params['template']);
}
else {
    $tpl = CmsLayoutTemplate::load_dflt_by_type('Ping::');
    if( !is_object($tpl) ) {
        audit('',$this->GetName(),'Template résultats pour une équipe introuvable');
        return;
    }
    $template = $tpl->get_name();
}
*/
	if(!isset($params['licence']) && $params['licence'] =='' )
	{
		echo "la licence est absente !";
		
	}
	else
	{
		$licence = $params['licence'];		
		
		$rowarray1 = array();
		$query = "SELECT SUM(victoire) AS vic, count(victoire) AS total, SUM(pointres) AS pts FROM ".cms_db_prefix()."module_ping_parties_spid WHERE licence = ?";
		$dbresult = $db->Execute($query, array($licence));

			if($dbresult && $dbresult->RecordCount()>0)
			{
				while($row1 = $dbresult->FetchRow())
				{
					$onerow1= new StdClass();
					$onerow1->rowclass= $rowclass;
					$onerow1->vic= $row1['vic'];
					$onerow1->total= $row1['total'];
					$onerow1->pts= $row1['pts'];
					($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
					$rowarray1[]= $onerow1;
				}
			}
		$smarty->assign('items1', $rowarray1);


		$query1 = "SELECT CONCAT_WS(' ', nom, prenom) AS joueur FROM ".cms_db_prefix()."module_ping_joueurs WHERE licence = ?";


		$dbresultat = $db->Execute($query1, array($licence));
		
		//faudrait tester si ça marche ou non
		if(!$dbresultat)
		{
			$designation = $db->ErrorMsg();
			ping_admin_ops::ecrirejournal('','KO',$designation,'');
		}
		
		$row1 = $dbresultat->FetchRow();
		$joueur = $row1['joueur'];
		$smarty->assign('joueur', $joueur);
		$result= array ();
		$query3= "SELECT nom, classement,pointres, victoire,date_event,epreuve,numjourn FROM ".cms_db_prefix()."module_ping_parties_spid WHERE saison = ? AND licence = ?";//" ORDER BY date_event ASC";
		$parms['licence'] = $licence;
		$parms['saison'] = $saison;
		if($affiche =='1')
		{
			if($this->GetPreference('phase_en_cours') =='1' )
			{
				if($params['phase'] ==2)
				{
					$query3.= " AND MONTH(date_event) >= 1 AND MONTH(date_event) <=7"; 
				}
				else
				{
					$query3.= " AND MONTH(date_event) > 7 AND MONTH(date_event) <=12";  ////BETWEEN NOW() AND (NOW() + INTERVAL 7 DAY)";
				}
			}
			elseif( $this->GetPreference('phase_en_cours') == '2')
			{
				if($params['phase'] ==1)
				{
					$query3.= " AND MONTH(date_event) > 7 AND MONTH(date_event) <=12";  ////BETWEEN NOW() AND (NOW() + INTERVAL 7 DAY)";
				}
				else
				{
					$query3.= " AND MONTH(date_event) >= 1 AND MONTH(date_event) <=7";  ////BETWEEN NOW() AND (NOW() + INTERVAL 7 DAY)";	
				}
			}
		}
		elseif($affiche =='0')
		{
			if($ok=='1')
			{
				$query3.=" AND MONTH(date_event) = ?";
				$parms['month'] = $month;
				$query3.=" ORDER BY date_event DESC";
				
			}
			else
			{
				$query3.=" AND date_event BETWEEN ? AND ?";
				$parms['date_debut'] = $date_debut;
				$parms['date_fin'] = $date_fin;
				$query3.=" ORDER BY date_event DESC";
				
			}
		}
		
		else
		{
			$query3.=" ORDER BY date_event DESC";
			
		}
		
		$dbresult3 = $db->Execute($query3, $parms);
	
		$rowarray= array ();

		if ($dbresult3 && $dbresult3->RecordCount() > 0)
		  {
		    while ($row= $dbresult3->FetchRow())
		      {
	
			$onerow= new StdClass();
			$onerow->rowclass= $rowclass;
			$onerow->date_event= $row['date_event'];
			$onerow->epreuve= $row['epreuve'];
			$onerow->nom= $row['nom'];
			$onerow->classement= $row['classement'];
			$onerow->victoire= $row['victoire'];
			//$onerow->coeff= $row['coeff'];
			$onerow->pointres= $row['pointres'];
			$rowarray[]= $onerow;
		      }
		  }
		$smarty->assign('resultats',
				$this->CreateLink($id,'user_results',$returnid,$contents = 'Tous ses résultats', array('licence'=>$licence)));
	}//fin du else (if $licence isset)

$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
$smarty->assign('ok',$ok);
$smarty->assign('itemcount', count($rowarray));
$smarty->assign('retour',
 		$this->CreateReturnLink($id, $returnid,'Retour'));
$smarty->assign('items', $rowarray);
$smarty->assign('affiche',$affiche);
//$tpl = $smarty->CreateTemplate($this->GetTemplateResource($template),null,null,$smarty);
//$tpl->display();
echo $this->ProcessTemplate('user_results_prov.tpl');


#
# EOF
#
?>
