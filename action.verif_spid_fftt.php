<?php
if(!isset($gCms)) exit;
$db =& $this->GetDb();
global $themeObject;
$designation = '';
require_once(dirname(__FILE__).'/include/prefs.php');
//$query = "SEL";
$query = "SELECT DISTINCT sp.id AS record_id,p.date_event AS date_fftt,p.codechamp,sp.date_event AS date_spid,sp.licence as licence_spid,sp.epreuve, p.licence as licence_fftt,sp.nom as nom_spid, p.advnompre AS nom_fftt, sp.numjourn AS numjourn_spid, p.numjourn AS numjourn_fftt, sp.victoire AS victoire_spid, p.vd AS victoire_fftt, sp.coeff AS coeff_spid, p.coefchamp AS coeff_fftt, sp.pointres AS points_spid, p.pointres AS points_fftt FROM ".cms_db_prefix()."module_ping_parties_spid AS sp, ".cms_db_prefix()."module_ping_parties AS p WHERE sp.licence = p.licence AND sp.nom = p.advnompre AND sp.date_event = p.date_event AND sp.victoire = p.vd AND sp.saison = ? AND sp.coeff != p.coefchamp ORDER BY sp.id ASC";
$dbresult = $db->Execute($query, array($saison_courante));
$rowarray = array();
	if($dbresult && $dbresult->RecordCount()>0)
	{
		while($row = $dbresult->FetchRow())
		{
			$onerow = new StdClass();
			$onerow->rowclass = $rowclass;
			$onerow->record_id = $row['record_id'];
			$onerow->date_spid = $row['date_spid'];
			$onerow->date_fftt = $row['date_fftt'];
			$onerow->epreuve = $row['epreuve'];
			$onerow->codechamp = $row['codechamp'];
			$onerow->licence_spid = $row['licence_spid'];
			$onerow->licence_fftt = $row['licence_fftt'];
			$onerow->nom_spid = $row['nom_spid'];
			$onerow->nom_fftt = $row['nom_fftt'];
			$onerow->numjourn_spid = $row['numjourn_spid'];
			$onerow->numjourn_fftt = $row['numjourn_fftt'];
			$onerow->victoire_spid = $row['victoire_spid'];
			$onerow->victoire_fftt = $row['victoire_fftt'];
			$onerow->coeff_spid = $row['coeff_spid'];
			$onerow->coeff_fftt = $row['coeff_fftt'];
			$onerow->points_spid = $row['points_spid'];
			$onerow->points_fftt = $row['points_fftt'];
			//$onerow->eraselink = $this->CreateLink($id, 'erase_spid', $returnid, $themeObject->DisplayImage('icons/system/edit.gif', $this->Lang('edit'), '', '', 'systemicon'), array("record_id"=>$row['id'], "coefchamp"=>$row['coeff_fftt'],"numjourn"=>$row['numjourn_fftt'], "vd"=>$row['victoire_fftt'], "pointres"=>$row['points_fftt']));
			
			
			($rowclass =="row1" ?$rowclass="row2":$rowclass="row1");
			$rowarray[] = $onerow;
			
		}
	}
	else
	{
		$designation.= "pas d'erreurs à corriger";
		$this->SetMessage("$designation");
		$this->RedirectToAdminTab('spid');
	}
$smarty->assign('items',$rowarray);
$smarty->assign('itemscount',count($rowarray));
$smarty->assign('itemsfoundtext', $this->Lang('resultsfoundtext'));
$smarty->assign('returnlink',
		$this->CreateReturnLink($id,$returnid,$contents = 'Retour'));
$smarty->assign('Corriger',
		$this->CreateLink($id,'cron_spid_fftt' , $returnid,$contents = 'Corriger tout'));
echo $this->ProcessTemplate ('verif.tpl');
#
#EOF
#
?>