<?php
if( !isset($gCms) ) exit;
##############################################################
#              SPID                                          #
##############################################################
//debug_display($params, 'Parameters');

require_once(dirname(__FILE__).'/function.calculs.php');
$saison = $this->GetPreference('saison_en_cours');
if(isset($params['licence']) && $params['licence'] != '')
{
	$licence = $params['licence'];
	$db = cmsms()->GetDb();
	global $themeObject;
	$mois_courant = date('n');
	$jour = date('d');

	$parms = array();
	$query = "SELECT sp.id as record_id,CONCAT_WS(' ',j.nom, j.prenom) AS joueur,sp.licence, sp.date_event, sp.epreuve, sp.nom AS name, sp.classement,sp.statut, sp.victoire, sp.ecart, sp.coeff, sp.pointres, sp.forfait FROM ".cms_db_prefix()."module_ping_joueurs AS j, ".cms_db_prefix()."module_ping_parties_spid AS sp  WHERE j.licence = sp.licence AND j.licence = ? AND sp.saison = ? ";//"  GROUP BY joueur,type_compet ORDER BY joueur,type_compet";
	$query.=" AND MONTH(sp.date_event) = $mois_courant ";

	$dbresult= $db->Execute($query, array($licence,$saison));
	//echo $query2;
	$rowclass= 'row1';
	$rowarray= array ();
	if ($dbresult && $dbresult->RecordCount() > 0)
	  {
	    while ($row= $dbresult->FetchRow())
	    {
			$licence = $row['licence'];
			$onerow= new StdClass();
			$onerow->rowclass= $rowclass;
			$onerow->statut= $row['statut'];
			$onerow->record_id= $row['record_id'];
			$onerow->joueur= $row['joueur'];
			$onerow->date_event= $row['date_event'];
			$onerow->epreuve= $row['epreuve'];
			$onerow->name= $row['name'];
			$onerow->classement= $row['classement'];
			$onerow->victoire= $row['victoire'];
			$onerow->ecart= $row['ecart'];
			$onerow->coeff= $row['coeff'];
			$onerow->pointres= $row['pointres'];
			$onerow->forfait= $row['forfait'];
		
			($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
			$rowarray[]= $onerow;
	      }
	  }
	/**/

	$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
	$smarty->assign('itemcount', count($rowarray));
	$smarty->assign('items', $rowarray);

	$smarty->assign('form2start',
			$this->CreateFormStart($id,'mass_action',$returnid));
	$smarty->assign('form2end',
			$this->CreateFormEnd());
	$articles = array("Supprimer"=>"supp_spid");

	$smarty->assign('actiondemasse',
			$this->CreateInputDropdown($id,'actiondemasse',$articles));
	$smarty->assign('submit_massaction',
			$this->CreateInputSubmit($id,'submit_massaction',$this->Lang('apply_to_selection'),'','',$this->Lang('areyousure_actionmultiple')));


	//faire apparaitre les points totaux et somme victoire en bas ? Ce serait pas mal
		echo $this->ProcessTemplate('spid.tpl');
	
	
}
else
{
	
}

#
# EOF
#
?>
